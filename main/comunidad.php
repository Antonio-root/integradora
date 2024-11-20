<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: /integradora/requires/login.php');
    exit;
}

$tipo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'usuario';

// Definir el ID del usuario desde la sesión
$userId = $_SESSION['id_usuario']; // Asegúrate de que este es el nombre correcto de la variable de sesión para el ID del usuario

// Conectar a la base de datos
require_once '../requires/conexionbd.php';

// Consulta para obtener todas las publicaciones, sin filtrar por usuario o vendedor
$sql = "SELECT p.id_publicacion, p.contenido, p.imagen, d.nombre, d.apellido, p.id_vendedor,
            (SELECT COUNT(*) FROM reacciones r WHERE r.id_publicacion = p.id_publicacion) AS total_reacciones,
            (SELECT COUNT(*) FROM comentarios c WHERE c.id_publicacion = p.id_publicacion) AS total_comentarios
        FROM publicaciones p
        LEFT JOIN datosvendedores d ON p.id_vendedor = d.id_vendedores
        LEFT JOIN datosusuarios u ON p.id_usuario = u.id_usuario
        ORDER BY p.fecha_publicacion DESC";  // Muestra todas las publicaciones, sin filtrar por tipo
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
    <link rel="stylesheet" href="/integradora/estilos/comunidad.css">
