<?php
require_once("conexion.php");
require_once("Funciones.php");


// Actualizar procesar_comentario.php para manejar el borrado:
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (!isset($_POST['commentId'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID de comentario no proporcionado'
        ]);
        exit;
    }
    
    try {
        $commentId = intval($_POST['commentId']);
        if (eliminarComentario($commentId, $_SESSION["email"])) {
            echo json_encode([
                'success' => true,
                'message' => 'Comentario eliminado correctamente'
            ]);
        } else {
            throw new Exception('Error al eliminar el comentario');
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}



?>