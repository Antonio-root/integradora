// Función para cargar publicaciones
function cargarPublicaciones() {
    fetch("cargar_publicaciones.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("publicaciones").innerHTML = data;
        });
}

// Función para publicar un mensaje
function publicarMensaje() {
    const formData = new FormData(document.getElementById("form-publicacion"));

    fetch("publicar_mensaje.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        cargarPublicaciones();
    });
}

// Función para agregar una reacción
function agregarReaccion(idPublicacion, tipoReaccion) {
    fetch("agregar_reaccion.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id_publicacion=${idPublicacion}&tipo_reaccion=${tipoReaccion}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        cargarPublicaciones();
    });
}

// Función para agregar un comentario
function agregarComentario(idPublicacion) {
    const comentario = document.getElementById(`comentario-${idPublicacion}`).value;

    fetch("agregar_comentario.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id_publicacion=${idPublicacion}&comentario=${encodeURIComponent(comentario)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        cargarPublicaciones();
    });
}

// Cargar publicaciones al cargar la página
document.addEventListener("DOMContentLoaded", cargarPublicaciones);
