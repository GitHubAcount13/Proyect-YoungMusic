<?php require("Header_YM.php") ?>


<div class="container mt-4">
    <div class="row ">
        <!-- Parte Izquierda -->
        <div class="col-md-7 parte_izquierda_registro">
            <h2><a class="registro" href="Login_YM.php">REGISTRARSE</a>
                <hr class="bg-custom-register my-4 barra_register">
            </h2>
            <h4><a class="login" href="Login_YM.php">LOGIN</a>
                <hr class="bg-custom-login my-4 barra_login">
            </h4>
            <h4 class="info_datosreg">Ingrese los datos requeridos para crearte un usuario y tener una mejor experiencia en nuestro sitio web.</h4>
        </div>

        <!-- Parte Derecha -->
        <div class="col-md-5 parte_derecha_registro">
            <form action="RF_Registro_YM.php" method="post" enctype="multipart/form-data">
                <div class="archivos_perfil">
                    <input type="file" name="file" id="file" class="custom-file-input" accept="image/*" onchange="previewImage(event)" required>
                    <label for="file" class="custom-file-label">
                        <img id="preview" class="preview-image" alt="Preview" style="display: none;">
                        <i class="bi bi-folder2-open icon-label"></i>
                    </label>
                    <br>
                </div>
                <div class="form-group input_derecha movement">
                    <input class="form-control  mb-2" type="text" name="nombre" id="nombre" placeholder="Nombre de Usuario">
                    <input class="form-control mb-2" type="text" name="email" id="email" placeholder="Ingrese su Correo">
                    <input class="form-control mb-2" type="password" name="pass" id="pass" placeholder="Ingrese su contraseña">
                    <div class="grupo-selectores">
                <select class="form-control mb-2  selectores" id="Ubicación" name="Ubicación">
                    <option value="" placeholder="Ubicación" name="Ubicación" id="Ubicación">Seleccione un país</option>
                </select>
            </div>
                </div>
                <textarea class="form-control mb-2 input_biografia" name="biografia" id="biografia" type="text">Sin biografía</textarea>
                <div class="form-group botones_registro text-center">
                    <button class="btn btn-secondary mr-2" type="reset">Cancelar</button>
                    <button class="btn btn-primary" type="submit" name="envio">Siguiente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require("Footer_YM.php"); ?>