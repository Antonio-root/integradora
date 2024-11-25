<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Contenido</title>
</head>
<body>
    <h1>Publicar Contenido</h1>
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