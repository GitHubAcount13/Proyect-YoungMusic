<?php
require_once("conexion.php");

function obtenerMusicaPorPreferencias($correoUsuario) {
    $conn = conectar_bd();
    
    $query = "SELECT DISTINCT m.IdMusi, m.NomMusi, m.ImgMusi, a.NomAlbum, art.NombArtis, u.FotoPerf 
              FROM musica m 
              INNER JOIN albun a ON m.Album = a.IdAlbum
              INNER JOIN artistas art ON a.NomCred = art.CorrArti
              INNER JOIN usuarios u ON art.CorrArti = u.Correo
              INNER JOIN generos g ON m.IdMusi = g.IdMusi
              WHERE g.GeneMusi IN (
                  SELECT Genero 
                  FROM preferencias 
                  WHERE CorrUsu = ?
              )
              LIMIT 10";
              
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $correoUsuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    $musicas = array();
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $musicas[] = $fila;
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    return $musicas;
}

function obtenerMusicaReciente() {
    $conn = conectar_bd();
    
    $query = "SELECT m.IdMusi, m.NomMusi, m.ImgMusi, a.NomAlbum, art.NombArtis, u.FotoPerf 
              FROM musica m 
              INNER JOIN albun a ON m.Album = a.IdAlbum
              INNER JOIN artistas art ON a.NomCred = art.CorrArti
              INNER JOIN usuarios u ON art.CorrArti = u.Correo
              ORDER BY m.IdMusi DESC 
              LIMIT 10";
              
    $resultado = mysqli_query($conn, $query);
    
    $musicas = array();
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $musicas[] = $fila;
    }
    
    mysqli_close($conn);
    
    return $musicas;
}