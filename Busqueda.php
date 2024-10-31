<?php
require("Header_YM.php");
require("RF_Datos_Busqueda_YM.php");
$paginaPerfil = determinarTipoUsuario($email);
require_once("Funciones.php");
?>
<nav class="navbar navbar-expand-md nav_index_ym">
<a class="navbar-brand d-flex align-items-center" href="<?php echo htmlspecialchars($paginaPerfil); ?>">
        <img class="imagen_perfil_view" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" style="width: 50px; height: 50px;">
        <span class="ml-2" style="color: white; padding-left:5px;"><?php echo htmlspecialchars($nombre); ?></span>
    </a>
    <?php if(isset($_SESSION["email"]) && esAdmin($_SESSION["email"])): ?><a href="Panel_Admin_YM.php"><i class="bi bi-incognito"></i></a><?php endif; ?>
    <button class="navbar-toggler desplazador-busqueda" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-search icono-busqueda"></i>
    </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto"></ul> <!-- Espacio vacío hacia la izquierda -->
            <form class="d-flex ms-auto" role="search" id="form-buscar-usuario"> <!-- ms-auto para margen a la izquierda -->
                <input class="form-control me-2" type="text" name="usuario" id="usuario" placeholder="Ingrese el nombre a buscar" aria-label="Search">
                <input type="submit" value="Buscar" name="envio" class="btn btn-primary" onclick="consultar_en_tiempo_real()">
            </form>
        </div>
       
</nav>

<div class="container contenido-bus">
    <div class="flex justify-center space-x-4 mb-6">
        <a href="#"><button class="text-white py-2 px-4 rounded-full boton-bus">Artista
            </button>
            <a href="Busqueda_musica.php"><button class="text-white py-2 px-4 rounded-full boton-bus">música
                </button></a>
            <a href="Busqueda_Album.php"><button class="text-white py-2 px-4 rounded-full boton-bus">Álbum
                </button></a>
    </div>
</div>
<div class="container container-busqueda">
   
        <div class="row resultado" id="resultado" style=" overflow-y: auto;"></div>
    
</div>
<div id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-custom-slidebar sidebar">
    <div class="sidebar-header">
        <button id="toggleSidebar" class="btn btn-custom-slidebar">
            <p class="arrow">
                <
                    </button>
    </div>
    <div class="sidebar-content">
        <div class="slidebar-arriba conjunto-contenido-slider">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="Home_YM.php">
                        <span class="icon"><i class="bi bi-house"></i></span>
                        <span class="text">Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a  class="nav-link" href="Recien_llegados.php">
                        <span class="icon"><i class="bi bi-clock"></i></span>
                        <span class="text">Recién llegados</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Populares.php">
                        <span class="icon"><i class="bi bi-fire"></i></i></span>
                        <span class="text">Populares</span>
                    </a>
                </li>


            </ul>
        </div>
        <br>
        <div class="slidebar-abajo conjunto-contenido-slider">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="MeGusta.php">
                        <span class="icon"><i class="bi bi-suit-heart-fill"></i></span>
                        <span class="text">Tus me gusta</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Artistas_favoritos.php">
                        <span class="icon"><i class="bi bi-person-heart"></i></i></span>
                        <span class="text">Artistas favoritos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

        <footer class="footer-home">
            <div class="container-fluid">
                <div class="row cont-fot">
                    <div class="col-md-2 contenido-foot">
                        <a href="Home_YM.php" class="nav-link">
                            <span class="icon-foot icon-home"><i class="bi bi-house"></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot icon-clock"><i class="bi bi-clock"></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot icon-fire"><i class="bi bi-fire"></i></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot icon-heart"><i class="bi bi-suit-heart-fill"></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot icon-person"><i class="bi bi-person-heart"></i></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot icon-history"><i class="bi bi-clock-history"></i></i></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        <?php require("Footer_YM.php"); ?>