<?php
require("Header_YM.php");
require("RF_Datos_Busqueda_YM.php");
$jsonData = file_get_contents('JSON/generos.json');
$generos = json_decode($jsonData, true)['generos'];
?>

<nav class="navbar navbar-expand-md nav_index_ym">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img class="imagen_perfil_view" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil" style="width: 50px; height: 50px;">
        <span class="ml-2" style="color: white; padding-left:5px;"><?php echo htmlspecialchars($nombre); ?></span>
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <!-- Agrega elementos de navegación si es necesario -->
        </ul>
    </div>
</nav>

<div class="container my-3">
    <div class="row preferencias">
        <div class="col-md-4">
            <div class="parte_izquierda_registro_pref">
                <h2>
                    <a class="registro" href="Login_YM.php">REGISTRARSE</a>
                    <hr class="bg-custom-register my-2 barra_register">
                </h2>
                <h4 class="info_datosreg">Selecciona los géneros de tu preferencia para conocerte mejor</h4>
            </div>
        </div>

        <div class="col-md-8 pref">
            <div class="preferences-container">
                <form id="formGeneros" action="RF_Preferencias_Usr.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="destinoFinal" name="destinoFinal" value="">
                    <div class="grid-container generos_container">
                        <?php
                        foreach ($generos as $genero):
                        ?>
                            <div class="grid-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="generos[]" value="<?php echo htmlspecialchars($genero); ?>" id="genero-<?php echo htmlspecialchars($genero); ?>">
                                    <label class="form-check-label" for="genero-<?php echo htmlspecialchars($genero); ?>">
                                        <?php echo htmlspecialchars($genero); ?>
                                    </label>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                    <button class="btn btn-primary bot mt-3" type="button" onclick="mostrarVentanaEmergente()">Siguiente</button>
                </form>

                <div id="ventanaEmergente" class="modal" tabindex="-1" role="dialog" style="display: none;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Información Adicional</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Con estos datos puedes ingresar a la página. Si eres un artista o discográfica, ingresa otros datos necesarios para continuar. Si no, toca finalizar.</p>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" onclick="enviarFormulario('Registro_Artista_YM.php')">Artista</button>
                                <button class="btn btn-primary" onclick="enviarFormulario('Registro_Discografica_YM.php')">Discográfica</button>
                                <button class="btn btn-secondary" onclick="enviarFormulario('RF_Oyente_YM.php')">Finalizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require("Footer_YM.php"); ?>