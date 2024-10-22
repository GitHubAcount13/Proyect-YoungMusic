<?php
require("Header_YM.php");
require_once("RF_Datos_Busqueda_YM.php");
require("RF_Ver_Artista_YM.php");

?>

<nav class="navbar navbar-expand-md nav_index_ym">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img class="imagen_perfil_view" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" style="width: 50px; height: 50px;">
        <span class="ml-2" style="color: white; padding-left:5px;"><?php echo htmlspecialchars($nombre); ?></span>
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <a href="Busqueda.php"><i class="bi bi-search"></i></a>

        </ul>
    </div>
</nav>


<!-- Contenido del Perfil -->
<div class="container mt-4 md container-perfil">

    <div class="row justify-content-left">


       <div class="botones text-center text-md-left">
        <div class="btn-group flex-md-row text-center mt-3">
            <button class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Seguir
            </button>
        </div>
    </div>
    
        <div class="cont-u">

            <div class="imagen_perfil-container">
                <img class="imagen_perfil" src="<?php echo htmlspecialchars($fotoPerfilA); ?>" alt="Foto de Perfil">
            </div>

            <div class="perfil-content">
                <div class="perfil-details">
                    <h2>| <?php echo htmlspecialchars($nombreA); ?></h2>
                    <p>| <?php echo htmlspecialchars($correoA); ?></p>
                    <div class="social-icons d-flex justify-content-center">
                        <button class="icons"><a id="tiktok" style="display:none;"><i class="bi bi-tiktok"></i></a></button>
                        <button class="icons"><a id="instagram" style="display:none;"><i class="bi bi-instagram"></i></a></button>
                        <button class="icons"><a id="youtube" style="display:none;"><i class="bi bi-youtube"></i></a></button>
                        <button class="icons"><a id="spotify" style="display:none;"><i class="bi bi-spotify"></i></a></button>
                    </div>
                    <hr class="bg-custom-loginu my-4 barra_loginu">
                    <h5>| Biografia</h5>
                    <p><?php echo htmlspecialchars($biografiaA); ?></p>
                    <hr class="bg-custom-loginu my-4 barra_loginu">
                    <h3>| Instrumentos</h3>
                    <?php foreach ($usuario['instrumentos'] as $instrumento): ?>
                        <li><?php echo htmlspecialchars($instrumento); ?></li>
                    <?php endforeach; ?>
                    </ul>

                    <h2>LANZAMIENTOS</h2>
                </div>


            </div>

        </div>
    </div>


<?php require("Footer_YM.php"); ?>