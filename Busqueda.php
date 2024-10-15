<?php
require("Header_YM.php");
require("RF_Datos_Busqueda_YM.php");
?>
<nav class="navbar navbar-expand-md nav_index_ym">
    <a class="navbar-brand d-flex align-items-center" href="Usuario_YM.php">
        <img class="imagen_perfil_view" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" style="width: 50px; height: 50px;">
        <span class="ml-2" style="color: white; padding-left:5px;"><?php echo htmlspecialchars($nombre); ?></span>
    </a>
    <button class="navbar-toggler desplazador-busqueda" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-search icono-busqueda"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">


            <div class="container-fluid">




                <form class="d-flex me-auto search-bus" role="search" id="form-buscar-usuario">
                    <input class="form-control me-2 bus" type="text" name="usuario" id="usuario" placeholder="Ingrese el nombre a buscar" aria-label="Search">
                    <input type="submit" value="Buscar" name="envio" class="btn btn-primary" onclick="consultar_en_tiempo_real()">
                    <a href="Home_YM.php" class="btn btn-outline-light"><i class="bi bi-house"></i></a>
                </form>


            </div>
</nav>

<main>
    <div class="resultado" id="resultado" style=" overflow-y: auto;"></div>
</main>



<?php require("Footer_YM.php"); ?>