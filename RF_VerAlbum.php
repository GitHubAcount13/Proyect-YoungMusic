<?php
require_once("conexion.php");

function obtenerDetallesAlbum($idAlbum)
{
    $conexion = conectar_bd();

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $consultaAlbum = "SELECT a.*, u.*, ar.*
                      FROM albun a 
                      JOIN usuarios u ON a.NomCred = u.Correo
                      JOIN artistas ar ON ar.CorrArti = u.Correo 
                      WHERE a.IdAlbum = ?";

    $stmtAlbum = $conexion->prepare($consultaAlbum);

    if (!$stmtAlbum) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmtAlbum->bind_param("i", $idAlbum);
    $stmtAlbum->execute();
    $resultado = $stmtAlbum->get_result();
    $album = $resultado->fetch_assoc();

    $stmtAlbum->close();
    $conexion->close();

    return $album;
}

function obtenerCancionesAlbum($albumId)
{
    $conexion = conectar_bd();

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $queryCanciones = "SELECT m.*, GROUP_CONCAT(g.GeneMusi SEPARATOR ', ') AS Generos 
                       FROM musica m 
                       LEFT JOIN generos g ON m.IdMusi = g.IdMusi 
                       WHERE m.Album = ? 
                       GROUP BY m.IdMusi 
                       ORDER BY m.IdMusi";
    $stmtCanciones = $conexion->prepare($queryCanciones);

    if (!$stmtCanciones) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmtCanciones->bind_param("i", $albumId);
    $stmtCanciones->execute();
    $resultado = $stmtCanciones->get_result();

    $canciones = array();
    while ($cancion = $resultado->fetch_assoc()) {
        $canciones[] = $cancion;
    }

    $stmtCanciones->close();
    $conexion->close();

    return $canciones;
}

// Función auxiliar para verificar si un álbum existe
function albumExiste($idAlbum)
{
    $conexion = conectar_bd();

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $consulta = "SELECT IdAlbum FROM albun WHERE IdAlbum = ?";
    $stmt = $conexion->prepare($consulta);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("i", $idAlbum);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $existe = $resultado->num_rows > 0;

    $stmt->close();
    $conexion->close();

    return $existe;
}