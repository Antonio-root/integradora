<?php

//confirmar session
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: index.php');
    exit;
}


require 'conexionbd.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendedores</title>
</head>
<body>
    <main>
        <header>
            <h1>BIENVENIDO A TOGETHER IS BETTER</h1>
            <h2>Forma parte del crecimiento</h2>  
        </header>
        <section>
            <p>Registrate en esta plataforma para que puedas ser parte del crecimiento en tu comunidad</p>
            <br>
            <form action="vendedoresbd.php" method="post">
                <header>Vendedores</header>
                <label for="Nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre">

                <label for="Apellido">Apellidos</label>
                <input type="text" name="apellidos" id="apellidos">

                <label for="Telefono">Telefono</label>
                <input type="number" name="telefono" id="telefono">

                <label for="Email">Email</label>
                <input type="email" name="email" id="email">

                <label for="emailderepuesto">Email secundario</label>
                <input type="email" name="emailderepuesto" id="emailrespuesto">
                <br>

                <button type="submit">Enviar</button>

            </form>
        </section>
    </main>
</body>
</html>