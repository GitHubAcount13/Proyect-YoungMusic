<?php
require_once("conexion.php");
require_once("Funciones.php");
require_once("RF_Álbumes_YM.php");


if (!isset($_SESSION["email"])) {
    header("Location: Login_YM.php");
    exit();
}

if (!isset($_GET['correo'])) {
    header("Location: Login_YM.php");
    exit();
}

$correoArtista = $_GET['correo'];
$correoOyente = $_SESSION["email"];  // Correo del usuario logueado

// Obtener datos del artista
$usuario = obtenerDatosArtista($correoArtista);
if ($usuario) {
    $nombreA = $usuario["NombArtis"];
    $correoA = $usuario["Correo"];
    $biografiaA = $usuario["Biografia"];
    $fotoPerfilA = $usuario["FotoPerf"] ? $usuario["FotoPerf"] : 'Subida/';
} else {
    echo "Error al obtener los datos del usuario.";
    exit();
}



// Verificar si ya sigue al artista
$stmt = $con->prepare("SELECT * FROM sigue WHERE CorrArti = ? AND CorrOyen = ?");
$stmt->bind_param("ss", $correoArtista, $correoOyente);
$stmt->execute();
$result = $stmt->get_result();
$sigueAlArtista = ($result->num_rows > 0);

// Si se presionó el botón de seguir o dejar de seguir
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['seguir'])) {
        // Insertar la relación de seguimiento
        $stmt = $con->prepare("INSERT INTO sigue (CorrArti, CorrOyen) VALUES (?, ?)");
        $stmt->bind_param("ss", $correoArtista, $correoOyente);

        if ($stmt->execute()) {
            echo "<script>alert('Ahora sigues a este artista.');</script>";
        } else {
            echo "<script>alert('Hubo un error al intentar seguir al artista.');</script>";
        }
    } elseif (isset($_POST['dejarDeSeguir'])) {
        // Eliminar la relación de seguimiento
        $stmt = $con->prepare("DELETE FROM sigue WHERE CorrArti = ? AND CorrOyen = ?");
        $stmt->bind_param("ss", $correoArtista, $correoOyente);

        if ($stmt->execute()) {
            echo "<script>alert('Has dejado de seguir a este artista.');</script>";
        } else {
            echo "<script>alert('Hubo un error al intentar dejar de seguir al artista.');</script>";
        }
    }

    $stmt->close();
    $con->close();

    // Redirigir para evitar el reenvío del formulario
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$stmt->close();
$con->close();
?>
