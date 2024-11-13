<?php
session_start();
require_once("conexion.php");
require("Funciones.php");
require_once("RF_Álbumes_YM.php");

if (!isset($_SESSION["email"])) {
    header("Location: Login_YM.php");
    exit();
}

$email = $_SESSION["email"];

// Verificar si el artista está verificado
$Consulta = "SELECT CorrArti FROM artistas WHERE CorrArti = ? AND Verificacion IS NOT NULL";
$Resultado = $con->prepare($Consulta);
$Resultado->bind_param("s", $email);
$Resultado->execute();
$Resultado->store_result();

if ($Resultado->num_rows == 0) {
    header("Location: Login_YM.php");
    exit();
}

$Resultado->close();

// Obtener datos del artista
$usuario = obtenerDatosArtista($email);

if ($usuario) {
    $nombre = $usuario["NombArtis"];
    $correo = $usuario["Correo"];
    $biografia = $usuario["Biografia"];
    $fotoPerfil = $usuario["FotoPerf"] ? $usuario["FotoPerf"] : 'Subida/';
} else {
    echo "Error al obtener los datos del usuario.";
    exit();
}

// Función para editar perfil
function procesarEdicionPerfil($email, $nuevoNombre, $nuevaBiografia, $nuevaFoto, $redes) {
    if (isset($_GET['password']) && verificarContrasena($email, $_GET['password'])) {
        if (editarPerfilArtista($email, $nuevoNombre, $nuevaBiografia, $nuevaFoto, $redes)) {
            header("Location: Artista_YM.php?mensaje=Perfil actualizado correctamente");
            exit();
        } else {
            header("Location: Artista_YM.php?error=Error al actualizar el perfil");
            exit();
        }
    } else {
        header("Location: Artista_YM.php?error=Contraseña incorrecta");
        exit();
    }
}

// Función para eliminar perfil
function procesarEliminacionPerfil($email) {
    if (isset($_GET['password']) && verificarContrasena($email, $_GET['password'])) {
        if (eliminarPerfil($email)) {
            session_destroy();
            header("Location: Registro_YM.php?mensaje=Perfil eliminado correctamente");
            exit();
        } else {
            header("Location: Artista_YM.php?error=Error al eliminar el perfil");
            exit();
        }
    } else {
        header("Location: Artista_YM.php?error=Contraseña incorrecta");
        exit();
    }
}

// Manejar las operaciones mediante GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['accion'])) {
        switch ($_GET['accion']) {
            case 'editar':
                procesarEdicionPerfil(
                    $email,
                    $_GET['nuevoNombre'],
                    $_GET['nuevaBiografia'],
                    $_FILES['nuevaFoto'] ?? null,
                    [
                        $_GET['Red1'] ?? '',
                        $_GET['Red2'] ?? '',
                        $_GET['Red3'] ?? '',
                        $_GET['Red4'] ?? ''
                    ]
                );
                break;

            case 'eliminar':
                procesarEliminacionPerfil($email);
                break;
        }
    }
}

// Obtener álbumes
$albumes = obtenerAlbumes($email);
?>