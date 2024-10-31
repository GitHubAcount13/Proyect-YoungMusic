<?php require("Header_YM.php"); ?>
<?php
include('conexion.php'); // Asegúrate de que esta función esté definida correctamente

$conexion = conectar_bd(); // Cambia esto si es necesario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $enteredCode = $_POST['code'];

    // Obtener el código de la base de datos
    $stmt = $conexion->prepare("SELECT Codigo, Tiempo FROM Codigos WHERE Correo = ? LIMIT 1");
    
    if ($stmt === false) {
        header("Location: verificacion.php");
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
            $storedCode = $row['Codigo'];
            $expiry = $row['Tiempo'];

            // Verificar si el código coincide y no ha expirado
            if ($enteredCode === $storedCode && strtotime($expiry) > time()) {
                // Código válido, permite al usuario cambiar la contraseña
            
                ?>
                <div class="container container-recu">
                    <div class="row recu-rw">
                    <div class="parte-izquierda-recuperacion">
                        <h4>Código verificado! Puedes cambiar tu contraseña.</h4>
                    </div>
                
                <div class="caja_popup" >
                <form action="cambio_contra.php" method="POST" class="contenedor_popup">
                
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                    <table>
                        <tr>
                   
                            <th colspan="2">Cambiar Contraseña</th>
                        </tr>
                        <tr>
                            <td><b><i class="bi bi-code"></i> Nueva Contraseña</b></td>
                            <td><input type="password" name="new_password" class="cajaentradatexto" required></td>
                        </tr>
                        <tr>
                    <td for="code"> <b><i class="bi bi-code"></i> Confirmar Contraseña:</b></td>
                    <td><input type="password" name="confirm_password" class="cajaentradatexto" required></td>
                    </tr>
                        <tr>
            
                        <td colspan="2" class="text-center">
                    <input class="btn btn-primary botones-recu" type="submit" value="Cambiar Contraseña">

                    </td>
</tr>
        </table>
                </form>
            </div>
                <?php
            } else {
                header("Location: verificacion.php");
            }
        } else {
            header("Location: Recuperacion_YM.php");
        }
    } else {
        header("Location: verificacion.php");
    }

    $stmt->close();
}
?>
<?php require("Footer_YM.php"); ?>