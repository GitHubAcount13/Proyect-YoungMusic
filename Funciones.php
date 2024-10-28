<?php
require_once("conexion.php");
require("Conexion_Cloud.php");
require 'vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;

function logear($con, $email, $pass, $redirect = "Usuario_YM.php")
{
    session_start();
    $consulta_login = "SELECT * FROM usuarios WHERE Correo = '$email'";
    $resultado_login = mysqli_query($con, $consulta_login);

    if (mysqli_num_rows($resultado_login) > 0) {
        $fila = mysqli_fetch_assoc($resultado_login);
        $password_bd = $fila["Contra"];

        if (password_verify($pass, $password_bd)) {
            $_SESSION["email"] = $email;
            header("Location: $redirect");
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    mysqli_close($con);
}


function consultar_existe_usr($con, $tabla, $columna, $email)
{

    $email = mysqli_real_escape_string($con, $email);


    $consulta_existe_dato = "SELECT $columna FROM $tabla WHERE $columna = '$email'";


    $resultado_existe_dato = mysqli_query($con, $consulta_existe_dato);


    return mysqli_num_rows($resultado_existe_dato) > 0;
}


function insertar_datos($con, $nombre, $email, $contrasenia, $ubicacion, $biografia, $fotoPerfil, $existe_usr)
{
    if (!$existe_usr) {
        $email = mysqli_real_escape_string($con, $email);
        $contraseniaH = password_hash($contrasenia, PASSWORD_DEFAULT);

        $consulta_insertar = "INSERT INTO usuarios (NomrUsua, Correo, Contra, Locacion, Biografia, FotoPerf) 
                                VALUES ('$nombre', '$email', '$contraseniaH', '$ubicacion', '$biografia', '$fotoPerfil')";

        if (mysqli_query($con, $consulta_insertar)) {
            echo "Usuario registrado con éxito.";
            logear($con, $email, $contrasenia, "Preferencias_Usr.php");
            exit();
        } else {
            echo "Error: " . $consulta_insertar . "<br>" . mysqli_error($con);
        }
    } else {
        echo "El usuario ya existe.";
    }
}

function insertar_usr($con, $tabla, $columnas, $valores, $existe_usr)
{
    if (!$existe_usr) {

        foreach ($valores as &$valor) {
            $valor = mysqli_real_escape_string($con, $valor);
        }


        $placeholders = implode(', ', array_fill(0, count($valores), '?'));


        $consulta_insertar = "INSERT INTO $tabla ($columnas) VALUES ($placeholders)";


        $stmt = $con->prepare($consulta_insertar);

        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $con->error);
        }


        $types = str_repeat('s', count($valores));


        $stmt->bind_param($types, ...$valores);


        if ($stmt->execute()) {
            echo "Datos insertados con éxito.";
        } else {
            echo "Error: " . $stmt->error;
        }


        $stmt->close();
    } else {
        echo "El usuario ya existe.";
    }
}

