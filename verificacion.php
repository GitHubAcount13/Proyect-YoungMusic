<?php require("Header_YM.php"); ?>
<div class="caja_popup_veri" >
<form action="verify_code.php" method="POST">
<table>
		<tr><th colspan="2">Recuperar contraseña</th></tr>
            <tr>
                <td><b><i class="bi bi-envelope"></i> Correo Electronico</b>
                <input class="cajaentradaveri" type="email" name="email" required>
            </td>
                    
                    </tr>
                    <tr>
                    <td for="code"> <b><i class="bi bi-code"></i> Código de Verificación:</b>
                    <input class="cajaentradaveri" type="text" name="code" required>
                </td>
                    
                    </tr>
            <tr> 	
               <td colspan="2">
    
    <input class="txtrecuperar" type="submit" value="Verificar Código">
</td>
</tr>
        </table>
</form>
</div>
<?php require("Footer_YM.php"); ?>