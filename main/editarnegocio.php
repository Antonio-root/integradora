<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: /integradora/requires/login.php');
    exit;
}

require_once '../requires/conexionbd.php';

// Obtener datos del usuario desde la sesión
$tipo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'usuario';
$nombre = $_SESSION['nombre'];

// Validar si el vendedor tiene un ID asignado en la sesión
if (!isset($_SESSION['id_vendedor'])) {
    die("ERROR: No se encontró el ID del vendedor en la sesión.");
}
$id_vendedor = $_SESSION['id_vendedor'];

// Consulta para obtener los negocios del vendedor
try {
    $query = "SELECT id_negocio, nombredenegocio, imagen, descripcion FROM datosnegocios WHERE id_vendedor = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_vendedor);
    $stmt->execute();
    $result = $stmt->get_result();
    $negocios = $result->fetch_all(MYSQLI_ASSOC); // Obtiene todas las filas como un array asociativo
    $stmt->close();
} catch (Exception $e) {
    die("Error al obtener los negocios: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/integradora/estilos/editarnegocios.css">
    <title>Editar Perfil</title>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="nav-left">
            <a href="index.php"> <img src="/integradora/imagenes/icono.svg" height="100px" width="50px" alt="Foto del usuario" class="user-photo"></a>
        </div>
        <div class="nav-right">
            <button><a href="inicio.php">Inicio</a></button>
            <button><a href="/integradora/requires/cerrarsesion.php">Cerrar Sesión</a></button>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <main class="main-content">
    <section class="welcome">
    <?php if (!empty($negocios)): ?>
                <?php foreach ($negocios as $negocio): ?>
                    <div class="card">
                        <img src="<?= htmlspecialchars($negocio['imagen']); ?>" 
                             alt="Imagen de <?= htmlspecialchars($negocio['nombredenegocio']); ?>" 
                             class="user-avatar">
                            <h1>Bienvenido <?php echo $nombre ?> </h1>
                            <p><?= htmlspecialchars($negocio['descripcion']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No tienes negocios registrados aún.</p>
            <?php endif; ?>
        </section>

        <!-- Tarjetas de negocios -->
        <section class="action-cards">
            

        <!-- Tarjetas de acciones -->
        
            <div class="card">
                <h3>Agregar imagen</h3>
                <p>Sube una nueva imagen para tu negocio o negocios.</p>
                <form action="imagen_negocio.php" method="post" enctype="multipart/form-data">
                    <label for="imagen">Subir Imagen:</label>
                    <input type="file" name="imagen" id="imagen" required>
                    <button type="submit">Subir Imagen</button>
                </form>
            </div>
            <div class="card">
                <h3>Hacer publicación</h3>
                <p>Crea contenido para destacar tu negocio.</p>
                <a href="publicacion.php">Crear publicación</a>
            </div>
            <div class="card">
                <h3>Hacer promoción</h3>
                <p>Promociona tus servicios para llegar a más clientes.</p>
                <a href="#">Ver promociones</a>
            </div>
            <div class="card">
                <h3>Mensajes</h3>
                <p>Gestiona tus mensajes con clientes y seguidores.</p>
                <a href="#">Abrir mensajes</a>
            </div>
            <div class="card">
                <h3>Editar Info</h3>
                <p>Actualiza la información de tu negocio o negocios.</p>
                <a href="registronegocios.php">Editar negocios</a>
            </div>
        </section>
    </main>
</body>
</html>
