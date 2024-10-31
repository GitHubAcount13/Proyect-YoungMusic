<?php
include('conexion.php');

$conexion = conectar_bd();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        // Hash de la nueva contraseña
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $stmt = $conexion->prepare("UPDATE usuarios SET Contra = ? WHERE Correo = ?");
        
        if ($stmt === false) {
            echo "Error en la preparación de la consulta: " . $conexion->error;
            exit;
        }

        // Vincular parámetros
        $stmt->bind_param("ss", $hashedPassword, $email);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Eliminar el código de restablecimiento de la base de datos
            $stmt = $conexion->prepare("DELETE FROM codigos WHERE Correo = ?");
            if ($stmt === false) {
                echo "Error en la preparación de la consulta: " . $conexion->error;
                exit;
            }

            // Vincular parámetros
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                 header("Location: Login_YM.php");
            } else {
                header("Location: Recuperacion_YM.php");
            }
        } else {
            header("Location: Recuperacion_YM.php");
        }

        $stmt->close();
    } else {
        header("Location: Recuperacion_YM.php");
    }
}
?>