<?php
require("Header_YM.php");
require("RF_Artista_YM.php");
require_once("conexion.php");
require_once("RF_Álbumes_YM.php");

$email = $_SESSION["email"];
?>

<nav class="navbar navbar-expand-md nav_index_ym">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img class="imagen_perfil_view" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" style="width: 50px; height: 50px;">
        <span class="ml-2" style="color: white; padding-left:5px;"><?php echo htmlspecialchars($nombre); ?></span>
    </a>
    <i class="bi bi-music-note"></i>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <a href="Busqueda.php"><i class="bi bi-search"></i></a>
        </ul>
    </div>
</nav>
<div class="container-fluid">
    <h1 class="lanza text-center my-4">LANZAMIENTOS</h1>
    <hr class="bg-custom-loginu my-4 barra_loginu">
    <div class="fond-albu p-3">
        <form action="Subida_Album.php">
            <button type="submit" class="btn btn-secondary w-100 mb-4">
                <h3 class="text-center m-0">Nuevo</h3>
            </button>
        </form>

        <div class="album-container">

            <?php
            $albumes = obtenerAlbumes($email);
            if (empty($albumes)) {
                echo '<div class="text-center text-white">No hay álbumes para mostrar</div>';
            } else {
                foreach ($albumes as $album) {
            ?>
                    <a href="VerAlbum.php?id=<?php echo htmlspecialchars($album['IdAlbum']); ?>" class="album-link">
                        <div class="album-card">
                            <img src="<?php echo htmlspecialchars($album['ImgAlbu']); ?>"
                                alt="<?php echo htmlspecialchars($album['NomAlbum']); ?>">
                            <div class="album-info">
                                <h4><?php echo htmlspecialchars($album['NomAlbum']); ?></h4>
                                <p><?php echo htmlspecialchars($album['Categoria']); ?></p>
                                <p><?php echo date('d/m/Y', strtotime($album['FechaLan'])); ?></p>
                            </div>
                        </div>
                    </a>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<footer class="footer-album">
            <div class="container-fluid">
                <div class="row cont-fot-album">
                    <div class="col-md-2 contenido-foot">
                        <a href="Home_YM.php" class="nav-link">
                            <span class="icon-foot-album icon-home"><i class="bi bi-house"></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot-album icon-clock"><i class="bi bi-clock"></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot-album icon-fire"><i class="bi bi-fire"></i></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot-album icon-heart"><i class="bi bi-suit-heart-fill"></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot-album icon-person"><i class="bi bi-person-heart"></i></i></span>
                        </a>
                    </div>
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
                            <span class="icon-foot-album icon-history"><i class="bi bi-clock-history"></i></i></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
<?php require("Footer_YM.php"); ?>