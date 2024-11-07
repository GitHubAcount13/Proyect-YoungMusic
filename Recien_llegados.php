<?php
require("Header_YM.php");
require("RF_Datos_Busqueda_YM.php");
require_once("Funciones.php");
$paginaPerfil = determinarTipoUsuario($email);
require_once("RF_Recien_llegados.php");

$paginaPerfil = determinarTipoUsuario($email);

// Obtener datos
$temasRecientes = obtenerTemasRecientes();
$artistasRecientes = obtenerArtistasRecientes();
$albumesRecientes = obtenerAlbumesRecientes();
?>

<nav class="navbar navbar-expand-md nav_index_ym">
    <a class="navbar-brand d-flex align-items-center" href="<?php echo htmlspecialchars($paginaPerfil); ?>">
        <img class="imagen_perfil_view" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" style="width: 50px; height: 50px;">
        <span class="ml-2" style="color: white; padding-left:5px;"><?php echo htmlspecialchars($nombre); ?></span>
    </a>
    <?php if (isset($_SESSION["email"]) && esAdmin($_SESSION["email"])): ?><a href="Panel_Admin_YM.php"><i class="bi bi-incognito"></i></a><?php endif; ?>
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
                    <a  class="nav-link" href="#">
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

<!-- Temas Recientes -->
<div class="carousel-container">
    <h2 class="carousel-title">Temas Recién Llegados</h2>
    <div class="carousel-wrapper">
        <button class="carousel-arrow prev">
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="carousel-track">
            <?php foreach ($temasRecientes as $tema):
                $hasLike = isset($_SESSION['email']) ? verificarLikeExistente($tema['IdMusi'], $_SESSION['email']) : false;
            ?>
                <div class="carousel-slide" data-music-id="<?php echo htmlspecialchars($tema['IdMusi']); ?>">
                    <div class="carousel-card">
                        <div class="card-image">
                            <img src="<?php echo htmlspecialchars($tema['ImgMusi']); ?>" alt="Portada del tema">
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($tema['NomMusi']); ?></h3>
                            <p class="fecha">Lanzado: <?php echo date('d/m/Y', strtotime($tema['FechaLan'])); ?></p>
                            <div class="artist-info">
                                <a href="Ver_artista_YM.php?correo=<?php echo htmlspecialchars($tema['CorrArti']); ?>" class="Link">
                                    <img src="<?php echo htmlspecialchars($tema['FotoPerf']); ?>" alt="Foto del artista" class="artist-avatar">
                                    <p class="artist"><?php echo htmlspecialchars($tema['NombArtis']); ?></p>
                                </a>
                            </div>
                            <div class="card-actions">
                                <audio id="audio-<?php echo htmlspecialchars($tema['IdMusi']); ?>" class="music-player">
                                    <source src="<?php echo htmlspecialchars($tema['Archivo']); ?>" type="audio/mpeg">
                                </audio>
                                <button class="play-btn" data-music-id="<?php echo htmlspecialchars($tema['IdMusi']); ?>">
                                    <i class="bi bi-play-fill"></i>
                                </button>
                                <?php if (isset($_SESSION['email'])): ?>
                                    <button class="like-btn <?php echo $hasLike ? 'active' : ''; ?>" data-music-id="<?php echo htmlspecialchars($tema['IdMusi']); ?>">
                                        <i class="bi <?php echo $hasLike ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-arrow next">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
    <div class="carousel-dots"></div>
</div>

<!-- Artistas Recientes -->
<div class="carousel-container">
    <h2 class="carousel-title">Artistas Recién Unidos</h2>
    <div class="carousel-wrapper">
        <button class="carousel-arrow prev">
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="carousel-track">
            <?php foreach ($artistasRecientes as $artista): ?>
                <div class="carousel-slide">
                    <div class="carousel-card">
                        <div class="card-image">
                            <img src="<?php echo htmlspecialchars($artista['FotoPerf']); ?>" alt="Foto del artista">
                        </div>
                        <div class="card-content">
                            <a href="Ver_artista_YM.php?correo=<?php echo htmlspecialchars($artista['CorrArti']); ?>" class="Link">
                                <h3><?php echo htmlspecialchars($artista['NombArtis']); ?></h3>
                            </a>
                            <p class="stats"><?php echo htmlspecialchars($artista['NumCanciones']); ?> canciones</p>
                            <p class="fecha">Se unió: <?php echo date('d/m/Y', strtotime($artista['FechaReg'])); ?></p>
                            <?php if ($artista['Verificacion']): ?>
                                <span class="verified-badge"><i class="bi bi-patch-check-fill"></i></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-arrow next">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
    <div class="carousel-dots"></div>
</div>

<!-- Álbumes Recientes -->
<div class="carousel-container">
    <h2 class="carousel-title">Álbumes Recién Lanzados</h2>
    <div class="carousel-wrapper">
        <button class="carousel-arrow prev">
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="carousel-track">
            <?php foreach ($albumesRecientes as $album): ?>
                <div class="carousel-slide">
                    <div class="carousel-card">
                        <div class="card-image">
                        <a href="VerAlbum.php?id=<?php echo htmlspecialchars($album['IdAlbum']); ?>" class="Link">
                            <img src="<?php echo htmlspecialchars($album['ImgAlbu']); ?>" alt="Portada del álbum">
                            </a>
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($album['NomAlbum']); ?></h3>
                            <p class="album-type"><?php echo htmlspecialchars($album['Categoria']); ?></p>
                            <p class="fecha">Lanzado: <?php echo date('d/m/Y', strtotime($album['FechaLan'])); ?></p>
                            <div class="artist-info">
                                <a href="Ver_artista_YM.php?correo=<?php echo htmlspecialchars($album['CorrArti']); ?>" class="Link">
                                    <img src="<?php echo htmlspecialchars($album['FotoPerf']); ?>" alt="Foto del artista" class="artist-avatar">
                                    <p class="artist"><?php echo htmlspecialchars($album['NombArtis']); ?></p>
                                </a>
                            </div>
                            <p class="stats"><?php echo htmlspecialchars($album['NumCanciones']); ?> canciones</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-arrow next">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
    <div class="carousel-dots"></div>
</div>

<?php require("Footer_YM.php"); ?>