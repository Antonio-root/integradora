<?php
require_once '../requires/conexionbd.php';

$data = json_decode(file_get_contents("php://input"), true);
$postId = $data['postId'];

// Obtener el contador de reacciones
$sql = "SELECT COUNT(*) AS total_reacciones FROM reacciones WHERE id_publicacion = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['total_reacciones' => $row['total_reacciones']]);
?>
