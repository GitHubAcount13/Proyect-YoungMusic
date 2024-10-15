<?php
require("Header_YM.php");
require("RF_Datos_Busqueda_YM.php");
?>
<nav class="navbar navbar-expand-md nav_index_ym">
    <a class="navbar-brand d-flex align-items-center" href="Usuario_YM.php">
        <img class="imagen_perfil_view" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" style="width: 50px; height: 50px;">
        <span class="ml-2" style="color: white; padding-left:5px;"><?php echo htmlspecialchars($nombre); ?></span>
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <a href="Busqueda.php"><i class="bi bi-search"></i></a>

        </ul>
    </div>
</nav>


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
                    <a class="nav-link" href="#">
                        <span class="icon"><i class="bi bi-clock"></i></span>
                        <span class="text">Recién llegados</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
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
                    <a class="nav-link" href="#">
                        <span class="icon"><i class="bi bi-suit-heart-fill"></i></span>
                        <span class="text">Tus me gusta</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icon"><i class="bi bi-person-heart"></i></i></span>
                        <span class="text">Artistas favoritos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icon"><i class="bi bi-clock-history"></i></i></i></span>
                        <span class="text">Historial</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container container-home">
    <div class="carousel active" id="carousel">

        <div>
            <img src="subida/imagen_66da20cbb0b53.jpg" alt="Imagen 1">
            <p>Título 1</p>
        </div>
        <div>
            <img src="subida/imagen_66da21096ae8a.jpg" alt="Imagen 2">
            <p>Título 2</p>
        </div>
        <div>
            <img src="subida/imagen_66da2cf6ca599.jpg" alt="Imagen 3">
            <p>Título 3</p>
        </div>
        <div>
            <img src="subida/imagen_66e4ad2303988.png" alt="Imagen 4">
            <p>Título 4</p>
        </div>
        <div>
            <img src="subida/imagen_66e4ae4db8798.png" alt="Imagen 5">
            <p>Título 5</p>
        </div>
        <div>
            <img src="subida/imagen_66f614fd5eb10.jpg" alt="Imagen 6">
            <p>Título 6</p>
        </div>
        <div>
            <img src="subida/imagen_66e530ed9d78b.jpeg" alt="Imagen 7">
            <p>Título 7</p>
        </div>
        <div>
            <img src="subida/imagen_66e852e958c01.png" alt="Imagen 8">
            <p>Título 8</p>
        </div>
        <div>
            <img src="subida/imagen_66f47c3b94b1d.jpg" alt="Imagen 9">
            <p>Título 9</p>
        </div>
        <div>
            <img src="subida/imagen_66e9fc39ec35b.jpg" alt="Imagen 10">
            <p>Título 10</p>
        </div>
        <div>
            <img src="subida/imagen_66f1ce1323b30.jpeg" alt="Imagen 11">
            <p>Título 11</p>
        </div>

    </div>

    <div class="button-container text-end mt-3">
        <button class="btn btn-custom boton-scroll" style="font-size: 35px; position:absolute; left:95%;" onclick="scrollRight()">
            <i class="bi bi-chevron-compact-right"></i>
        </button>
    </div>
</div>
<?php require("Footer_YM.php"); ?>