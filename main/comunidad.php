<?php
// Código para obtener publicaciones
require_once '../requires/conexionbd.php';

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
    <style>
        /* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

/* Estilos del cuerpo y la pantalla */
body {
    background-color: #f4f4f9;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
}

header {
    text-align: center;
    margin-bottom: 20px;
}

header h1 {
    font-size: 2.5rem;
    color: #6c63ff;
}

aside {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
}

.perfil {
    text-align: center;
    margin-bottom: 20px;
}

.perfil img {
    border-radius: 50%;
    width: 100px;
    height: 100px;
    object-fit: cover;
    margin-bottom: 10px;
}

.perfil p {
    font-size: 1.2rem;
    color: #6c63ff;
}

button {
    background-color: #6c63ff;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 5px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #5851db;
}

main {
    width: 100%;
    max-width: 1200px;
    margin: 20px auto;
    display: flex;
    justify-content: space-between;
    gap: 40px; /* Espacio entre las secciones dentro de main */
}

a {
    color: white;
    text-decoration: none;
}

.publicaciones {
    display: flex;
    flex-direction: column;
    gap: 20px;
    flex: 1;
}

article {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    transition: transform 0.3s ease;
}

article:hover {
    transform: translateY(-5px);
}

article h2 {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: #333;
}

article p {
    font-size: 1rem;
    line-height: 1.6;
    color: #555;
}

article img {
    width: 100%;
    max-width: 400px;
    height: auto;
    border-radius: 10px;
    margin-top: 10px;
}

/* Aside izquierdo */
aside.left {
    width: 20%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.left button {
    background-color: #6c63ff;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 5px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.left button:hover {
    background-color: #5851db;
}

/* Perfil a la derecha */
aside.right {
    width: 20%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

@media (max-width: 768px) {
    body {
        flex-direction: column;
        align-items: center;
    }

    aside.left, aside.right, main {
        width: 100%;
        margin: 10px 0;
    }

    .publicaciones {
        align-items: center;
    }
}
</style>
</head>
<body>
    <header>
        <h1>Comunidad</h1>
    </header>
    <main>

        <section class="left">
        <button> <a href="publicacion.html">Hacer publicación</a> </button>
        </section>
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

        <aside>
        <div class="perfil">
            <img src="/integradora/imagenes/foto_perfil.jpg" alt="Foto de perfil">
            <p>Nombre de Usuario</p>
        </div>
        <button>Categorías</button>
        <button>Comida</button>
        <button>Papelería</button>
        <!-- Agregar más categorías aquí -->
    </aside>
    </main>
    <button><a href="/integradora/requires/cerrarsesion.php">Cerrar sesion</a></button>
</body>
</html>
