        <?php
        require("Header_YM.php");
        require("RF_Datos_Busqueda_YM.php");
        $paginaPerfil = determinarTipoUsuario($email);
        require_once("RF_Home_YM.php");

        // Obtener el correo del usuario de la sesión
        $email = $_SESSION["email"];

        // Obtener músicas según las preferencias del usuario o música reciente si no hay preferencias
        $musicas = $email ? obtenerMusicaPorPreferencias($email) : obtenerMusicaReciente();
        ?>

        <nav class="navbar navbar-expand-md nav_index_ym">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo htmlspecialchars($paginaPerfil); ?>">
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

        <div class="carousel-container">
            <h2 class="carousel-title">Descubre Nuevas Melodías</h2>

            <div class="carousel-wrapper">
                <button class="carousel-arrow prev">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="carousel-track">
                    <?php foreach ($musicas as $musica):
                        $hasLike = verificarLikeExistente($musica['IdMusi'], $_SESSION['email']);
                    ?>
                        <div class="carousel-slide" data-music-id="<?php echo htmlspecialchars($musica['IdMusi']); ?>">
                            <div class="carousel-card">
                                <div class="card-image">
                                    <img src="<?php echo htmlspecialchars($musica['ImgMusi']); ?>" alt="Portada del álbum">
                                </div>
                                <div class="card-content">
                                    <h3><?php echo htmlspecialchars($musica['NomMusi']); ?></h3>
                                    <p class="album"><?php echo htmlspecialchars($musica['NomAlbum']); ?></p>
                                    <div class="artist-info">
                                        <img src="<?php echo htmlspecialchars($musica['FotoPerf']); ?>"
                                            alt="Foto del artista"
                                            class="artist-avatar">
                                        <p class="artist"><?php echo htmlspecialchars($musica['NombArtis']); ?></p>
                                    </div>
                                    <div class="card-actions">
                                        <audio id="audio-<?php echo htmlspecialchars($musica['IdMusi']); ?>" class="music-player">
                                            <source src="<?php echo htmlspecialchars($musica['Archivo']); ?>" type="audio/mpeg">
                                        </audio>
                                        <button class="play-btn" data-music-id="<?php echo htmlspecialchars($musica['IdMusi']); ?>">
                                            <i class="bi bi-play-fill"></i>
                                        </button>
                                        <button class="like-btn <?php echo $hasLike ? 'active' : ''; ?>">
                                            <i class="bi <?php echo $hasLike ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
                                        </button>
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
        <footer class="footer-home">
            <div class="container-fluid">
                <div class="row cont-fot">
                    <div class="col-md-2 contenido-foot">
                        <a href="" class="nav-link">
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