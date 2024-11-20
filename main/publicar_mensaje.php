<?php
session_start();
require_once '../requires/conexionbd.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['id_usuario']) && !isset($_SESSION['id_vendedor'])) {
    header("Location: /integradora/requires/login.php");
    exit;
}

// Obtener el contenido de la publicación
$contenido = $_POST['contenido'];
$id_negocio = isset($_POST['id_negocio']) ? $_POST['id_negocio'] : null;
$imagen = null;

// Si hay una imagen, manejarla
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagen = 'uploads/' . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen);
}

// Obtener el ID de usuario o vendedor desde la sesión
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
$id_vendedor = isset($_SESSION['id_vendedor']) ? $_SESSION['id_vendedor'] : null;

// Si no se especifica un negocio, lo dejamos como NULL
$id_negocio = ($id_negocio === null) ? NULL : $id_negocio;

// SQL para insertar la publicación, sin requerir id_negocio
$sql = "INSERT INTO publicaciones (id_usuario, id_vendedor, contenido, imagen, id_negocio) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

// Verifica si se ejecutó correctamente la consulta
$stmt->bind_param("iissi", $id_usuario, $id_vendedor, $contenido, $imagen, $id_negocio);

if ($stmt->execute()) {
    echo "Publicación realizada con éxito.";
    header('Location: comunidad.php'); // Redirigir a la comunidad
} else {
    echo "Error en la publicación: " . $conexion->error;
}
?>
