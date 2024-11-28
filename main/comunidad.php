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
    <style>
    /* Estilos del cuerpo y la pantalla */
body {
    background-color: #f4f4f9;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start; /* Asegura que no esté centrado verticalmente */
    min-height: 100vh;
    padding: 20px;
}

header {
    background-color: #103310; /* Verde militar intermedio */
    padding: 15px 20px;
    display: flex;
    align-items: center; /* Alinea los elementos verticalmente en el centro */
    justify-content: flex-start; /* Alinea todo a la izquierda */
    border-bottom: 1px solid #4f4f4d; /* Línea de separación sutil */
    top: 0;
    left: 0;
    width: 100%; /* Ocupa todo el ancho */
    z-index: 1000; /* Por encima de la barra lateral */
    height: 70px;
    border-radius: 10px;
}

header h1 {
    font-size: 2.5rem;
    color: #eeeeee;
    flex-grow: 1; /* Esto hace que el título se estire y se mantenga centrado */
    text-align: center;
}

/* Estilo de la imagen en el header */
header img {
    margin-right: 20px; /* Añadido para separar la imagen del texto */
}

/* Sección Left */
aside.left {
    width: 25%; /* Establece el ancho de la columna izquierda */
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height: fit-content; /* Asegura que no se estire demasiado */
    position: sticky; /* Si lo deseas que se quede pegado al hacer scroll */
    top: 20px; /* Mantén la sección visible durante el scroll */
}

.news-item {
    background-color: #f9f9f9;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Sección Central - Publicaciones */
.publicaciones {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Artículo de publicación */
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

/* Reacciones */
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

/* Botón de comentarios */
.comentarios {
    margin-top: 10px;
}

.comentarios button {
    background-color: #103310;
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

/* Sección Right (perfil) */
aside.right {
    width: 20%;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
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
    color: black;
}

button {
    background-color: #29f833;
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

 /* Estilo para la animación de los comentarios */
 @keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.comentarios-list {
    display: none;
    margin-top: 20px;
    padding: 15px;
    border-top: 1px solid #ddd;
    background-color: #f8f9fa;
    border-radius: 8px;
    animation: fadeInUp 0.5s ease-out forwards;
}

.comentarios-list.show {
    display: block;
}

.form-comentario {
    display: none;
    margin-top: 15px;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.form-comentario textarea {
    width: 100%;
    min-height: 80px;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    resize: vertical;
}

.form-comentario .submit-comment {
    background-color: #6c63ff;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.form-comentario .submit-comment:hover {
    background-color: #5851db;
}

.form-comentario.show {
    display: block;
}

/* Estilos para los botones de reacción */
.reaction-button {
    margin-right: 10px;
}

.reaction-button.selected {
    background-color: #4CAF50; /* Color verde para la reacción seleccionada */
    color: white;
}

.reaction-button:hover {
    background-color: #45a049; /* Hover verde */
}

/* Estilos para cada comentario */
.comentarios-list .comentario {
    background-color: #f9f9f9;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Adaptación para pantallas pequeñas */
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

    aside.left {
        width: 100%;
        margin-bottom: 20px;
    }

    aside.right {
        width: 100%;
        margin-top: 20px;
    }
}
</style>
</head>
<body>
    <header>
    <a href="index.php"> <img src="/integradora/imagenes/icono.svg" alt="icon" width="54" height="150px"></a>

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
        <?php 
        // Si el usuario es vendedor, muestra la imagen del vendedor
        if ($tipo == 'vendedor' && isset($_SESSION['id_vendedor'])):
            $id_vendedor = $_SESSION['id_vendedor'];
            // Recuperar imagen del vendedor desde la base de datos
            $sql_vendedor = "SELECT imagen FROM datosvendedores WHERE id_vendedor = ?";
            $stmt_vendedor = $conexion->prepare($sql_vendedor);
            $stmt_vendedor->bind_param("i", $id_vendedor);
            $stmt_vendedor->execute();
            $result_vendedor = $stmt_vendedor->get_result();
            $vendedor = $result_vendedor->fetch_assoc();
            $imagen_vendedor = $vendedor['imagen'] ? $vendedor['imagen'] : '/integradora/imagenes/vendedor_perfil.jpg';
            $stmt_vendedor->close();
        ?>
            <img src="<?php echo htmlspecialchars($imagen_vendedor); ?>" alt="Foto de perfil vendedor">
        <?php elseif ($tipo == 'usuario' && isset($_SESSION['id_usuario'])): ?>
            <?php
            // Si es usuario, recuperar imagen desde la tabla de datosusuarios
            $id_usuario = $_SESSION['id_usuario'];
            $sql_usuario = "SELECT imagen FROM datosusuarios WHERE id_usuario = ?";
            $stmt_usuario = $conexion->prepare($sql_usuario);
            $stmt_usuario->bind_param("i", $id_usuario);
            $stmt_usuario->execute();
            $result_usuario = $stmt_usuario->get_result();
            $usuario = $result_usuario->fetch_assoc();
            $imagen_usuario = $usuario['imagen'] ? $usuario['imagen'] : '/integradora/imagenes/usuario_perfil.jpg';
            $stmt_usuario->close();
            ?>
            <img src="<?php echo htmlspecialchars($imagen_usuario); ?>" alt="Foto de perfil usuario">
        <?php endif; ?>

        <!-- Mostrar nombre completo -->
        <p><?php echo htmlspecialchars($_SESSION['nombre'] . " " . $_SESSION['apellido']); ?></p>

        <!-- Botones de navegación -->
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
