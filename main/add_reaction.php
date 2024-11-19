<?php
require_once '../requires/conexionbd.php';

$data = json_decode(file_get_contents("php://input"), true);

$postId = $data['postId'];
$userId = $data['userId'];
$reaction = $data['reaction'];

// Determinar si el usuario es un vendedor o usuario
$sql_user = "SELECT id_usuario FROM datosusuarios WHERE id_usuario = ?";
$sql_vendor = "SELECT id_vendedores FROM datosvendedores WHERE id_vendedores = ?";

$stmt_user = $conexion->prepare($sql_user);
$stmt_user->bind_param('i', $userId);
$stmt_user->execute();
$stmt_user->store_result();

if ($stmt_user->num_rows > 0) {
    // Es un usuario
    $stmt_user->bind_result($id_usuario);
    $stmt_user->fetch();
    $stmt = $conexion->prepare("INSERT INTO reacciones (id_publicacion, id_usuario, tipo) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $postId, $id_usuario, $reaction);
} else {
    // Es un vendedor
    $stmt_vendor = $conexion->prepare($sql_vendor);
    $stmt_vendor->bind_param('i', $userId);
    $stmt_vendor->execute();
    $stmt_vendor->store_result();

    if ($stmt_vendor->num_rows > 0) {
        // Es un vendedor
        $stmt_vendor->bind_result($id_vendedor);
        $stmt_vendor->fetch();
        $stmt = $conexion->prepare("INSERT INTO reacciones (id_publicacion, id_vendedor, tipo) VALUES (?, ?, ?)");
        $stmt->bind_param('iis', $postId, $id_vendedor, $reaction);
    }
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
