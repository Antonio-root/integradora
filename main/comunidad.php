<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: /integradora/requires/login.php');
    exit;
}

// Determinar el tipo de usuario y asignar el ID correspondiente
$tipo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'usuario';
$userId = null;

if ($tipo === 'usuario' && isset($_SESSION['id_usuario'])) {
    $userId = $_SESSION['id_usuario'];
} elseif ($tipo === 'vendedor' && isset($_SESSION['id_vendedor'])) {
    $userId = $_SESSION['id_vendedor'];
} else {
    die("Error: No se pudo determinar el ID del usuario o vendedor.");
}

// Conectar a la base de datos
require_once '../requires/conexionbd.php';

// Consulta general de publicaciones
$sql = "SELECT p.id_publicacion, p.contenido, p.imagen, 
               COALESCE(u.nombre, d.nombre) AS nombre, 
               COALESCE(u.apellido, d.apellido) AS apellido,
               p.id_vendedor,
               (SELECT COUNT(*) FROM reacciones r WHERE r.id_publicacion = p.id_publicacion) AS total_reacciones,
               (SELECT COUNT(*) FROM comentarios c WHERE c.id_publicacion = p.id_publicacion) AS total_comentarios
        FROM publicaciones p
        LEFT JOIN datosvendedores d ON p.id_vendedor = d.id_vendedor
        LEFT JOIN datosusuarios u ON p.id_usuario = u.id_usuario
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidad</title>
    <link rel="stylesheet" href="/integradora/estilos/comunidad.css">
</head>
<body>
    <header>
        <h1>Comunidad</h1>
    </header>
    <main>
        <!-- Noticias -->
        <aside class="left">
            <div class="news">
                <h2>Noticias</h2>
                <div class="news-item">
                    <h3>Noticia 1</h3>
                    <p>Descripción de la noticia 1</p>
                    <p>Fecha de la noticia 1</p>
                    <p>Autor de la noticia 1</p>
                </div>
            </div>
        </aside>

        <!-- Publicaciones -->
        <section class="publicaciones">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <article data-post-id="<?php echo $row['id_publicacion']; ?>">
                    <h2><?php echo htmlspecialchars($row['nombre'] . " " . $row['apellido']); ?></h2>
                    <p><?php echo htmlspecialchars($row['contenido']); ?></p>
                    <?php if ($row['imagen']) : ?>
                        <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen de publicación">
                    <?php endif; ?>

                    <div class="reacciones">
                        <span><?php echo $row['total_reacciones']; ?> Reacciones</span>
                        <button class="reaction-button" data-reaction="like">👍 Me gusta</button>
                        <button class="reaction-button" data-reaction="love">❤️ Me encanta</button>
                        <button class="reaction-button" data-reaction="angry">😡 Me enoja</button>
                    </div>

                    <div class="comentarios">
                        <span><?php echo $row['total_comentarios']; ?> Comentarios</span>
                        <button class="comment-button">💬 Agregar comentario</button>
                        <button class="ver-comment">Ver comentarios</button>
                        <div class="comentarios-list" style="display: none;"></div>
                    </div>
                </article>
            <?php endwhile; ?>
        </section>

        <!-- Perfil -->
        <aside class="right">
            <div class="perfil">
                <?php if ($tipo == 'vendedor'): ?>
                    <img src="/integradora/imagenes/vendedor_perfil.jpg" alt="Foto de perfil">
                <?php else: ?>
                    <img src="/integradora/imagenes/usuario_perfil.jpg" alt="Foto de perfil">
                <?php endif; ?>
                <p><?php echo htmlspecialchars($_SESSION['nombre'] . " " . $_SESSION['apellido']); ?></p>
                <button><a href="mi_perfil.php">Mi perfil</a></button>
                <button><a href="publicacion.php">Hacer una publicación</a></button>
                <button><a href="inicio.php">Inicio</a></button>
                <button><a href="/integradora/requires/cerrarsesion.php">Cerrar sesión</a></button>
            </div>
        </aside>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mostrar/Ocultar lista de comentarios
            document.querySelectorAll('.ver-comment').forEach(button => {
                button.addEventListener('click', function () {
                    const article = this.closest('article');
                    const commentList = article.querySelector('.comentarios-list');

                    if (commentList.style.display === 'none' || commentList.style.display === '') {
                        fetchComments(article.dataset.postId, commentList);
                        commentList.style.display = 'block';
                    } else {
                        commentList.style.display = 'none';
                    }
                });
            });

            // Agregar comentario
            document.querySelectorAll('.comment-button').forEach(button => {
                button.addEventListener('click', function () {
                    const article = this.closest('article');
                    const commentForm = article.querySelector('.comment-form');

                    if (!commentForm) {
                        const newCommentForm = document.createElement('div');
                        newCommentForm.classList.add('comment-form');
                        newCommentForm.innerHTML = `
                            <textarea placeholder="Escribe tu comentario..."></textarea>
                            <button class="submit-comment">Enviar</button>
                        `;
                        article.querySelector('.comentarios').appendChild(newCommentForm);

                        // Enviar comentario
                        newCommentForm.querySelector('.submit-comment').addEventListener('click', function () {
                            const content = newCommentForm.querySelector('textarea').value;
                            if (content.trim() === '') return alert('Comentario vacío');

                            const postId = article.dataset.postId;
                            fetch('add_comment.php', {
                                method: 'POST',
                                body: JSON.stringify({ postId, userId: <?php echo $userId; ?>, comentario: content }),
                                headers: { 'Content-Type': 'application/json' }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Comentario agregado con éxito');
                                    fetchComments(postId, article.querySelector('.comentarios-list'));
                                    newCommentForm.remove();
                                } else {
                                    alert('Error al agregar comentario.');
                                }
                            });
                        });
                    } else {
                        // Ocultar el formulario si ya está visible
                        commentForm.remove();
                    }
                });
            });
        });

        function fetchComments(postId, commentList) {
            fetch('get_comments.php', {
                method: 'POST',
                body: JSON.stringify({ postId }),
                headers: { 'Content-Type': 'application/json' }
            })
                .then(response => response.json())
                .then(data => {
                    commentList.innerHTML = '';
                    if (data.success) {
                        data.comentarios.forEach(comment => {
                            const div = document.createElement('div');
                            div.textContent = `${comment.nombre}: ${comment.comentario}`;
                            commentList.appendChild(div);
                        });
                    } else {
                        commentList.textContent = 'No hay comentarios.';
                    }
                });
        }
    </script>
</body>
</html>
