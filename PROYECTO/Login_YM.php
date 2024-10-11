<?php require("Header_YM.php"); ?>


<div class="container log mt-4">
  <div class="row">
    <div class="col-md-7 parte_izquierda_login">
      <h2><a class="registrou" href="Registro_YM.php">REGISTRARSE</a>
        <hr class="bg-custom-loginu my-4 barra_loginu">
      </h2>
      <h4><a class="loginu" href="Login_YM.php">LOGIN</a>
        <hr class="bg-custom-registeru my-4 barra_registeru">
      </h4>




      <h5 class="info_datoslog">Ingrese los datos requeridos para Iniciar Sesión.</h5>
    </div>


    <div class="col-md-5 parte_derecha_login">

      <br>
      <form action="RF_Login_YM.php" method="post">

        <input class="form-control  mb-2" type="text" name="email" id="email" placeholder="Ingrese su Correo"><br>

        <input class="form-control  mb-2" type="password" name="pass" id="pass" placeholder="Ingrese su Contraseña">




        <div class="text-center mb-2">
          <a class="pass_lost" href="#">Olvidé mi contraseña</a>
        </div>
        <div class="form-group botones_registro text-center mb-3"><br>
          <button class="btn btn-secondary mr-2 bot" type="reset">Cancelar</button>
          <button class="btn btn-primary bot" type="submit" name="envio">Siguiente</button>
        </div>
      </form>
    </div>

  </div>
</div>


<?php require("Footer_YM.php"); ?>