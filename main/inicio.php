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
            dn.imagen,
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
  height: 70px;
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
  background-color: #88b04b; /* Fondo verde militar oscuro */
  max-width: max-content;
}

/* Contenedor principal para las tarjetas */
.main {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Ajuste de columnas */
  gap: 20px;
  padding: 20px;
  width: 100%; /* Asegura que el contenedor ocupe todo el ancho */
}

/* Estilos generales para las tarjetas */
.card {
  perspective: 1000px;
  width: 100%; /* Se ajusta automáticamente según el espacio disponible */
  height: 350px; /* Altura ajustada */
  overflow: hidden; /* Asegura que nada sobresalga */
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out;
  display: flex;
  flex-direction: column;
  background-color: #151515;
}

/* Contenido de las tarjetas */
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
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  border-radius: 5px;
}

.front {
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 15px;
}

.back {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.back-content {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
  text-align: center;
  width: 100%;
  height: 100%;
  overflow: hidden; /* Asegura que la imagen no sobresalga del contenedor */
  border-radius: 10px;
}

.card:hover .content {
  transform: rotateY(180deg);
}

.front {
  transform: rotateY(180deg);
}

.title, .description {
  font-size: 0.9rem;
}

.badge {
  background-color: forestgreen;
  padding: 5px 10px;
  border-radius: 10px;
}

/* Nueva clase para la imagen de la parte trasera */
.back-content img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 10px;
  transition: all 0.6s ease;
  opacity: 0.7;
}

.card:hover .back-content img {
  opacity: 1;
}

/* Responsividad */
@media (max-width: 768px) {
  .main {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Ajuste en pantallas más pequeñas */
  }

  .card {
    height: 300px; /* Altura ajustada para pantallas más pequeñas */
  }
}

.juntos {
  display: flex;
  text-align: right;
}


    </style>
</head>
<body>

<header>
    <div class="juntos" > 
    <a href="index.php"> <img src="/integradora/imagenes/icono.svg" alt="icon" width="54" height="150px"></a>
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
            <li class="elemento"><a href="comunidad.php">Comunidad</a></li>
        </ul>
    </nav>
</div>

<!-- Menú desplegable -->
<ul class="menu" id="menu">
    <li><a href="mi_perfil.php">Perfil</a></li>
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
                                <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($row['ubicacion']); ?></p>
                                <p><strong>Horarios:</strong> <?php echo htmlspecialchars($row['horarios']); ?></p>
                                <p><strong>Vendedor:</strong> <?php echo htmlspecialchars($row['nombre_vendedor']); ?></p>
                            </div>
                            <div class="description">
                                <?php echo htmlspecialchars($row['descripcion']); ?>
                            </div>
                        </div>
                    </div>
                    <!-- Cara trasera -->
                    <div class="back">
                    <div class="back-content">
                         <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt=""> 
                        
                            
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
