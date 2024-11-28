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
    <style>
        /* Estilo general para el cuerpo */
body {
    font-family: 'Arial', sans-serif;
    background-color: #e5e5e5; /* Fondo claro para contraste con neumorphism */
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Centra el contenido verticalmente */
    flex-direction: column;
}

/* Header */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #2d6a4f; /* Verde oscuro para el fondo del header */
    padding: 20px;
    width: 100%;
    box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1), -4px -4px 10px rgba(255, 255, 255, 0.7); /* Neumorphism */
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
}

/* Logo */
header img {
    width: 54px;
    height: auto;
}

/* Enlaces del Header */
header a {
    color: white;
    text-decoration: none;
    font-size: 1.2rem;
    margin-left: 20px;
    transition: 0.3s;
}

header a:hover {
    color: #a8dadc; /* Verde claro para el hover */
}

/* Contenedor principal */
.container {
    width: 80%;
    margin: 100px auto 20px auto; /* Ajuste para que no se solape con el header */
    padding: 20px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.7); /* Neumorphism */
    text-align: center;
}

/* Títulos */
h1, h2 {
    color: #2d6a4f; /* Verde oscuro para los títulos */
    font-size: 2rem;
    margin-bottom: 10px;
}

/* Estilo de imagen de perfil */
img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1), -4px -4px 10px rgba(255, 255, 255, 0.7); /* Neumorphism */
}

/* Formulario de carga de imagen */
form {
    margin-bottom: 20px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.1), -4px -4px 15px rgba(255, 255, 255, 0.7); /* Neumorphism */
}

label {
    font-size: 1rem;
    color: #2d6a4f; /* Verde oscuro */
}

input[type="file"] {
    margin-top: 10px;
    padding: 10px;
    border: none;
    border-radius: 10px;
    background-color: #f4f7f6;
    box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1), -4px -4px 10px rgba(255, 255, 255, 0.7); /* Neumorphism */
}

button[type="submit"] {
    background-color: #2d6a4f; /* Verde principal */
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 20px;
    margin-top: 20px;
    cursor: pointer;
    font-size: 1rem;
    transition: 0.3s;
    box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1), -4px -4px 10px rgba(255, 255, 255, 0.7); /* Neumorphism */
}

button[type="submit"]:hover {
    background-color: #1b5d42; /* Cambio a verde más oscuro al pasar el mouse */
}

/* Estilo para los enlaces dentro del body */
a {
    color: #2d6a4f;
    text-decoration: none;
    font-size: 1rem;
    margin-right: 20px;
    transition: 0.3s;
}

a:hover {
    color: #1b5d42; /* Verde oscuro al pasar el mouse */
}

/* Estilo para los párrafos */
p {
    font-size: 1rem;
    margin-bottom: 10px;
}

/* Responsividad */
@media (max-width: 768px) {
    .container {
        width: 95%;
    }
    
    h1, h2 {
        font-size: 1.5rem;
    }
    
    img {
        width: 120px;
        height: 120px;
    }

    header a {
        font-size: 1rem;
        margin-left: 15px;
    }
}
</style>
</head>
<body>
    <header>
    <a href="index.php"> <img src="/integradora/imagenes/icono.svg" alt="icon" width="54" height="150px"></a>
    <a href="inicio.php">Inicio</a>
    </header>
    <h1>Mi Perfil</h1>
    <?php if ($perfil): ?>
        <?php if (isset($_SESSION['id_usuario'])): ?>
            <img src="<?= htmlspecialchars($perfil['imagen']) ?>" alt="Foto de perfil">
            <form action="imagen_perfil.php" method="post" enctype="multipart/form-data">
                <label for="imagen">Subir Imagen:</label>
                <input type="file" name="imagen" id="imagen" required>
                <button type="submit">Subir Imagen</button>
            </form>

            <h2><?= htmlspecialchars($perfil['nombre']) ?> <?= htmlspecialchars($perfil['apellido']) ?></h2>
            <p>Email: <?= htmlspecialchars($perfil['email']) ?></p>
            <p>Teléfono: <?= htmlspecialchars($perfil['telefono']) ?></p>
        <?php elseif (isset($_SESSION['id_vendedor'])): ?>
            <img src="<?= htmlspecialchars($perfil['imagen']) ?>" alt="Foto de perfil">
            <form action="imagen_perfil.php" method="post" enctype="multipart/form-data">
                <label for="imagen">Subir Imagen:</label>
                <input type="file" name="imagen" id="imagen" required>
                <button type="submit">Subir Imagen</button>
            </form>
            <h2><?= htmlspecialchars($perfil['nombre']) ?> <?= htmlspecialchars($perfil['apellido']) ?></h2>
            <p>Negocio: <?= htmlspecialchars($perfil['nombredenegocio']) ?></p>
            <p>Descripción: <?= htmlspecialchars($perfil['descripcion']) ?></p>
        <?php endif; ?>
    <?php else: ?>
        <p>No se pudo cargar la información del perfil.</p>
    <?php endif; ?>
    
</body>
</html>
