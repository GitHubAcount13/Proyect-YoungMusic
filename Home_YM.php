        <?php
        require("Header_YM.php");
        require("RF_Datos_Busqueda_YM.php");

        $paginaPerfil = determinarTipoUsuario($email);
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
            <div class="carousel-slide">
                <div class="carousel-card">
                    <div class="card-image">
                        <img src="subida/imagen_66da20cbb0b53.jpg" alt="Imagen Musical">
                    </div>
                    <div class="card-content">
                        <h3>Título de la Canción</h3>
                        <p class="artist">Nombre del Artista</p>
                        <div class="card-actions">
                            <button class="play-btn">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <button class="like-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-slide">
                <div class="carousel-card">
                    <div class="card-image">
                        <img src="subida/imagen_66da20cbb0b53.jpg" alt="Imagen Musical">
                    </div>
                    <div class="card-content">
                        <h3>Título de la Canción</h3>
                        <p class="artist">Nombre del Artista</p>
                        <div class="card-actions">
                            <button class="play-btn">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <button class="like-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-slide">
                <div class="carousel-card">
                    <div class="card-image">
                        <img src="subida/imagen_66da20cbb0b53.jpg" alt="Imagen Musical">
                    </div>
                    <div class="card-content">
                        <h3>Título de la Canción</h3>
                        <p class="artist">Nombre del Artista</p>
                        <div class="card-actions">
                            <button class="play-btn">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <button class="like-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-slide">
                <div class="carousel-card">
                    <div class="card-image">
                        <img src="subida/imagen_66da20cbb0b53.jpg" alt="Imagen Musical">
                    </div>
                    <div class="card-content">
                        <h3>Título de la Canción</h3>
                        <p class="artist">Nombre del Artista</p>
                        <div class="card-actions">
                            <button class="play-btn">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <button class="like-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-slide">
                <div class="carousel-card">
                    <div class="card-image">
                        <img src="subida/imagen_66da20cbb0b53.jpg" alt="Imagen Musical">
                    </div>
                    <div class="card-content">
                        <h3>Título de la Canción</h3>
                        <p class="artist">Nombre del Artista</p>
                        <div class="card-actions">
                            <button class="play-btn">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <button class="like-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-slide">
                <div class="carousel-card">
                    <div class="card-image">
                        <img src="subida/imagen_66da20cbb0b53.jpg" alt="Imagen Musical">
                    </div>
                    <div class="card-content">
                        <h3>Título de la Canción</h3>
                        <p class="artist">Nombre del Artista</p>
                        <div class="card-actions">
                            <button class="play-btn">
                                <i class="bi bi-play-fill"></i>
                            </button>
                            <button class="like-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Repite carousel-slide para más elementos -->
        </div>

        <button class="carousel-arrow next">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <div class="carousel-dots"></div>
</div>
        <?php require("Footer_YM.php"); ?>