<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Contenido</title>
    <style>
        /* Reset de estilos básicos */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Estilo general para el cuerpo */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9; /* Fondo claro */
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* 100% de la altura de la ventana */
    margin: 0;
    flex-direction: column;
}

/* Contenedor principal */
form {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 100%;
    max-width: 500px; /* Limita el ancho máximo */
    text-align: center;
}

/* Título */
h1 {
    font-size: 2rem;
    color: #2d6a4f; /* Verde oscuro */
    margin-bottom: 20px;
}

/* Estilo para las etiquetas */
label {
    font-size: 1rem;
    color: #2d6a4f;
    margin-bottom: 8px;
    display: block;
    text-align: left;
}

/* Estilo para el campo de texto (contenido) */
textarea {
    width: 100%;
    height: 150px;
    padding: 12px;
    margin-bottom: 20px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    color: #333;
    resize: vertical;
    transition: border-color 0.3s;
}

textarea:focus {
    border-color: #2d6a4f; /* Verde al enfocar */
    outline: none;
}

/* Estilo para el input de imagen */
input[type="file"] {
    padding: 8px;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
    margin-bottom: 20px;
    transition: border-color 0.3s;
}

input[type="file"]:focus {
    border-color: #2d6a4f; /* Verde al enfocar */
    outline: none;
}

/* Estilo para el botón */
button[type="submit"] {
    background-color: #2d6a4f; /* Verde principal */
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #1b5d42; /* Verde más oscuro al pasar el mouse */
}

/* Estilo para los enlaces */
a {
    color: #2d6a4f;
    text-decoration: none;
    font-size: 1rem;
    margin-top: 10px;
    display: inline-block;
}

a:hover {
    color: #1b5d42;
}

/* Responsividad */
@media (max-width: 768px) {
    h1 {
        font-size: 1.5rem;
    }

    form {
        padding: 15px;
        max-width: 90%;
    }
}

    </style>
</head>
<body>
    <h1>Publicar Contenido</h1>
    <br>
    <form action="publicar_mensaje.php" method="post" enctype="multipart/form-data">
        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" required></textarea>
        <br><br>
        
        <label for="imagen">Subir Imagen:</label>
        <input type="file" id="imagen" name="imagen">
        <br><br>
        
        <button type="submit">Publicar</button>
    </form>
</body>
</html>
