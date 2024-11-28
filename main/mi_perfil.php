<?php
session_start();

// Incluye la conexión a la base de datos
require_once('../requires/conexionbd.php');

// Verifica si el usuario está autenticado
if (!isset($_SESSION['id_usuario']) && !isset($_SESSION['id_vendedor'])) {
    header("Location: login.php");
    exit();
}

// Determina el tipo de usuario
$tipo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'usuario'; 

// Inicializa la variable para almacenar los datos del perfil
$perfil = null;

// Obtén los datos del usuario autenticado
if (isset($_SESSION['id_usuario'])) {
    $id = $_SESSION['id_usuario'];
    // Prepara la consulta con MySQLi
    $query = "SELECT * FROM datosusuarios WHERE id_usuario = ?";
    $stmt = $conexion->prepare($query); // Prepara la consulta
    $stmt->bind_param("i", $id); // Vincula el parámetro
    $stmt->execute(); // Ejecuta la consulta
    $result = $stmt->get_result(); // Obtiene el resultado
    $perfil = $result->fetch_assoc(); // Obtiene los datos en un array asociativo
    $stmt->close(); // Cierra la consulta
} elseif (isset($_SESSION['id_vendedor'])) {
    $id = $_SESSION['id_vendedor'];
    // Prepara la consulta para el vendedor y sus datos del negocio
    $query = "SELECT dv.*, dn.nombredenegocio, dn.descripcion, dn.imagen AS imagen_negocio
            FROM datosvendedores dv
            LEFT JOIN datosnegocios dn ON dv.id_vendedor = dn.id_vendedor
            WHERE dv.id_vendedor = ?";
    $stmt = $conexion->prepare($query); // Prepara la consulta
    $stmt->bind_param("i", $id); // Vincula el parámetro
    $stmt->execute(); // Ejecuta la consulta
    $result = $stmt->get_result(); // Obtiene el resultado
    $perfil = $result->fetch_assoc(); // Obtiene los datos en un array asociativo
    $stmt->close(); // Cierra la consulta
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
</head>
<body>
    <h1>Mi Perfil</h1>
    <?php if ($perfil): ?>
        <?php if (isset($_SESSION['id_usuario'])): ?>
            <img src="<?= htmlspecialchars($perfil['imagen']) ?>" alt="Foto de perfil">
            <h2><?= htmlspecialchars($perfil['nombre']) ?> <?= htmlspecialchars($perfil['apellido']) ?></h2>
            <p>Email: <?= htmlspecialchars($perfil['email']) ?></p>
            <p>Teléfono: <?= htmlspecialchars($perfil['telefono']) ?></p>
        <?php elseif (isset($_SESSION['id_vendedor'])): ?>
            <img src="<?= htmlspecialchars($perfil['imagen']) ?>" alt="Foto de perfil">
            <h2><?= htmlspecialchars($perfil['nombre']) ?> <?= htmlspecialchars($perfil['apellido']) ?></h2>
            <p>Negocio: <?= htmlspecialchars($perfil['nombredenegocio']) ?></p>
            <p>Descripción: <?= htmlspecialchars($perfil['descripcion']) ?></p>
        <?php endif; ?>
    <?php else: ?>
        <p>No se pudo cargar la información del perfil.</p>
    <?php endif; ?>
    <a href="editar_perfil.php">Editar Perfil</a>
    <a href="inicio.php">Inicio</a>
</body>
</html>
