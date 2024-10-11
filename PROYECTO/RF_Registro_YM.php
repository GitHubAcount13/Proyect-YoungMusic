<?php
require_once("conexion.php");
require("Funciones.php");

$con = conectar_bd();

if (isset($_POST["envio"])) {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $contrasenia = $_POST["pass"];
    $ubicacion = $_POST["Ubicación"];
    $biografia = $_POST["biografia"];

    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $tipoArchivo = $_FILES["file"]["type"];
        $tamañoArchivo = $_FILES["file"]["size"];
        $rutaTemporal = $_FILES["file"]["tmp_name"];

        if (strpos($tipoArchivo, "image") !== false && $tamañoArchivo <= 2000000) {
            $carpetaDestino = "Subida/";
            $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $nombreArchivoUnico = "imagen_" . uniqid() . "." . $extension;
            $fotoPerfil  = $carpetaDestino . $nombreArchivoUnico;

            if (move_uploaded_file($rutaTemporal, $fotoPerfil)) {
                echo "Archivo subido con éxito.";
            } else {
                echo "Error al subir el archivo.";
                exit;
            }
        } else {
            echo "Archivo no válido o demasiado grande.";
            exit;
        }
    } else {
        echo "No se subió ninguna foto de perfil.";
        $fotoPerfil  = null;
    }

    $existe_usr = consultar_existe_usr($con, $tabla='usuarios',$columna='Correo', $email);
    insertar_datos($con, $nombre, $email, $contrasenia, $ubicacion, $biografia, $fotoPerfil, $existe_usr);
    
}

