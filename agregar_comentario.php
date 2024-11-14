<?php
session_start();
require_once 'conexiondb.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id_publicacion = $_POST['id_publicacion'];
$comentario = $_POST['comentario'];
$id_usuario = $_SESSION['id_usuario'];

$sql = "INSERT INTO comentarios (id_publicacion, id_usuario, comentario) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iis", $id_publicacion, $id_usuario, $comentario);

if ($stmt->execute()) {
    echo "Comentario agregado correctamente.";
} else {
    echo "Error al agregar el comentario: " . $conexion->error;
}
?>