function obtenerDatosUsuario($email)
{
    $con = conectar_bd();
    $email = mysqli_real_escape_string($con, $email);
    $consulta = "SELECT * FROM usuarios WHERE Correo = '$email'";
    $resultado = mysqli_query($con, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        mysqli_close($con);
        return $usuario;
    } else {
        mysqli_close($con);
        return false;
    }
}
function obtenerDatosDisco($email)
{
    $con = conectar_bd();
    $email = mysqli_real_escape_string($con, $email);

    // Consulta para obtener datos de la discográfica
    $consulta = "SELECT * FROM usuarios 
                 INNER JOIN discografica ON discografica.CorrDisc = usuarios.Correo 
                 WHERE Correo = '$email'";
    $resultado = mysqli_query($con, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Inicializar las variables de redes sociales
        $Instagram = $Youtube = $TikTok = $Spotify = '';

        // Consulta para obtener redes sociales de la discográfica
        $consulta = "SELECT * FROM redesd WHERE CorrDisc = '$email'";
        $resultado_Redes = mysqli_query($con, $consulta);

        if ($resultado_Redes && mysqli_num_rows($resultado_Redes) > 0) {
            $Redes = mysqli_fetch_assoc($resultado_Redes);
            $Instagram = $Redes['Instagram'];
            $Youtube = $Redes['Youtube'];
            $TikTok = $Redes['TikTok'];
            $Spotify = $Redes['Spotify'];
        }

        $usuario['Instagram'] = $Instagram;
        $usuario['Youtube'] = $Youtube;
        $usuario['TikTok'] = $TikTok;
        $usuario['Spotify'] = $Spotify;

        mysqli_close($con);
        return $usuario;
    } else {
        mysqli_close($con);
        return false;
    }
}
function obtenerDatosArtista($email)
{
    $con = conectar_bd();
    $email = mysqli_real_escape_string($con, $email);

    // Consulta para obtener datos del artista
    $consulta = "SELECT * FROM usuarios 
                     INNER JOIN artistas ON artistas.CorrArti = usuarios.Correo 
                     WHERE Correo = '$email'";
    $resultado = mysqli_query($con, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Consulta para obtener instrumentos del artista
        $consulta_instrumentos = "SELECT NomInst FROM instrumento WHERE CorrArti = '$email'";
        $resultado_instrumentos = mysqli_query($con, $consulta_instrumentos);

        $instrumentos = [];
        if ($resultado_instrumentos && mysqli_num_rows($resultado_instrumentos) > 0) {
            while ($row = mysqli_fetch_assoc($resultado_instrumentos)) {
                $instrumentos[] = $row['NomInst'];
            }
        }

        // Añadir instrumentos al array de usuario
        $usuario['instrumentos'] = $instrumentos;

        // Consulta para obtener redes sociales del artista

        $consulta = "SELECT * FROM redesa WHERE CorrArti = '$email'";
        $resultado_Redes = mysqli_query($con, $consulta);

        if ($resultado_Redes && mysqli_num_rows($resultado_Redes) > 0) {
            $Redes = mysqli_fetch_assoc($resultado_Redes);
            $Instagram = $Redes['Instagram'];
            $Youtube = $Redes['Youtube'];
            $TikTok  = $Redes['TikTok'];
            $Spotify = $Redes['Spotify'];
        }
        $usuario['Instagram'] = $Instagram;
        $usuario['Youtube'] = $Youtube;
        $usuario['TikTok'] = $TikTok;
        $usuario['Spotify'] = $Spotify;

        mysqli_close($con);
        return $usuario;
    } else {
        mysqli_close($con);
        return false;
    }
}

function verificarContrasena($email, $password)
{
    $con = conectar_bd();
    $email = mysqli_real_escape_string($con, $email);
    $consulta = "SELECT Contra FROM usuarios WHERE Correo = '$email'";
    $resultado = mysqli_query($con, $consulta);
    $usuario = mysqli_fetch_assoc($resultado);
    mysqli_close($con);
    return password_verify($password, $usuario['Contra']);
}

function editarPerfil($email, $nuevoNombre, $nuevaBiografia, $nuevaFoto)
{
    $con = conectar_bd();
    $email = mysqli_real_escape_string($con, $email);
    $nuevoNombre = mysqli_real_escape_string($con, $nuevoNombre);
    $nuevaBiografia = mysqli_real_escape_string($con, $nuevaBiografia);

    $fotoGuardada = "";
    if (!empty($nuevaFoto['name'])) {
        try {
            // Primero, obtener la foto actual del usuario
            $consultaFoto = "SELECT FotoPerf FROM usuarios WHERE Correo = '$email'";
            $resultadoFoto = mysqli_query($con, $consultaFoto);
            $fotoActual = mysqli_fetch_assoc($resultadoFoto);

            // Si existe una foto anterior, eliminarla de Cloudinary
            if (!empty($fotoActual['FotoPerf']) && strpos($fotoActual['FotoPerf'], 'cloudinary') !== false) {
                try {
                    // Extraer el public_id de la URL
                    $urlPartes = explode('/', $fotoActual['FotoPerf']);
                    $nombreArchivo = end($urlPartes);
                    $publicId = 'Subida/' . pathinfo($nombreArchivo, PATHINFO_FILENAME);

                    // Eliminar la imagen anterior
                    $admin = new AdminApi();
                    $admin->deleteAssets($publicId);
                } catch (Exception $e) {
                    error_log("Advertencia: No se pudo eliminar la imagen anterior: " . $e->getMessage());
                    // Continuamos con la ejecución aunque falle la eliminación
                }
            }

            // Subir la nueva imagen a Cloudinary
            $resultado = (new UploadApi())->upload($nuevaFoto['tmp_name'], [
                "folder" => "Subida/",  // Carpeta en Cloudinary
                "public_id" => "imagen_" . uniqid(),  // Nombre único
                "resource_type" => "image"
            ]);

            // Obtener la URL de la imagen subida
            $fotoGuardada = ", FotoPerf = '" . $resultado['secure_url'] . "'";
            
            // Verificar si existe una foto local antigua y eliminarla
            if (!empty($fotoActual['FotoPerf']) && file_exists($fotoActual['FotoPerf']) && strpos($fotoActual['FotoPerf'], 'Subida/') === 0) {
                unlink($fotoActual['FotoPerf']);
            }

        } catch (Exception $e) {
            error_log("Error al subir la foto a Cloudinary: " . $e->getMessage());
            return false;
        }
    }

    $consulta = "UPDATE usuarios SET NomrUsua = '$nuevoNombre', Biografia = '$nuevaBiografia' $fotoGuardada WHERE Correo = '$email'";
    $resultado = mysqli_query($con, $consulta);
    
    mysqli_close($con);
    return $resultado;
}


