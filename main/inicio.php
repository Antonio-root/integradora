<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: /integradora/requires/login.php');
    exit;
}
require_once('../requires/conexionbd.php');
$tipo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'usuario'; 

// Consulta para obtener los datos de negocios y vendedores
$sql = "SELECT 
            dn.nombredenegocio AS nombre_negocio,
            dn.ubicacion,
            dn.horarios,
            dn.contacto,
            dn.tipo,
            dn.descripcion,
            CONCAT(dv.nombre, ' ', dv.apellido) AS nombre_vendedor
        FROM datosnegocios dn
        INNER JOIN datosvendedores dv ON dn.id_vendedor = dv.id_vendedor";

$result = $conexion->query($sql);


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
    <div class="juntos" > 
    <img src="/integradora/imagenes/icono.svg" alt="icon" width="54" height="150px">
    <h1>Together is Better</h1>
    </div>
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
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <div class="content">
                    <!-- Cara delantera -->
                    <div class="front">
                        <div class="front-content">
                            <div class="badge"><?php echo htmlspecialchars($row['tipo']); ?></div>
                            <div class="title">
                                <p><strong>Negocio:</strong> <?php echo htmlspecialchars($row['nombre_negocio']); ?></p>
                                <p><strong>Contacto:</strong> <?php echo htmlspecialchars($row['contacto']); ?></p>
                            </div>
                            <div class="description">
                                <?php echo htmlspecialchars($row['descripcion']); ?>
                            </div>
                        </div>
                    </div>
                    <!-- Cara trasera -->
                    <div class="back">
                        <div class="back-content">
                            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($row['ubicacion']); ?></p>
                            <p><strong>Horarios:</strong> <?php echo htmlspecialchars($row['horarios']); ?></p>
                            <p><strong>Vendedor:</strong> <?php echo htmlspecialchars($row['nombre_vendedor']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No hay negocios registrados.</p>
    <?php endif; ?>
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
