<?php
require("Header_YM.php");
require("RF_Artista_YM.php");
if (!isset($_SESSION["email"])) {
    header("Location: Login_YM.php");
    exit();
}

$album_id = $_GET['album'] ?? null;
$categoria = $_GET['categoria'] ?? null;

if (!$album_id || !$categoria) {
    header("Location: Artista_YM.php");
    exit();
}

$limite_canciones = ($categoria === 'EP') ? 6 : (($categoria === 'Sencillo') ? 1 : 999);
?>
  <h2 class="lanza text-center my-4">Agregar Música al Álbum</h2>
  <hr class="bg-custom-loginu my-4 barra_loginu">

<div class="container">
<div class="musica-from-container">
  
    <br>
    <form id="formMusica" enctype="multipart/form-data">
        <input type="hidden" name="album_id" value="<?php echo htmlspecialchars($album_id); ?>">
        <div class="form-group">
            <label for="NomMusi">Nombre de la Canción:</label>
            <input type="text" class="form-control" id="NomMusi" name="NomMusi" required>
        </div>

        <div class="form-group">
            <label for="Archivo">Archivo de Audio:</label>
            <input type="file" class="form-control" id="Archivo" name="Archivo" accept="audio/*" required>
        </div>

        <div class="form-group">
            <label for="ImgMusi">Imagen de la Canción:</label>
            <input type="file" class="form-control" id="ImgMusi" name="ImgMusi" accept="image/*" required>
        </div>
        <div class="form-group">

    <label for="Generos">Géneros:</label>
    
    <select id="Generos" name="Generos[]" multiple>
        <?php
        $generos = json_decode(file_get_contents('JSON/generos.json'), true);
        foreach ($generos['generos'] as $genero) {
            echo "<option value='$genero'>$genero</option>";
        }
        ?>
    </select>
    <h2>Mantener Ctrl para seleccionar</h2>
</div>
   
 <div class="botones  text-center text-md-left">
    <div class="btn-group flex-md-row text-center mt-3">
        <button type="submit" class="btn btn-primary" onclick="canciones()">Agregar Canción</button>
    </form>

    <form action="Artista_YM.php"><button  type="submit" class="btn btn-primary">Salir</button></form>
</div> 
</div>
    <div id="canciones-agregadas">
        <!-- Aquí se mostrarán las canciones agregadas -->
    </div>
</div>
</div>


<?php require("Footer_YM.php"); ?>