<?php
session_start();
require_once '../requires/conexionbd.php';

// Obtener datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['postId'];

// Obtener los comentarios de la base de datos
$sql = "SELECT c.comentario, u.nombre, u.apellido FROM comentarios c
        JOIN datosusuarios u ON c.id_usuario = u.id_usuario
        WHERE c.id_publicacion = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $postId);
$stmt->execute();
$result = $stmt->get_result();

$comentarios = [];
while ($row = $result->fetch_assoc()) {
    $comentarios[] = $row;
}

echo json_encode(['success' => true, 'comentarios' => $comentarios]);

$stmt->close();
$conexion->close();
?>
