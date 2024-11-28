<?php
session_start();
require_once '../requires/conexionbd.php';

// Verificar si hay una sesión activa
if (!isset($_SESSION['loggedin'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

// Obtener datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['postId'] ?? null;
$comentario = $data['comentario'] ?? null;

if (!$postId || !$comentario) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Determinar el tipo de usuario
$isVendedor = ($_SESSION['tipo'] === 'vendedor');
$userId = $isVendedor ? $_SESSION['id_vendedor'] : $_SESSION['id_usuario'];

// Construir la consulta según el tipo de usuario
if ($isVendedor) {
    $sql = "INSERT INTO comentarios (id_publicacion, id_vendedor, comentario) VALUES (?, ?, ?)";
} else {
    $sql = "INSERT INTO comentarios (id_publicacion, id_usuario, comentario) VALUES (?, ?, ?)";
}

// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($sql);
$stmt->bind_param('iis', $postId, $userId, $comentario);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Comentario agregado']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al agregar comentario']);
}

$stmt->close();
$conexion->close();
?>
