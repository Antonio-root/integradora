<?php
session_start();
require_once '../requires/conexionbd.php'; // Conexión a la base de datos

// Verifica si el usuario o vendedor está logueado
if (!isset($_SESSION['id_usuario']) && !isset($_SESSION['id_vendedor'])) {
    header("Location: /integradora/requires/login.php");
    exit;
}

// Verifica si se subió una imagen
if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
    echo "Error: No se subió una imagen válida.";
    exit;
}

// Manejar la imagen
$nombre_archivo = basename($_FILES['imagen']['name']);
$ruta_destino = 'uploads/' . $nombre_archivo;

// Verifica que el directorio de destino exista
if (!file_exists('uploads/')) {
    mkdir('uploads/', 0777, true); // Crear el directorio si no existe
}

// Mover la imagen al destino
if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
    echo "Error al mover la imagen al directorio de destino.";
    exit;
}

// Insertar la ruta de la imagen en la tabla correspondiente
if (isset($_SESSION['id_usuario'])) {
    // Es un usuario
    $id_usuario = $_SESSION['id_usuario'];
    $sql = "UPDATE datosusuarios SET imagen = ? WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $ruta_destino, $id_usuario);
} elseif (isset($_SESSION['id_vendedor'])) {
    // Es un vendedor
    $id_vendedor = $_SESSION['id_vendedor'];
    $sql = "UPDATE datosvendedores SET imagen = ? WHERE id_vendedor = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $ruta_destino, $id_vendedor);
}

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Imagen subida y actualizada con éxito.";
    header("Location: mi_perfil.php"); // Redirigir al perfil (ajusta esta ruta según tu aplicación)
    exit;
} else {
    echo "Error al actualizar la imagen: " . $stmt->error;
    exit;
}
?>
