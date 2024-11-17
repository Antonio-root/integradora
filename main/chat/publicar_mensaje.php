<?php
session_start();
require_once 'conexionbd.php';

if (!isset($_SESSION['id_usuario']) && !isset($_SESSION['id_vendedor'])) {
    header("Location: login.php");
    exit;
}

$contenido = $_POST['contenido'];
$id_negocio = isset($_POST['id_negocio']) ? $_POST['id_negocio'] : null;
$imagen = null;

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagen = 'uploads/' . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen);
}

$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
$id_vendedor = isset($_SESSION['id_vendedor']) ? $_SESSION['id_vendedor'] : null;

$sql = "INSERT INTO publicaciones (id_usuario, id_vendedor, contenido, imagen, id_negocio) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iissi", $id_usuario, $id_vendedor, $contenido, $imagen, $id_negocio);

if ($stmt->execute()) {
    echo "Publicación realizada con éxito.";
} else {
    echo "Error en la publicación: " . $conexion->error;
}
?>
