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

if (!$postId) {
    echo json_encode(['success' => false, 'message' => 'ID de publicación no proporcionado']);
    exit;
}

// Determinar el tipo de usuario
$isVendedor = ($_SESSION['tipo'] === 'vendedor');

// Construir la consulta para obtener comentarios
$sql = "SELECT c.comentario, 
               COALESCE(u.nombre, v.nombre) AS nombre, 
               COALESCE(u.apellido, v.apellido) AS apellido, 
               c.fecha_comentario 
        FROM comentarios c
        LEFT JOIN datosusuarios u ON c.id_usuario = u.id_usuario
        LEFT JOIN datosvendedores v ON c.id_vendedor = v.id_vendedor
        WHERE c.id_publicacion = ?
        ORDER BY c.fecha_comentario DESC";

// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $postId);
$stmt->execute();
$result = $stmt->get_result();

$comentarios = [];
while ($row = $result->fetch_assoc()) {
    $comentarios[] = $row;
}

// Devolver la respuesta como JSON
echo json_encode(['success' => true, 'comentarios' => $comentarios]);

$stmt->close();
$conexion->close();
?>
