<?php require("Header_YM.php"); ?>
<div class="bg-mask">
  <img class="logo-reg bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="100" height="50" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="Subida/oung-removebg.webp" alt="">

  <div class="container log mt-4">
    <div class="row">
      <div class="col-md-7 parte_izquierda_login">
        <h4><button><a class="registrou" href="Registro_YM.php">REGISTRARSE</a></button>
          <br><br>
        </h4>
        <h2><button><a class="loginu" href="Login_YM.php">LOGIN</a></button>
          <br><br>
        </h2>




        <h5 class="info_datoslog">Ingrese los datos requeridos para Iniciar Sesión.</h5>
      </div>


      <div class="col-md-5 parte_derecha_login">

        <br>
        <form id="loginForm" method="post">
          <input class="form-control mb-2" type="text" name="email" id="email" placeholder="Ingrese su Correo"><br>
          <input class="form-control mb-2" type="password" name="pass" id="pass" placeholder="Ingrese su Contraseña">
          <div class="text-center mb-2">
            <a class="pass_lost" href="#">Olvidé mi contraseña</a>
          </div>
          <div id="error-message" style="color: red; display: none;"></div>
          <div class="form-group text-center mb-3">
            <button class="btn btn-secondary mr-2 bot" type="reset">Cancelar</button>
            <button class="btn btn-primary bot" type="button" id="submitLogin" onclick="loginUser()">Siguiente</button>
          </div>
        </form>
      </div>

    </div>
  </div>

</div>
<?php require("Footer_YM.php"); ?>