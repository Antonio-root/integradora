<?php
session_start();
require_once 'conexionbd.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id_publicacion = $_POST['id_publicacion'];
$tipo_reaccion = $_POST['tipo_reaccion']; // Ejemplo: "like", "love"
$id_usuario = $_SESSION['id_usuario'];

$sql = "INSERT INTO reacciones (id_publicacion, id_usuario, tipo) VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE tipo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iiss", $id_publicacion, $id_usuario, $tipo_reaccion, $tipo_reaccion);

if ($stmt->execute()) {
    echo "Reacción agregada correctamente.";
} else {
    echo "Error al agregar la reacción: " . $conexion->error;
}
?>
