<?php
// Código para obtener publicaciones
require_once '/requires/conexionbd.php';

$sql = "SELECT p.contenido, p.imagen, d.nombre, d.apellido FROM publicaciones p JOIN datosvendedores d ON p.id_vendedor = d.id_vendedores ORDER BY p.fecha_publicacion DESC";
$result = $conexion->query($sql);

if (!$result) {
    echo "Error en la consulta: " . $conexion->error;
    exit;
}

$sql2 = "SELECT p.contenido, p.imagen, u.nombre, u.apellidos FROM publicaciones p JOIN datosnegocios u ON p.id_vendedor = u.id_usuario ORDER BY p.fecha_publicacion DESC";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comunidad</title>
    <link rel="stylesheet" href="/estilos/styles.css">
</head>
<body>
    <header>
        <h1>Comunidad</h1>
    </header>
    <aside>
        <div class="perfil">
            <img src="foto_perfil.jpg" alt="Foto de perfil">
            <p>Nombre de Usuario</p>
        </div>
        <button>Categorías</button>
        <button>Comida</button>
        <button>Papelería</button>
        <!-- Agregar más categorías aquí -->
    </aside>
    <main>
        <a href="publicacion.html">Hacer publicación</a>
        <section class="publicaciones">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <article>
                    <h2><?php echo htmlspecialchars($row['nombre'] . " " . $row['apellido']); ?></h2>
                    <p><?php echo htmlspecialchars($row['contenido']); ?></p>
                    <?php if ($row['imagen']) : ?>
                        <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen">
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>
        </section>
    </main>
    <button><a href="cerrarsesion.php">Cerrar sesion</a></button>
</body>
</html>
