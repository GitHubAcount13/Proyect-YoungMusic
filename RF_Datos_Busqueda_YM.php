<?php
session_start();
require_once("conexion.php");
require("Funciones.php");

if (!isset($_SESSION["email"])) {
    header("Location: Login_YM.php");
    exit();
}

$email = $_SESSION["email"];

$Consulta = "SELECT CorrArti FROM artistas WHERE CorrArti = ? AND Verificacion IS NOT NULL";
$ResultadoA = $con->prepare($Consulta);
$ResultadoA->bind_param("s", $email);
$ResultadoA->execute();
$ResultadoA->store_result();

if ($ResultadoA->num_rows != 0) {
    $email = $_SESSION["email"];
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
$ResultadoA->close();
}


$Consulta = "SELECT CorrOyen FROM oyente WHERE CorrOyen = ?";
$Resultado = $con->prepare($Consulta);
$Resultado->bind_param("s", $email);
$Resultado->execute();
$Resultado->store_result();

if ($Resultado->num_rows != 0) {

    $email = $_SESSION["email"];
    $usuario = obtenerDatosUsuario($email);
    
    if ($usuario) {
        $nombre = $usuario["NomrUsua"];
        $correo = $usuario["Correo"];
        $biografia = $usuario["Biografia"];
        $fotoPerfil = $usuario["FotoPerf"] ? $usuario["FotoPerf"] : 'Subida/';
    } else {
        echo "Error al obtener los datos del usuario.";
        exit();
    }
$Resultado->close();
} else {

    $email = $_SESSION["email"];
    $usuario = obtenerDatosUsuario($email);
    
    if ($usuario) {
        $nombre = $usuario["NomrUsua"];
        $correo = $usuario["Correo"];
        $biografia = $usuario["Biografia"];
        $fotoPerfil = $usuario["FotoPerf"] ? $usuario["FotoPerf"] : 'Subida/';
    } else {
        echo "Error al obtener los datos del usuario.";
        exit();
    }

    $Resultado->close();
}



