<?php require("Header_YM.php"); ?>
<form action="verify_code.php" method="POST">
    <label for="email">Correo Electrónico:</label>
    <input type="email" name="email" required>
    
    <label for="code">Código de Verificación:</label>
    <input type="text" name="code" required>
    
    <input type="submit" value="Verificar Código">
</form>
<?php require("Footer_YM.php"); ?>