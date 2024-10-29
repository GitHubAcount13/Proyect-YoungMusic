<?php
require_once("conexion.php");
require_once("Funciones.php");
require_once("RF_Álbumes_YM.php");

if (!isset($_SESSION["email"])) {
    header("Location: Login_YM.php");
    exit();
}

if (!isset($_GET['correo'])) {
    header("Location: Login_YM.php");
    exit();
}

$correoArtista = $_GET['correo'];
$correoOyente = $_SESSION["email"];

// Obtener datos del artista
$usuario = obtenerDatosArtista($correoArtista);
$tipoPerfil = 'oyente';

if ($usuario) {
    $nombreA = $usuario["NombArtis"];
    $correoA = $usuario["Correo"];
    $biografiaA = $usuario["Biografia"];
    $fotoPerfilA = $usuario["FotoPerf"] ? $usuario["FotoPerf"] : 'Subida/';
    $tipoPerfil = 'artista';
} else {
    $usuario = obtenerDatosDisco($correoArtista);
    if ($usuario) {
        $nombreA = $usuario["NombDisc"];
        $correoA = $usuario["Correo"];
        $biografiaA = $usuario["Biografia"];
        $fotoPerfilA = $usuario["FotoPerf"] ? $usuario["FotoPerf"] : 'Subida/';
        $tipoPerfil = 'discografica';
    } else {
        $usuario = obtenerDatosUsuario($correoArtista);
        if ($usuario) {
            $nombreA = $usuario["NomrUsua"];
            $correoA = $usuario["Correo"];
            $fotoPerfilA = $usuario["FotoPerf"] ? $usuario["FotoPerf"] : 'Subida/';
            $tipoPerfil = 'oyente';
        } else {
            echo "Error al obtener los datos del usuario.";
            exit();
        }
    }
}

// Obtener álbumes si es artista
$albumes = ($tipoPerfil === 'artista') ? obtenerAlbumes($correoArtista) : [];

// Verificar si sigue al artista
$sigueAlArtista = false;
if ($tipoPerfil === 'artista') {
    $stmt = $con->prepare("SELECT * FROM sigue WHERE CorrArti = ? AND CorrOyen = ?");
    $stmt->bind_param("ss", $correoArtista, $correoOyente);
    $stmt->execute();
    $result = $stmt->get_result();
    $sigueAlArtista = ($result->num_rows > 0);
    $stmt->close();
}

// Procesar la eliminación del perfil si se solicita
if (isset($_POST['eliminarPerfil'])) {
    if (eliminarPerfil($correoArtista)) {
        header("Location: Home_YM.php?mensaje=perfil_eliminado");
        exit();
    } else {
        $errorEliminacion = "Error al eliminar el perfil.";
    }
}


?>