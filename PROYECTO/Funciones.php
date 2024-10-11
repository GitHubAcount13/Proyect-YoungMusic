<?php
    require_once("conexion.php");


    function logear($con, $email, $pass, $redirect = "Usuario_YM.php") {
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
    

    function consultar_existe_usr($con, $tabla, $columna, $email) {
      
        $email = mysqli_real_escape_string($con, $email);
    
       
        $consulta_existe_dato = "SELECT $columna FROM $tabla WHERE $columna = '$email'";
    
      
        $resultado_existe_dato = mysqli_query($con, $consulta_existe_dato);
    
     
        return mysqli_num_rows($resultado_existe_dato) > 0;
    }


    function insertar_datos($con, $nombre, $email, $contrasenia, $ubicacion, $biografia, $fotoPerfil, $existe_usr) {
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
    
    function insertar_usr($con, $tabla, $columnas, $valores, $existe_usr) {
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

        $directorioFotos = 'Subida/';
        if (!is_dir($directorioFotos)) {
            mkdir($directorioFotos, 0777, true);
        }

        $fotoGuardada = "";
        if (!empty($nuevaFoto['name'])) {
            $nombreFoto = uniqid('imagen_') . '.' . pathinfo($nuevaFoto['name'], PATHINFO_EXTENSION);
            $rutaFoto = $directorioFotos . $nombreFoto;

            if (move_uploaded_file($nuevaFoto['tmp_name'], $rutaFoto)) {
                $fotoGuardada = ", 	FotoPerf = '$rutaFoto'";
            } else {
                echo "Error al subir la foto.";
                return false;
            }
        }

        $consulta = "UPDATE usuarios SET NomrUsua = '$nuevoNombre', Biografia = '$nuevaBiografia' $fotoGuardada WHERE Correo = '$email'";
        $resultado = mysqli_query($con, $consulta);
        mysqli_close($con);
        return $resultado;
    }

    function eliminarPerfil($email)
    {
        $con = conectar_bd();
        $email = mysqli_real_escape_string($con, $email);
        $consulta = "DELETE FROM usuarios WHERE Correo = '$email'";
        $resultado = mysqli_query($con, $consulta);
        mysqli_close($con);
        return $resultado;
    }
    ?>
