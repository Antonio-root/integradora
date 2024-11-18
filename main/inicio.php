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
    <style>
        .nav1 {
            font-family: monospace;
            background-color: aqua;
            color: red;
            justify-content: space-around;
            height: 40px;
        }
        .barra {
            justify-content: space-around;
            display: flex;
        }
        .elemento {
            background-color: aqua;
            text-align: center;
            margin: 0px;
            height: 20px;
            padding: 10px;
        }
        li:hover {
            transition: 350ms;
            background-color: blueviolet;
        }
        .cerrar {
            padding: 1rem 2rem;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        .cerrar:hover {
            transform: rotate(20deg);
            transition: 350ms;
            background-color: aqua;
        }

        /* Estilos para el botón hamburguesa */
        .hamburger {
            display: flex; /* Visibilidad para pruebas */
            cursor: pointer;
            position: absolute;
            top: 15px;
            right: 20px;
            width: 30px;
            height: 25px;
            flex-direction: column;
            justify-content: space-between;
        }
        .hamburger div {
            width: 30px;
            height: 4px;
            background-color: #333;
            border-radius: 2px;
        }

        /* Menú desplegable */
        .menu {
            display: none;
            position: absolute;
            top: 50px;
            right: 20px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            width: 200px;
            padding: 10px 0;
            list-style: none;
            margin: 0;
        }
        .menu li {
            padding: 10px 20px;
            text-align: left;
        }
        .menu li:hover {
            background-color: #ddd;
        }

        /* Mostrar el menú cuando se hace click en el botón hamburguesa */
        .menu.show {
            display: block;
        }
        
        /* Hacer visible el botón hamburguesa en pantallas pequeñas */
        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }
        }

    </style>
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
