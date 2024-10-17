<?php
session_start();
require_once("conexion.php");

if (!isset($_SESSION["email"])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

$response = ['success' => false, 'message' => ''];
$con = conectar_bd();

try {
    // Verificar límites según la categoría
    $album_id = $_POST['album_id'];
    $query = "SELECT Categoria, COUNT(m.IdMusi) as total_canciones 
              FROM albun a 
              LEFT JOIN musica m ON a.IdAlbum = m.Album 
              WHERE a.IdAlbum = ?
              GROUP BY a.IdAlbum";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $album_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $album_info = $result->fetch_assoc();

    $limite = ($album_info['Categoria'] === 'EP') ? 6 : (($album_info['Categoria'] === 'Sencillo') ? 1 : PHP_INT_MAX);

    if ($album_info['total_canciones'] >= $limite) {
        throw new Exception('Has alcanzado el límite de canciones para este álbum');
    }

    // Procesar archivos
    $directorio_musica = "Musica/Canciones/";
    $directorio_imagenes = "Musica/portadas/";


    // Subir archivo de música
    $nombre_archivo_musica = uniqid('music_') . '.' . pathinfo($_FILES['Archivo']['name'], PATHINFO_EXTENSION);
    $ruta_archivo_musica = $directorio_musica . $nombre_archivo_musica;

    // Subir imagen
    $nombre_archivo_imagen = uniqid('cover_') . '.' . pathinfo($_FILES['ImgMusi']['name'], PATHINFO_EXTENSION);
    $ruta_archivo_imagen = $directorio_imagenes . $nombre_archivo_imagen;

    if (!move_uploaded_file($_FILES['Archivo']['tmp_name'], $ruta_archivo_musica)) {
        throw new Exception('Error al subir el archivo de música');
    }

    if (!move_uploaded_file($_FILES['ImgMusi']['tmp_name'], $ruta_archivo_imagen)) {
        unlink($ruta_archivo_musica); // Eliminar archivo de música si la imagen falla
        throw new Exception('Error al subir la imagen');
    }

    // Insertar en la base de datos
    $query = "INSERT INTO musica (NomMusi, Archivo, Album, ImgMusi) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssis", $_POST['NomMusi'], $ruta_archivo_musica, $album_id, $ruta_archivo_imagen);
    $stmt->execute();
    
    $id_musica = mysqli_insert_id($con); // Obtener el ID de la canción recién insertada
    
    $generos_seleccionados = $_POST['Generos'];
    foreach ($generos_seleccionados as $genero) {
        $query = "INSERT INTO generos (IdMusi, GeneMusi) VALUES (?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("is", $id_musica, $genero);
        $stmt->execute();
    }
    
    $response['success'] = true;
    $response['message'] = 'Canción agregada exitosamente';

    if (!$stmt->execute()) {
        throw new Exception('Error al guardar en la base de datos');
    }

    $response['success'] = true;
    $response['message'] = 'Canción agregada exitosamente';
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    $con->close();
    header('Content-Type: application/json');
    echo json_encode($response);
}
