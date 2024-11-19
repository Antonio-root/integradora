<?php
require_once '../requires/conexionbd.php';

$data = json_decode(file_get_contents("php://input"), true);

$postId = $data['postId'];
$userId = $data['userId'];

// Verificar si el usuario ya reaccionó a esta publicación
$sql = "SELECT COUNT(*) FROM reacciones WHERE id_publicacion = ? AND (id_usuario = ? OR id_vendedor = ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('iii', $postId, $userId, $userId);
$stmt->execute();
$stmt->bind_result($reaction_count);
$stmt->fetch();

echo json_encode(['reacted' => $reaction_count > 0]);
?>
