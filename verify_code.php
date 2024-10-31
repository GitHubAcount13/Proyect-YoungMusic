<?php require("Header_YM.php"); ?>
<?php
include('conexion.php'); // Asegúrate de que esta función esté definida correctamente

$conexion = conectar_bd(); // Cambia esto si es necesario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $enteredCode = $_POST['code'];

    // Obtener el código de la base de datos
    $stmt = $conexion->prepare("SELECT token, token_expiry FROM password_reset_tokens WHERE email = ? LIMIT 1");
    
    if ($stmt === false) {
        echo "Error en la preparación de la consulta: " . $conexion->error;
        exit;
    }

    // Vincular parámetros
    $stmt->bind_param("s", $email);

    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result) {
        $row = $result->fetch_assoc();

        if ($row) {
            $storedCode = $row['token'];
            $expiry = $row['token_expiry'];

            // Verificar si el código coincide y no ha expirado
            if ($enteredCode === $storedCode && strtotime($expiry) > time()) {
                // Código válido, permite al usuario cambiar la contraseña
                echo "Código verificado! Puedes cambiar tu contraseña.";
                ?>
                <form action="cambio_contra.php" method="POST">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <label for="new_password">Nueva Contraseña:</label>
                    <input type="password" name="new_password" required>
                    <label for="confirm_password">Confirmar Contraseña:</label>
                    <input type="password" name="confirm_password" required>
                    <input type="submit" value="Cambiar Contraseña">
                </form>
                <?php
            } else {
                echo "Código inválido o ha expirado.";
            }
        } else {
            echo "No se encontró ninguna solicitud de restablecimiento para este correo.";
        }
    } else {
        echo "Error en la ejecución de la consulta: " . $stmt->error;
    }

    $stmt->close();
}
?>
<?php require("Footer_YM.php"); ?>