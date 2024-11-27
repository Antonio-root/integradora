<?php
session_start();
require_once '../requires/conexionbd.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['id_usuario']) && !isset($_SESSION['id_vendedor'])) {
    header("Location: /integradora/requires/login.php");
    exit;
}

// Obtener datos del formulario
$contenido = isset($_POST['contenido']) ? $_POST['contenido'] : null;
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

try {
    // Verificar que el id_usuario exista si no es nulo
    if (!is_null($id_usuario)) {
        $query = "SELECT id_usuario FROM datosusuarios WHERE id_usuario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            die("Error: El id_usuario no existe en datosusuarios.");
        }
    }

    // Preparar la consulta SQL para insertar
    if (!is_null($id_usuario)) {
        $sql = "INSERT INTO publicaciones (id_usuario, contenido, imagen, id_negocio) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("issi", $id_usuario, $contenido, $imagen, $id_negocio);
    } elseif (!is_null($id_vendedor)) {
        $sql = "INSERT INTO publicaciones (id_vendedor, contenido, imagen, id_negocio) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("issi", $id_vendedor, $contenido, $imagen, $id_negocio);
    }

    // Ejecutar la consulta y manejar el resultado
    if ($stmt->execute()) {
        echo "Publicación realizada con éxito.";
        header('Location: comunidad.php');
        exit;
    } else {
        echo "Error en la publicación: " . $conexion->error;
    }
} catch (Exception $e) {
    echo "Ocurrió un error: " . $e->getMessage();
}
?>
