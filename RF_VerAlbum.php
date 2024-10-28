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
function agregarComentario($idAlbum, $correoUsuario, $comentario) {
    $conexion = conectar_bd();
    
    if (!$conexion) {
        throw new Exception("Error de conexión a la base de datos");
    }
    
    try {
        // Preparar la consulta
        $consulta = "INSERT INTO comentarios (IdAlbum, CorrUsu, Comentario) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($consulta);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
        }
        
        // Vincular parámetros
        $stmt->bind_param("iss", $idAlbum, $correoUsuario, $comentario);
        
        // Ejecutar la consulta
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        
        $stmt->close();
        $conexion->close();
        
        return true;
        
    } catch (Exception $e) {
        error_log("Error en agregarComentario: " . $e->getMessage());
        if (isset($stmt)) $stmt->close();
        if (isset($conexion)) $conexion->close();
        throw $e;
    }
}

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
function puedeEliminarComentario($comentarioId, $correoUsuario) {
    $conexion = conectar_bd();
    
    if (!$conexion) {
        throw new Exception("Error de conexión a la base de datos");
    }
    
    try {
        // Verificar si el usuario es admin (oyente con PermO no nulo)
        $consultaAdmin = "SELECT PermO FROM oyente WHERE CorrOyen = ?";
        $stmtAdmin = $conexion->prepare($consultaAdmin);
        $stmtAdmin->bind_param("s", $correoUsuario);
        $stmtAdmin->execute();
        $resultadoAdmin = $stmtAdmin->get_result();
        $esAdmin = false;
        
        if ($row = $resultadoAdmin->fetch_assoc()) {
            $esAdmin = $row['PermO'] !== null;
        }
        $stmtAdmin->close();

        // Verificar si el usuario es el creador del álbum
        $consultaCreador = "SELECT a.NomCred 
                           FROM comentarios c 
                           JOIN albun a ON c.IdAlbum = a.IdAlbum 
                           WHERE c.IdComentario = ?";
        $stmtCreador = $conexion->prepare($consultaCreador);
        $stmtCreador->bind_param("i", $comentarioId);
        $stmtCreador->execute();
        $resultadoCreador = $stmtCreador->get_result();
        $esCreador = false;
        
        if ($row = $resultadoCreador->fetch_assoc()) {
            $esCreador = ($row['NomCred'] === $correoUsuario);
        }
        $stmtCreador->close();

        // Verificar si el usuario es el autor del comentario
        $consultaAutor = "SELECT CorrUsu FROM comentarios WHERE IdComentario = ?";
        $stmtAutor = $conexion->prepare($consultaAutor);
        $stmtAutor->bind_param("i", $comentarioId);
        $stmtAutor->execute();
        $resultadoAutor = $stmtAutor->get_result();
        $esAutor = false;
        
        if ($row = $resultadoAutor->fetch_assoc()) {
            $esAutor = ($row['CorrUsu'] === $correoUsuario);
        }
        $stmtAutor->close();

        $conexion->close();
        
        return $esAdmin || $esCreador || $esAutor;
        
    } catch (Exception $e) {
        if (isset($conexion)) $conexion->close();
        throw $e;
    }
}

function eliminarComentario($comentarioId, $correoUsuario) {
    $conexion = conectar_bd();
    
    if (!$conexion) {
        throw new Exception("Error de conexión a la base de datos");
    }
    
    try {
        // Primero verificar si el usuario tiene permiso para eliminar
        if (!puedeEliminarComentario($comentarioId, $correoUsuario)) {
            throw new Exception("No tienes permiso para eliminar este comentario");
        }
        
        // Si tiene permiso, proceder con la eliminación
        $consulta = "DELETE FROM comentarios WHERE IdComentario = ?";
        $stmt = $conexion->prepare($consulta);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta");
        }
        
        $stmt->bind_param("i", $comentarioId);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            throw new Exception("Error al eliminar el comentario");
        }
        
        $stmt->close();
        $conexion->close();
        
        return true;
        
    } catch (Exception $e) {
        if (isset($stmt)) $stmt->close();
        if (isset($conexion)) $conexion->close();
        throw $e;
    }
}

function obtenerComentarios($idAlbum, $correoUsuarioActual = null) {
    $conexion = conectar_bd();
    
    if (!$conexion) {
        throw new Exception("Error de conexión a la base de datos");
    }
    
    try {
        // Obtener información de los comentarios
        $consulta = "SELECT c.*, u.NomrUsua, u.FotoPerf, a.NomCred as CreadorAlbum
                     FROM comentarios c 
                     JOIN usuarios u ON c.CorrUsu = u.Correo 
                     JOIN albun a ON c.IdAlbum = a.IdAlbum
                     WHERE c.IdAlbum = ? 
                     ORDER BY c.FechaCom DESC";
        
        $stmt = $conexion->prepare($consulta);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
        }
        
        $stmt->bind_param("i", $idAlbum);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $comentarios = array();
        
        // Si hay un usuario logueado, verificar sus permisos
        $esAdmin = false;
        if ($correoUsuarioActual) {
            $consultaAdmin = "SELECT PermO FROM oyente WHERE CorrOyen = ?";
            $stmtAdmin = $conexion->prepare($consultaAdmin);
            $stmtAdmin->bind_param("s", $correoUsuarioActual);
            $stmtAdmin->execute();
            $resultadoAdmin = $stmtAdmin->get_result();
            if ($row = $resultadoAdmin->fetch_assoc()) {
                $esAdmin = ($row['PermO'] !== null);
            }
            $stmtAdmin->close();
        }
        
        while ($comentario = $resultado->fetch_assoc()) {
            // Determinar si el usuario actual puede eliminar este comentario
            $puedeEliminar = false;
            if ($correoUsuarioActual) {
                $puedeEliminar = $esAdmin || 
                                $correoUsuarioActual === $comentario['CorrUsu'] ||
                                $correoUsuarioActual === $comentario['CreadorAlbum'];
            }
            
            $comentario['puedeEliminar'] = $puedeEliminar;
            $comentarios[] = $comentario;
        }
        
        $stmt->close();
        $conexion->close();
        
        return $comentarios;
        
    } catch (Exception $e) {
        error_log("Error en obtenerComentarios: " . $e->getMessage());
        if (isset($stmt)) $stmt->close();
        if (isset($conexion)) $conexion->close();
        return array();
    }
}
?>
