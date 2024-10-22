<?php
require_once("conexion.php");
require_once("Funciones.php");

if (!isset($_SESSION["email"])) {
    header("Location: Login_YM.php");
    exit();
}

if (!isset($_GET['correo'])) {
    header("Location: Login_YM.php");
    exit();
}
$correoArtista = isset($_GET['artist']) ? $_GET['artist'] : (isset($_SESSION["email"]) ? $_SESSION["email"] : null);
$correoArtista = $_GET['correo'];

$usuario = obtenerDatosArtista( $correoArtista);

if ($usuario) {
    $nombreA = $usuario["NombArtis"];
    $correoA = $usuario["Correo"];
    $biografiaA = $usuario["Biografia"];
    $fotoPerfilA = $usuario["FotoPerf"] ? $usuario["FotoPerf"] : 'Subida/';
} else {
    echo "Error al obtener los datos del usuario.";
    exit();
}
