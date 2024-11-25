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
    <style>
        /* Reset de márgenes y padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Estilo general */
body {
    font-family: Arial, sans-serif;
    background-color: #88b04b; /* Fondo verde militar oscuro */
    color: #f5f5f5; /* Texto claro */
    line-height: 1.6;
}

/* Encabezado */
header {
    background-color: #3c3c3a; /* Verde militar intermedio */
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #4f4f4d; /* Línea de separación sutil */
    position: fixed; /* Fijo en la parte superior */
    top: 0;
    left: 0;
    width: 100%; /* Ocupa todo el ancho */
    z-index: 1000; /* Por encima de la barra lateral */
}

header h1 {
    font-size: 1.5rem;
    color: #d8d8d8; /* Texto claro */
}

.hamburger div {
    width: 25px;
    height: 3px;
    background-color: #d8d8d8;
    margin: 5px 0;
}

/* Navegación lateral */
.nav1 {
    position: fixed;
    top: 60px; /* Debajo del header */
    left: 0;
    height: calc(100% - 60px); /* Resta la altura del header */
    width: 220px;
    background-color: #4a4a48; /* Verde militar más fuerte */
    padding: 20px 10px;
    border-right: 1px solid #4f4f4d;
    z-index: 900; /* Por debajo del header */
    overflow-y: auto;
}

.nav1 nav ul {
    list-style: none;
}

.nav1 nav ul li {
    margin-bottom: 15px;
}

.nav1 nav ul li a {
    text-decoration: none;
    color: #d8d8d8; /* Texto claro */
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.nav1 nav ul li a:hover {
    background-color: #61615f; /* Verde militar más claro */
    color: #fff;
}

/* Menú desplegable */
.menu {
    display: none;
    position: absolute;
    top: 60px;
    right: 20px;
    background-color: #61615f;
    padding: 10px;
    list-style: none;
    border-radius: 5px;
}

.menu li {
    margin: 10px 0;
}

.menu li a {
    text-decoration: none;
    color: #fff;
    display: block;
}

/* Clase para mostrar menú desplegable */
.menu.show {
    display: block;
}

/* Contenido principal */
main {
    margin-left: 240px; /* Espacio para la navegación lateral */
    padding: 80px 20px 20px; /* Espacio adicional para evitar el encabezado */
    min-height: 100vh;
    background-color: #2e2e2c; /* Fondo verde militar oscuro */
}

/* Contenedor principal para las tarjetas */
.main {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  padding: 20px;
}

/* Estilos generales para las tarjetas */
.card {
  perspective: 1000px;
  width: 190px;
  height: 254px;
  overflow: visible;
}

.content {
  width: 100%;
  height: 100%;
  transform-style: preserve-3d;
  transition: transform 300ms;
  box-shadow: 0px 0px 10px 1px #000000ee;
  border-radius: 5px;
}

.front,
.back {
  background-color: #151515;
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  border-radius: 5px;
}

.back {
  display: flex;
  justify-content: center;
  align-items: center;
}

.back-content {
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 15px;
  text-align: center;
}

.card:hover .content {
  transform: rotateY(180deg);
}

.front {
  transform: rotateY(180deg);
  color: white;
}

.front-content {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
  padding: 15px;
}

.badge {
  background-color: #00000055;
  padding: 5px 10px;
  border-radius: 10px;
  backdrop-filter: blur(2px);
  width: fit-content;
}

.description {
  box-shadow: 0px 0px 10px 5px #00000088;
  padding: 10px;
  background-color: #00000099;
  backdrop-filter: blur(5px);
  border-radius: 5px;
  font-size: 0.9rem;
}

.title {
  display: flex;
  flex-direction: column;
  gap: 5px;
  font-size: 0.85rem;
  font-weight: bold;
}


/* Enlaces */
a {
    text-decoration: none;
    color: #88b04b; /* Verde militar claro */
}

a:hover {
    text-decoration: underline;
    color: #b2d39b; /* Verde más vibrante */
}

/* Diseño adaptable */
@media (max-width: 768px) {
    .nav1 {
        width: 180px;
    }

    main {
        margin-left: 190px;
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
