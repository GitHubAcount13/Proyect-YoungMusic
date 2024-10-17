<?php
session_start();
require_once("conexion.php");

if (!isset($_SESSION["email"])) {
    header("Location: Login_YM.php");
    exit();
}

$con = conectar_bd();

// Validación del artista
$email = $_SESSION["email"];
$consulta = "SELECT CorrArti FROM artistas WHERE CorrArti = ? AND Verificacion IS NOT NULL";
$stmt = $con->prepare($consulta);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    header("Location: Login_YM.php");
    exit();
}

$stmt->close();

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreAlbum = $_POST['NomAlbum'];
    $categoria = $_POST['Categoria'];
    $fechaLanzamiento = $_POST['FechaLan'];
    $nomCred = $email;

    // Subir imagen de la portada
    $directorio = "Albumes/";

    $nombreImagen = uniqid('album_') . '.' . pathinfo($_FILES['ImgAlbu']['name'], PATHINFO_EXTENSION);
    $rutaImagen = $directorio . $nombreImagen;

    if (move_uploaded_file($_FILES['ImgAlbu']['tmp_name'], $rutaImagen)) {
        // Insertar datos en la base de datos
        $consulta = "INSERT INTO albun (NomAlbum, Categoria, FechaLan, ImgAlbu, NomCred) 
                     VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($consulta);
        $stmt->bind_param("sssss", $nombreAlbum, $categoria, $fechaLanzamiento, $rutaImagen, $nomCred);

        if ($stmt->execute()) {
            $id_insertado = $con->insert_id;
            // Redireccionar a la página de subida de música con el ID del álbum
            header("Location: Subida_Musica.php?album=" . $id_insertado . "&categoria=" . $categoria);
            exit();
        } else {
            echo "Error al subir el álbum: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error al subir la imagen de la portada.";
    }
}

$con->close();
