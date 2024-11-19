<?php
// Conectar a la base de datos
require_once '../requires/conexionbd.php';

// Consulta para obtener las publicaciones
$sql = "SELECT p.id_publicacion, p.contenido, p.imagen, d.nombre, d.apellido, p.id_vendedor,
            (SELECT COUNT(*) FROM reacciones r WHERE r.id_publicacion = p.id_publicacion) AS total_reacciones,
            (SELECT COUNT(*) FROM comentarios c WHERE c.id_publicacion = p.id_publicacion) AS total_comentarios
        FROM publicaciones p
        JOIN datosvendedores d ON p.id_vendedor = d.id_vendedores
        ORDER BY p.fecha_publicacion DESC";
$result = $conexion->query($sql);

if (!$result) {
    echo "Error en la consulta: " . $conexion->error;
    exit;
}
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

        .reacciones {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .reaction-button {
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ccc;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .reaction-button:hover {
            background-color: #ddd;
        }

        .comentarios {
            margin-top: 10px;
        }

        .comentarios button {
            background-color: #6c63ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .comentarios button:hover {
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
        <!-- Sección de publicaciones -->
        <section class="publicaciones">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <article data-post-id="<?php echo $row['id_publicacion']; ?>">
                    <h2><?php echo htmlspecialchars($row['nombre'] . " " . $row['apellido']); ?></h2>
                    <p><?php echo htmlspecialchars($row['contenido']); ?></p>
                    <?php if ($row['imagen']) : ?>
                        <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen">
                    <?php endif; ?>

                    <!-- Contador de Reacciones -->
                    <div class="reacciones">
                        <span><?php echo $row['total_reacciones']; ?> Reacciones</span>
                    </div>

                    <!-- Contador de Comentarios -->
                    <div class="comentarios">
                        <span><?php echo $row['total_comentarios']; ?> Comentarios</span>
                    </div>

                    <!-- Botones de reacciones -->
                    <div class="reacciones">
                        <button class="reaction-button" data-reaction="like">👍 Me gusta</button>
                        <button class="reaction-button" data-reaction="love">❤️ Me encanta</button>
                        <button class="reaction-button" data-reaction="angry">😡 Me enoja</button>
                    </div>

                    <!-- Botón de comentarios -->
                    <div class="comentarios">
                        <button class="comment-button">💬 Comentarios</button>
                    </div>
                </article>
            <?php endwhile; ?>
        </section>

        <!-- Perfil del usuario -->
        <aside class="right">
            <div class="perfil">
                <?php if ($is_vendor): ?>
                    <!-- Mostrar datos del vendedor -->
                    <img src="/integradora/imagenes/vendedor_perfil.jpg" alt="Foto de perfil">
                    <p><?php echo htmlspecialchars($nombre_vendedor . " " . $apellido_vendedor); ?></p>
                <?php else: ?>
                    <!-- Mostrar datos del usuario -->
                    <img src="/integradora/imagenes/usuario_perfil.jpg" alt="Foto de perfil">
                    <p><?php echo htmlspecialchars($nombre_usuario . " " . $apellido_usuario); ?></p>
                <?php endif; ?>
            </div>
            <button>Categorías</button>
            <button>Comida</button>
            <button>Papelería</button>
        </aside>

    </main>

    <!-- Cerrar sesión -->
    <button><a href="/integradora/requires/cerrarsesion.php">Cerrar sesión</a></button>

    <script>
        // Funcionalidad para manejar reacciones
        document.querySelectorAll('.reaction-button').forEach((button) => {
            button.addEventListener('click', function() {
                const reaction = this.getAttribute('data-reaction');
                const postId = this.closest('article').getAttribute('data-post-id');
                const userId = <?php echo $userId; ?>;

                fetch('check_reaction.php', {
                    method: 'POST',
                    body: JSON.stringify({ postId, userId }),
                    headers: { 'Content-Type': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.reacted) {
                        alert('Ya has reaccionado a esta publicación');
                    } else {
                        fetch('add_reaction.php', {
                            method: 'POST',
                            body: JSON.stringify({ postId, userId, reaction }),
                            headers: { 'Content-Type': 'application/json' }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Reacción registrada:', data);
                        });
                    }
                });
            });
        });

        // Funcionalidad para manejar comentarios
        document.querySelectorAll('.comment-button').forEach((button) => {
            button.addEventListener('click', function() {
                const postId = this.closest('article').getAttribute('data-post-id');
                
                const form = document.createElement('form');
                form.innerHTML = `
                    <textarea name="comentario" placeholder="Escribe tu comentario..." rows="4" cols="50"></textarea><br>
                    <button type="submit">Enviar comentario</button>
                `;
                this.parentElement.appendChild(form);

                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const comentario = form.querySelector('textarea').value;
                    const userId = <?php echo $userId; ?>;

                    fetch('add_comment.php', {
                        method: 'POST',
                        body: JSON.stringify({ postId, userId, comentario }),
                        headers: { 'Content-Type': 'application/json' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Comentario registrado:', data);
                    });
                });
            });
        });
    </script>

</body>
</html>
