<?php
require("Header_YM.php");
require_once("RF_VerAlbum.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID de álbum no proporcionado</div>";
    header("Location: Albumes.php");
    exit();
}

$albumId = intval($_GET['id']); 

if (!albumExiste($albumId)) {
    echo "<div class='alert alert-danger'>El álbum no existe</div>";
    header("Location: Albumes.php");
    exit();
}

$album = obtenerDetallesAlbum($albumId);
$canciones = obtenerCancionesAlbum($albumId);

if (!$album) {
    echo "<div class='alert alert-danger'>Error al obtener los detalles del álbum</div>";
    header("Location: Albumes.php");
    exit();
}
?>

    <div class="container-fluid bg-dark text-white py-4">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="<?php echo htmlspecialchars($album['ImgAlbu']); ?>" 
                     alt="<?php echo htmlspecialchars($album['NomAlbum']); ?>"
                     class="img-fluid portada-album mb-3">
            </div>
            <div class="col-md-8">
                <h1><?php echo htmlspecialchars($album['NomAlbum']); ?></h1>
                <h3>Artista: <?php echo htmlspecialchars($album['NombArtis']); ?></h3>
                <p>Categoría: <?php echo htmlspecialchars($album['Categoria']); ?></p>
                <p>Fecha de lanzamiento: <?php echo date('d/m/Y', strtotime($album['FechaLan'])); ?></p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h2 class="mb-4">Canciones</h2>
                <div class="song-list" id="songList">
                    <?php if (empty($canciones)): ?>
                        <div class="alert alert-info">No hay canciones en este álbum.</div>
                    <?php else: ?>
                        <?php foreach ($canciones as $cancion): ?>
                        <div class="song-item d-flex align-items-center p-3 mb-3 border rounded">
                            <img src="<?php echo htmlspecialchars($cancion['ImgMusi']); ?>" 
                                 alt="<?php echo htmlspecialchars($cancion['NomMusi']); ?>"
                                 class="song-thumbnail mr-3">
                            <div class="song-info flex-grow-1">
                                <h4 class="mb-0"><?php echo htmlspecialchars($cancion['NomMusi']); ?></h4>
                                <p class="mb-0">Géneros: <?php echo htmlspecialchars($cancion['Generos']); ?></p>
                            </div>
                            <div class="audio-player-container">
                                <audio class="custom-audio-player" data-song-id="<?php echo $cancion['IdMusi']; ?>">
                                    <source src="<?php echo htmlspecialchars($cancion['Archivo']); ?>" type="audio/mpeg">
                                    Tu navegador no soporta el elemento de audio.
                                </audio>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer-home footer-veralbum">
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
</body>
</html>

<?php require("Footer_YM.php"); ?>