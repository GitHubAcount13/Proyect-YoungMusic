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
$correoOyente = $_SESSION["email"];  // Correo del usuario logueado

// Obtener datos del artista y tipo de usuario
$usuario = obtenerDatosArtista($correoArtista);
$tipoPerfil = 'oyente';  // Valor predeterminado

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
$albumes = ($tipoPerfil === 'artista') ? obtenerAlbumes($correoArtista) : [];

// Verificar si ya sigue al artista (solo si es un artista)
$sigueAlArtista = false;
if ($tipoPerfil === 'artista') {
    $stmt = $con->prepare("SELECT * FROM sigue WHERE CorrArti = ? AND CorrOyen = ?");
    $stmt->bind_param("ss", $correoArtista, $correoOyente);
    $stmt->execute();
    $result = $stmt->get_result();
    $sigueAlArtista = ($result->num_rows > 0);
    $stmt->close();
}

$con->close();
