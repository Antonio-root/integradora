<?php
session_start();
require_once '../requires/conexionbd.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['loggedin'])) {
    header("Location: /integradora/requires/login.php");
    exit;
}

// Inicializar variables de usuario o vendedor según la sesión
$id_usuario = null;
$id_vendedor = null;

if ($_SESSION['tipo'] === 'usuario') {
    $id_usuario = $_SESSION['id_usuario'];
} elseif ($_SESSION['tipo'] === 'vendedor') {
    $id_vendedor = $_SESSION['id_vendedor'];
} else {
    die("Error: Tipo de usuario no identificado.");
}

// Validar que se haya enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contenido = $_POST['contenido'] ?? null;
    $id_negocio = $_POST['id_negocio'] ?? null;
    $imagen = null;

    // Manejar la subida de imágenes
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = 'uploads/' . basename($_FILES['imagen']['name']);
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen)) {
            die("Error al subir la imagen.");
        }
    }

    // Validar que el contenido no esté vacío
    if (empty($contenido)) {
        echo "El contenido de la publicación no puede estar vacío.";
        exit;
    }

    try {
        // Preparar consulta SQL para insertar publicación
        $sql = "INSERT INTO publicaciones (id_usuario, id_vendedor, contenido, imagen, id_negocio) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        // Asignar valores a los parámetros según el tipo de sesión
        $stmt->bind_param(
            "iissi", 
            $id_usuario, 
            $id_vendedor, 
            $contenido, 
            $imagen, 
            $id_negocio
        );

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Publicación realizada con éxito.";
            header('Location: comunidad.php'); // Redirigir a la comunidad
            exit;
        } else {
            echo "Error en la publicación: " . $stmt->error;
        }
    } catch (Exception $e) {
        echo "Error al procesar la publicación: " . $e->getMessage();
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
