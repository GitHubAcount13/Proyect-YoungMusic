<?php
include('conexion.php'); // Asegúrate de que esta función esté definida correctamente

$conexion = conectar_bd(); // Cambia esto si es necesario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Verificar que las contraseñas coincidan
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
            $stmt = $conexion->prepare("DELETE FROM password_reset_tokens WHERE email = ?");
            if ($stmt === false) {
                echo "Error en la preparación de la consulta: " . $conexion->error;
                exit;
            }

            // Vincular parámetros
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                echo "Contraseña cambiada exitosamente.";
            } else {
                echo "Error al eliminar el código de restablecimiento: " . $stmt->error;
            }
        } else {
            echo "Error al cambiar la contraseña: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Las contraseñas no coinciden.";
    }
}
?>