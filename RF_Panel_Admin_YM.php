<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("conexion.php");

// Verificar si es admin
if(!isset($_SESSION["email"]) || !esAdmin($_SESSION["email"])) {
    header("Location: Login_YM.php");
    exit();
}

// Procesar confirmación
if(isset($_POST['confirmar'])) {
    $tipo = $_POST['tipo'];
    $correo = $_POST['correo'];
    
    if($tipo === 'artista') {
        $query = "UPDATE artistas SET Verificacion = 1 WHERE CorrArti = ?";
    } else {
        $query = "UPDATE discografica SET Verificacion = 1 WHERE CorrDisc = ?";
    }
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
}

// Obtener artistas sin verificar
$query_artistas = "SELECT CorrArti, NombArtis, FechNacA FROM artistas WHERE Verificacion = 0 OR Verificacion IS NULL";
$artistas = $con->query($query_artistas);

// Obtener discográficas sin verificar
$query_discograficas = "SELECT CorrDisc, NombDisc FROM discografica WHERE Verificacion = 0 OR Verificacion IS NULL";
$discograficas = $con->query($query_discograficas);

function esAdmin($correo) {
    global $con;
    $query = "SELECT PermO FROM oyente WHERE CorrOyen = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($row = $result->fetch_assoc()) {
        return $row['PermO'] != NULL;
    }
    return false;
}

?>