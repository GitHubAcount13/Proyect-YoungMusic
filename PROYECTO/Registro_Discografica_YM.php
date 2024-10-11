<?php
require("Header_YM.php");
require("RF_Usuario_YM.php");
$jsonData = file_get_contents('JSON/generos.json');
$generos = json_decode($jsonData, true)['generos'];
?>

<nav class="navbar navbar-expand-md nav_index_ym">
    <div>
        <img class="imagen_perfil_view" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
        <h2 class="nombre_perfil_view"><?php echo htmlspecialchars($nombre); ?></h2>
    </div>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        </ul>
    </div>
</nav>

<div class="container">
        <div class="row">
   
             
            <div class="col-md-6 parte_izquierda_registro_discog mb-4">
                <h2>
                    <a class="registro">Registro de Discográfica</a>
                    <hr class="bg-custom-register my-4 barra_register">
                </h2>
                <h4 class="info_datosreg">
                    Coloque el Nombre por el cual quiere ser Identificado
                </h4>
            </div>
         
            <div class="col-md-6 parte_derecha_login">
                <form action="RF_Registro_Discografica_YM.php" method="post">
                    <div class="form-group"><br>
               
                        <input class="form-control" type="text" name="nombre_d" id="nombre_d" placeholder="Ingrese su Nombre de la Discográfica">
                    </div><br>
                    <div class="form-group botones_registro text-center">
                        <button class="btn btn-secondary mr-2 bot" type="reset">Cancelar</button>
                        <button class="btn btn-primary bot" type="submit" name="envio">Siguiente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php require("Footer_YM.php"); ?>