</head>
<body>
    <header>
        <h1>Comunidad</h1>
    </header>

    <main>
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
                        <button class="comment-button">💬 Agregar comentario</button>
                        <button class="ver-comment" data-post-id="<?php echo $row['id_publicacion']; ?>">Ver comentarios</button>
                        <div class="comentarios-list"></div> <!-- Contenedor para comentarios cargados -->
                        <div class="form-comentario" style="display: none;"></div> <!-- Formulario de comentarios oculto por defecto -->
                    </div>
                </article>
            <?php endwhile; ?>
        </section>

        <!-- Perfil del usuario -->
        <aside class="right">
            <div class="perfil">
                <?php if ($tipo == 'vendedor'): ?>
                    <!-- Mostrar datos del vendedor -->
                    <img src="/integradora/imagenes/vendedor_perfil.jpg" alt="Foto de perfil">
                    <p><?php echo htmlspecialchars($_SESSION['nombre'] . " " . $_SESSION['apellido']); ?></p>
                <?php else: ?>
                    <!-- Mostrar datos del usuario -->
                    <img src="/integradora/imagenes/usuario_perfil.jpg" alt="Foto de perfil">
                    <p><?php echo htmlspecialchars($_SESSION['nombre'] . " " . $_SESSION['apellido']); ?></p>
                <?php endif; ?>
                <button><a href="perfil.php">Mi perfil</a></button>
                <button><a href="publicacion.html">Hacer una publicacion</a></button>
                <button><a href="inicio.php">Inicio</a></button>
                <button><a href="/integradora/requires/cerrarsesion.php">Cerrar sesión</a></button>
            </div>
        </aside>
                
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Funcionalidad para manejar reacciones
            document.querySelectorAll('.reaction-button').forEach((button) => {
                button.addEventListener('click', function() {
                    const reaction = this.getAttribute('data-reaction');
                    const postId = this.closest('article').getAttribute('data-post-id');
                    const userId = <?php echo $userId; ?>;

                    // Desmarcar otras reacciones si ya están seleccionadas
                    document.querySelectorAll('.reaction-button').forEach((btn) => {
                        btn.classList.remove('selected');
                    });

                    // Marcar la reacción seleccionada
                    this.classList.add('selected');

                    // Asegurarse de que el usuario no acumule reacciones
                    fetch('check_reaction.php', {
                        method: 'POST',
                        body: JSON.stringify({ postId, userId }),
                        headers: { 'Content-Type': 'application/json' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.reacted) {
                            // Si ya ha reaccionado, actualizar la reacción
                            fetch('update_reaction.php', {
                                method: 'POST',
                                body: JSON.stringify({ postId, userId, reaction }),
                                headers: { 'Content-Type': 'application/json' }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Reacción actualizada:', data);
                                updateReactionCount(postId);
                            });
                        } else {
                            // Si no ha reaccionado, agregar nueva reacción
                            fetch('add_reaction.php', {
                                method: 'POST',
                                body: JSON.stringify({ postId, userId, reaction }),
                                headers: { 'Content-Type': 'application/json' }
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Reacción agregada:', data);
                                updateReactionCount(postId);
                            });
                        }
                    })
                    .catch(err => console.error('Error en la solicitud de reacción:', err));
                });
            });

            // Función para actualizar el contador de reacciones
            function updateReactionCount(postId) {
                fetch('get_reaction_count.php', {
                    method: 'POST',
                    body: JSON.stringify({ postId }),
                    headers: { 'Content-Type': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    const reactionCountElement = document.querySelector(`article[data-post-id="${postId}"] .total_reacciones`);
                    reactionCountElement.textContent = `${data.total_reacciones} Reacciones`;
                })
                .catch(err => console.error('Error al obtener el conteo de reacciones:', err));
            }

            // Mostrar el formulario para agregar comentario
            document.querySelectorAll('.comment-button').forEach((button) => {
                button.addEventListener('click', function() {
                    const postId = this.closest('article').getAttribute('data-post-id');
                    const formContainer = this.closest('article').querySelector('.form-comentario');

                    // Mostrar el formulario
                    formContainer.style.display = 'block';

                    // Agregar el evento para enviar el comentario
                    formContainer.innerHTML = `
                        <textarea id="comentario-texto" placeholder="Escribe tu comentario..."></textarea>
                        <button class="submit-comment">Enviar</button>
                    `;

                    const submitButton = formContainer.querySelector('.submit-comment');
                    submitButton.addEventListener('click', function() {
                        const comentarioTexto = formContainer.querySelector('#comentario-texto').value;
                        const userId = <?php echo $userId; ?>;  // Usar la variable de sesión de PHP para el ID de usuario

                        if (comentarioTexto.trim() !== '') {
                            fetch('add_comment.php', {
                                method: 'POST',
                                body: JSON.stringify({ postId, userId, comentario: comentarioTexto }),
                                headers: { 'Content-Type': 'application/json' }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Comentario agregado con éxito');
                                    formContainer.style.display = 'none';  // Ocultar el formulario después de agregar el comentario
                                    // También puedes actualizar la lista de comentarios si es necesario
                                } else {
                                    alert('Hubo un error al agregar el comentario');
                                }
                            })
                            .catch(err => console.error('Error al agregar comentario:', err));
                        } else {
                            alert('Por favor, escribe un comentario.');
                        }
                    });
                });
            });

            // Mostrar comentarios al hacer clic en "Ver comentarios"
            document.querySelectorAll('.ver-comment').forEach((button) => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');

                    // Hacer una solicitud para obtener los comentarios
                    fetch('get_comments.php', {
                        method: 'POST',
                        body: JSON.stringify({ postId }),
                        headers: { 'Content-Type': 'application/json' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const commentList = this.closest('article').querySelector('.comentarios-list');
                        commentList.innerHTML = ''; // Limpiar comentarios existentes

                        if (data.success && data.comentarios.length > 0) {
                            data.comentarios.forEach(comment => {
                                const commentElement = document.createElement('div');
                                commentElement.classList.add('comentario-item');
                                commentElement.innerHTML = `<strong>${comment.nombre} ${comment.apellido}</strong>: ${comment.comentario}`;
                                commentList.appendChild(commentElement);
                            });
                        } else {
                            const messageElement = document.createElement('p');
                            messageElement.textContent = data.message || 'No hay comentarios aún.';
                            commentList.appendChild(messageElement);
                        }
                    })
                    .catch(err => console.error('Error al cargar comentarios:', err));
                });
            });
        });
    </script>

</body>
</html>