function editarPerfilArtista($email, $nuevoNombre, $nuevaBiografia, $nuevaFoto, $redes)
{
    $con = conectar_bd();
    $email = mysqli_real_escape_string($con, $email);
    $nuevoNombre = mysqli_real_escape_string($con, $nuevoNombre);
    $nuevaBiografia = mysqli_real_escape_string($con, $nuevaBiografia);

    $fotoGuardada = "";
    if (!empty($nuevaFoto['name'])) {
        try {
            // Primero, obtener la foto actual del usuario
            $consultaFoto = "SELECT FotoPerf FROM usuarios WHERE Correo = '$email'";
            $resultadoFoto = mysqli_query($con, $consultaFoto);
            $fotoActual = mysqli_fetch_assoc($resultadoFoto);

            // Si existe una foto anterior, eliminarla de Cloudinary
            if (!empty($fotoActual['FotoPerf'])) {
                try {
                    // Extraer el public_id de la URL
                    $urlPartes = explode('/', $fotoActual['FotoPerf']);
                    $nombreArchivo = end($urlPartes);
                    $publicId = 'Subida/' . pathinfo($nombreArchivo, PATHINFO_FILENAME);

                    // Eliminar la imagen anterior
                    $admin = new AdminApi();
                    $admin->deleteAssets($publicId);
                } catch (Exception $e) {
                    echo "Advertencia: No se pudo eliminar la imagen anterior: " . $e->getMessage();
                    // Continuamos con la ejecución aunque falle la eliminación
                }
            }

            // Subir la nueva imagen a Cloudinary
            $resultado = (new UploadApi())->upload($nuevaFoto['tmp_name'], [
                "folder" => "Subida/",  // Carpeta en Cloudinary
                "public_id" => "imagen_" . uniqid(),  // Nombre único
                "resource_type" => "image"
            ]);

            // Obtener la URL de la imagen subida
            $fotoGuardada = ", FotoPerf = '" . $resultado['secure_url'] . "'";
            echo "Foto de perfil actualizada exitosamente en Cloudinary.";
        } catch (Exception $e) {
            echo "Error al subir la foto a Cloudinary: " . $e->getMessage();
            return false;
        }
    }

    // Actualizar los datos del usuario
    $consulta = "UPDATE usuarios SET NomrUsua = '$nuevoNombre', Biografia = '$nuevaBiografia' $fotoGuardada WHERE Correo = '$email'";
    $resultado = mysqli_query($con, $consulta);

    if ($resultado) {
        // Verificar si las redes ya existen o se deben insertar
        $consultaRedes = "SELECT * FROM redesa WHERE CorrArti = '$email'";
        $resultadoRedes = mysqli_query($con, $consultaRedes);

        if (mysqli_num_rows($resultadoRedes) == 0) {
            // Si no existen registros de redes sociales, las insertamos
            $insertRedes = "INSERT INTO `redesa`(`CorrArti`, `Instagram`, `Youtube`, `Spotify`, `TikTok`) 
                            VALUES ('$email', '{$redes[0]}', '{$redes[1]}', '{$redes[2]}', '{$redes[3]}')";
            mysqli_query($con, $insertRedes);
        } else {
            // Si ya existen registros de redes sociales, las actualizamos
            $updateRedes = "UPDATE `redesa` SET 
                            `Instagram` = '{$redes[0]}', 
                            `Youtube` = '{$redes[1]}', 
                            `Spotify` = '{$redes[2]}', 
                            `TikTok` = '{$redes[3]}'
                            WHERE `CorrArti` = '$email'";
            mysqli_query($con, $updateRedes);
        }
    } else {
        echo "Error al actualizar el perfil del artista.";
        return false;
    }

    mysqli_close($con);
    return $resultado;
}

