        <?php
        require("Header_YM.php");
        require("RF_Datos_Busqueda_YM.php");
        require_once("Funciones.php");
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
     <?php if(isset($_SESSION["email"]) && esAdmin($_SESSION["email"])): ?><a href="Panel_Admin_YM.php"><i class="bi bi-incognito"></i></a><?php endif; ?>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <a href="Busqueda.php"><i class="bi bi-search"></i></a>
                </ul>
            </div>
        </nav>


        
           <p id="toggleSidebar" class="btn btn-custom-slidebar">
                    
            
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
                    
                </div>
            </div>
        </footer>
        <?php require("Footer_YM.php"); ?>