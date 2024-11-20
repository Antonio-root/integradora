<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: /integradora/requires/login.php');
    exit;
}


$tipo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'usuario'; 
//sql para obtener los datos de la tabla datosnegocios

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="/integradora/estilos/inicio.css">
</head>
<body>

<header>
    <h1>pagina de inicio yeaa shiit</h1>
    <div class="hamburger" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>
</header>

<div class="nav1">
    <nav>
        <ul class="barra">
            <li class="elemento"><a href="comida.php">Comidas</a></li>
            <li class="elemento"><a href="mercerias.php">Papeleria y merceria</a></li>
            <li class="elemento"><a href="ferreterias">Ferreterias</a></li>
            <li class="elemento"><a href="otroservicio.php">Servicios</a></li>
            <li class="elemento"><a href="comunidad.php">comunidad</a></li>
        </ul>
    </nav>
</div>

<!-- Menú desplegable -->
<ul class="menu" id="menu">
    <li><a href="perfil.php">Perfil</a></li>
    <li><a href="mensajes.php">Ver mensajes</a></li>
    <li><a href="notificaciones.php">Notificaciones</a></li>
    <?php if ($tipo === 'vendedor'): ?>
        <li><a href="editarnegocio.php">Mi negocio</a></li>
        <li><a href="ver_ratings.php">Ver ratings</a></li>
    <?php endif; ?>
    <li><a href="/integradora/requires/cerrarsesion.php">Cerrar sesión</a></li>
</ul>

<main>
    <div class="main">
        <p>aqui se pondran los diferentes negocios cerca de ti</p>
    </div>
</main>

<script>
    // Función para alternar el menú desplegable
    function toggleMenu() {
        var menu = document.getElementById('menu');
        menu.classList.toggle('show');
    }
</script>

</body>
</html>
