<?php require("Header_YM.php"); ?>
<div class="caja_popup" id="formrecuperar">
  <form action="recuperar.php" class="contenedor_popup" method="POST">
        <table>
		<tr><th colspan="2">Recuperar contraseña</th></tr>
            <tr> 
                <td><b>&#128231; Correo</b></td>
                <td><input type="email" name="txtcorreo" required class="cajaentradatexto"></td>
            </tr>
            <tr> 	
               <td colspan="2">
				   <button type="button" class="txtrecuperar">Cancelar</button>
				   <input class="txtrecuperar" type="submit" name="btnrecuperar" value="Enviar" onClick="javascript: return confirm('¿Deseas enviar tu contraseña a tu correo?');">
			</td>
            </tr>
        </table>
    </form>
	</div>
    <?php if (!empty($mensaje)): ?>
        <div>
            <strong><?php echo $mensaje; ?></strong>
        </div>
    <?php endif; ?>
<?php require("Footer_YM.php"); ?>