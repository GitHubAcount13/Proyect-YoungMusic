<?php require("Header_YM.php"); ?>

  <img class="logo-reg bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="100" height="50" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="https://res.cloudinary.com/dlii53bu7/image/upload/v1729654882/Subida/rcoe0yvyz6hvjabfqkcy.webp" alt="">

  <div class="container log mt-4">
    <div class="row login-rw">
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
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input class="form-control " type="text" name="email" id="email" placeholder="Ingrese su Correo">
            </div>
          </div>

          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-key"></i></span>
              <input class="form-control " type="password" name="pass" id="pass" placeholder="Ingrese su Contraseña">
            </div>
          </div>

          <div class="text-center mb-2">
            <a class="pass_lost" href="Recuperacion_YM.php">Olvidé mi contraseña</a>
          </div>
          <div id="error-message" style="color: red; display: none;"></div>
          <div class="form-group text-center mb-3">
            <button class="btn btn-secondary mr-2 bot" type="reset">Cancelar</button>
            <button class="btn btn-primary bot bot-s" type="button" id="submitLogin" onclick="loginUser()">Siguiente</button>
          </div>
        </form>
      </div>

    </div>
  </div>

<?php require("Footer_YM.php"); ?>