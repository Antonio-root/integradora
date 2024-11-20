<?php
session_start();
require_once '../requires/conexionbd.php';

// Obtener datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['postId'];
$userId = $data['userId'];
$comentario = $data['comentario'];

// Insertar el comentario en la base de datos
$sql = "INSERT INTO comentarios (id_publicacion, id_usuario, comentario) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('iis', $postId, $userId, $comentario);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al agregar comentario']);
}

$stmt->close();
$conexion->close();
?>
