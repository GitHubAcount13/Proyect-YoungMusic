<?php
require_once("conexion.php");
require_once("Funciones.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email']) || !isset($_POST['albumId'])) {
        echo json_encode(['success' => false, 'message' => 'No autorizado']);
        exit;
    }

    $albumId = intval($_POST['albumId']);
    $con = conectar_bd();
    
    // Verificar permisos
    $query = "SELECT CorrArti FROM albun WHERE IdAlbum = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $albumId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $album = mysqli_fetch_assoc($result);
    
    if (!$album || !puedeEliminarAlbum($_SESSION['email'], $album['CorrArti'])) {
        echo json_encode(['success' => false, 'message' => 'No tienes permiso para eliminar este álbum']);
        exit;
    }

    try {
        EliminarAlbum($albumId, $con);
        echo json_encode(['success' => true, 'message' => 'Álbum eliminado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el álbum: ' . $e->getMessage()]);
    }

    mysqli_close($con);
    exit;
}
?>