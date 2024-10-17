<?php require("Header_YM.php") ?>

<div class="container container-recuperacion">
    <div class="row">
        <div class="col-md-6 parte-izquierda-recuperacion">
            <div class="titulo-recuperacion text-center">
                <h2>Olvide mi contraseña</h2>
                <hr>
            </div>
            <h4 class="descripcion-recuperacion text-center">Ingrese su correo, se le enviará una verificación para comprobar que es usted</h4>
        </div>
        <div class="col-md-6 contenedor-parte-derecha">
            <div class="contenido-form">
                <i class="bi bi-person icono-recu"></i>
                <input class="email-recuperacion" type="text" name="email" id="email" class="form-control" placeholder="Ingrese su Correo">
            </div>
            <a href="Login_YM.php" class="btn btn-link volver-recuperacion">Volver</a>
            <div class="mt-2 text-center">
                <input class="btn btn-secondary siguiente-recuperacion " type="submit" value="Siguiente" name="envio">
            </div>
        </div>
    </div>

</div>



<?php require("Footer_YM.php"); ?>