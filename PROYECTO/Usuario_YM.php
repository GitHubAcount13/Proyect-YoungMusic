<?php
require("Header_YM.php");
require("RF_Usuario_YM.php");
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

<!-- Contenido del Perfil -->
<div class="container mt-4">
    <div class="fondo_perfil_v">
    <div class="row justify-content-center">
    <div class="col-12 col-md-7 text-center text-md-left">
        <div class="perfil-content">
            <div class="imagen_perfil-container">
                <img class="imagen_perfil" src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de Perfil">
            </div>
            <div class="perfil-details">
                <h2><?php echo htmlspecialchars($nombre); ?></h2>
                <p><?php echo htmlspecialchars($correo); ?></p>
                <p><?php echo htmlspecialchars($biografia); ?></p>
            </div>
        </div>
        <div class="btn-group d-flex flex-column flex-md-row mt-3">
            <button class="btn btn-primary" onclick="mostrarEditarPerfil()" aria-label="Editar Perfil">Editar Perfil</button>
            <button class="btn btn-danger mt-2 mt-md-0" onclick="mostrarEliminarPerfil()" aria-label="Eliminar Perfil">Eliminar Perfil</button>
            <a class="btn btn-secondary mt-2 mt-md-0" href="logout.php" aria-label="Cerrar sesión">Cerrar sesión</a>
        </div>
    </div>
</div>

        <!-- Formulario para Editar Perfil -->
        <div class="form-container fondo_perfil_editar" id="editarPerfil" style="display: none;">
            <h3>Editar Perfil</h3>
            <form action="RF_Usuario_YM.php" method="post" enctype="multipart/form-data" onsubmit="return confirmarContrasena('editar')">
                <div class="form-group">
                    <input type="text" class="form-control" name="nuevoNombre" placeholder="Nuevo Nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                </div><br>
                <div class="form-group">
                    <textarea class="form-control input_biografia" name="nuevaBiografia" placeholder="Biografía"><?php echo htmlspecialchars($biografia); ?></textarea>
                </div><br>
                <div class="form-group">
                    <input type="file" class="form-control-file" name="nuevaFoto">
                </div><br>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Contraseña Actual" required>
                </div><br>
                <button type="submit" class="btn btn-primary" name="editarPerfil">Guardar Cambios</button>
            </form>
        </div>

        <!-- Formulario para Eliminar Perfil -->
        <div class="form-container fondo_perfil_editar" id="eliminarPerfil" style="display: none;">
            <h3>Eliminar Perfil</h3>
            <form action="RF_Usuario_YM.php" method="post" onsubmit="return confirmarContrasena('eliminar')">
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Ingrese su Contraseña para Confirmar" required>
                </div><br>
                <button type="submit" class="btn btn-danger" name="eliminarPerfil">Confirmar Eliminación</button>
            </form>
        </div>
    </div>
</div>


<?php require("Footer_YM.php"); ?>