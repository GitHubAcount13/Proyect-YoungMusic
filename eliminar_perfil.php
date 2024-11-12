<?php
session_start();
include_once("Funciones.php");
header('Content-Type: application/json');

// Verificar que sea una petición DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

// Verificar la sesión y los permisos de administrador
if (!isset($_SESSION["email"]) || !esAdmin($_SESSION["email"])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

// Obtener los datos enviados
$datos = json_decode(file_get_contents('php://input'), true);
$correoArtista = $datos['correoArtista'] ?? null;

if (!$correoArtista) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Correo no proporcionado']);
    exit;
}

// Intentar eliminar el perfil
if (eliminarPerfil($correoArtista)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error al eliminar el perfil']);
}