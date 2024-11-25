<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: /integradora/requires/login.php');
    exit;
}


$tipo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'usuario'; 
//sql para obtener el nombre de usuario
$nombre = $_SESSION['nombre'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/integradora/estilos/editarnegocios.css">
    <title>Editar Perfil</title>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar">
        <div class="nav-left">
            <img src="/integradora/imagenes/icon.png" alt="Foto del usuario" class="user-photo">
        </div>
        <div class="nav-right">
            <button><a href="inicio.php">Inicio</a></button>
            <button><a href="/integradora/requires/cerrarsesion.php">Cerrar Sesión</a></button>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <main class="main-content">
        <section class="welcome">
            <img src="/integradora/imagenes/foto_usuario.png" alt="Foto del usuario" class="user-avatar">
            <h1>Bienvenido, <?php echo $nombre ?></h1>
            <p>Gestiona tu perfil y configuraciones para personalizar tu experiencia.</p>
        </section>

        <!-- Tarjetas de acciones -->
        <section class="action-cards">
            <div class="card">
                <h3>Agregar imagen</h3>
                <p>Sube una nueva imagen para tu negocio o perfil.</p>
                <a href="#">Subir imagen</a>
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
                <p>Actualiza la información de tu negocio o perfil.</p>
                <a href="registronegocios.php">Editar perfil</a>
            </div>
        </section>
    </main>
</body>
</html>