function editarPerfilDisco($email, $nuevoNombre, $nuevaBiografia, $nuevaFoto, $redes)
{
    $con = conectar_bd();
    $email = mysqli_real_escape_string($con, $email);
    $nuevoNombre = mysqli_real_escape_string($con, $nuevoNombre);
    $nuevaBiografia = mysqli_real_escape_string($con, $nuevaBiografia);

    $fotoGuardada = "";
    if (!empty($nuevaFoto['name'])) {
        try {
            // Primero, obtener la foto actual del usuario
            $consultaFoto = "SELECT FotoPerf FROM usuarios WHERE Correo = '$email'";
            $resultadoFoto = mysqli_query($con, $consultaFoto);
            $fotoActual = mysqli_fetch_assoc($resultadoFoto);

            // Si existe una foto anterior, eliminarla de Cloudinary
            if (!empty($fotoActual['FotoPerf'])) {
                try {
                    // Extraer el public_id de la URL
                    $urlPartes = explode('/', $fotoActual['FotoPerf']);
                    $nombreArchivo = end($urlPartes);
                    $publicId = 'Subida/' . pathinfo($nombreArchivo, PATHINFO_FILENAME);

                    // Eliminar la imagen anterior
                    $admin = new AdminApi();
                    $admin->deleteAssets($publicId);
                } catch (Exception $e) {
                    echo "Advertencia: No se pudo eliminar la imagen anterior: " . $e->getMessage();
                    // Continuamos con la ejecución aunque falle la eliminación
                }
            }

            // Subir la nueva imagen a Cloudinary
            $resultado = (new UploadApi())->upload($nuevaFoto['tmp_name'], [
                "folder" => "Subida/",  // Carpeta en Cloudinary
                "public_id" => "imagen_" . uniqid(),  // Nombre único
                "resource_type" => "image"
            ]);

            // Obtener la URL de la imagen subida
            $fotoGuardada = ", FotoPerf = '" . $resultado['secure_url'] . "'";
            echo "Foto de perfil actualizada exitosamente en Cloudinary.";
        } catch (Exception $e) {
            echo "Error al subir la foto a Cloudinary: " . $e->getMessage();
            return false;
        }
    }

    // Actualizar los datos del usuario
    $consulta = "UPDATE usuarios SET NomrUsua = '$nuevoNombre', Biografia = '$nuevaBiografia' $fotoGuardada WHERE Correo = '$email'";
    $resultado = mysqli_query($con, $consulta);

    if ($resultado) {
        // Verificar si las redes ya existen o se deben insertar
        $consultaRedes = "SELECT * FROM redesd WHERE CorrDisc = '$email'";
        $resultadoRedes = mysqli_query($con, $consultaRedes);

        if (mysqli_num_rows($resultadoRedes) == 0) {
            // Si no existen registros de redes sociales, las insertamos
            $insertRedes = "INSERT INTO `redesd`(`CorrDisc`, `Instagram`, `Youtube`, `Spotify`, `TikTok`) 
                            VALUES ('$email', '{$redes[0]}', '{$redes[1]}', '{$redes[2]}', '{$redes[3]}')";
            mysqli_query($con, $insertRedes);
        } else {
            // Si ya existen registros de redes sociales, las actualizamos
            $updateRedes = "UPDATE `redesd` SET 
                            `Instagram` = '{$redes[0]}', 
                            `Youtube` = '{$redes[1]}', 
                            `Spotify` = '{$redes[2]}', 
                            `TikTok` = '{$redes[3]}'
                            WHERE `CorrDisc` = '$email'";
            mysqli_query($con, $updateRedes);
        }
    } else {
        echo "Error al actualizar el perfil del artista.";
        return false;
    }

    mysqli_close($con);
    return $resultado;
}


function eliminarPerfil($email)
{
    $con = conectar_bd();
    $email = mysqli_real_escape_string($con, $email);
    
    // Primero, obtener la foto actual del usuario
    $consultaFoto = "SELECT FotoPerf FROM usuarios WHERE Correo = '$email'";
    $resultadoFoto = mysqli_query($con, $consultaFoto);
    $fotoActual = mysqli_fetch_assoc($resultadoFoto);

    // Si existe una foto, eliminarla de Cloudinary
    if (!empty($fotoActual['FotoPerf'])) {
        try {
            // Extraer el public_id de la URL
            $urlPartes = explode('/', $fotoActual['FotoPerf']);
            $nombreArchivo = end($urlPartes);
            $publicId = 'Subida/' . pathinfo($nombreArchivo, PATHINFO_FILENAME);

            // Eliminar la imagen de Cloudinary
            $admin = new AdminApi();
            $admin->deleteAssets($publicId);
            
            echo "Foto de perfil eliminada exitosamente de Cloudinary.";
        } catch (Exception $e) {
            echo "Advertencia: No se pudo eliminar la imagen de Cloudinary: " . $e->getMessage();
            // Continuamos con la ejecución aunque falle la eliminación de la imagen
        }
    }

    // Proceder a eliminar el perfil de la base de datos
    $consulta = "DELETE FROM usuarios WHERE Correo = '$email'";
    $resultado = mysqli_query($con, $consulta);
    
    mysqli_close($con);
    return $resultado;
}