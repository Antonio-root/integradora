<?php
session_start();
require_once '../requires/conexionbd.php';

// Obtener datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['postId'];

// Suponiendo que la sesión guarda el ID del usuario y el tipo de usuario
$userId = $_SESSION['id_usuario']; // ID del usuario o vendedor
$isVendedor = $_SESSION['tipo'] == 'vendedor'; // Si es un vendedor

// Si es un vendedor, mostramos comentarios de cualquier usuario o del propio vendedor
if ($isVendedor) {
    // Consulta para obtener los comentarios de la publicación (incluye comentarios de usuarios y vendedores)
    $sql = "SELECT c.comentario, u.nombre, u.apellido, c.fecha_comentario 
            FROM comentarios c
            JOIN datosusuarios u ON c.id_usuario = u.id_usuario
            LEFT JOIN datosvendedores v ON c.id_vendedor = v.id_vendedores
            WHERE c.id_publicacion = ? 
            ORDER BY c.fecha_comentario DESC";
} else {
    // Si es un usuario normal, solo mostramos los comentarios de otros usuarios, no de vendedores
    $sql = "SELECT c.comentario, u.nombre, u.apellido, c.fecha_comentario 
            FROM comentarios c
            JOIN datosusuarios u ON c.id_usuario = u.id_usuario
            WHERE c.id_publicacion = ? 
            AND c.id_vendedor IS NULL
            ORDER BY c.fecha_comentario DESC";
}

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
