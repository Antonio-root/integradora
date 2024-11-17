<?php


require '/requires/conexionbd.php';

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
            <form action="/requires/vendedoresbd.php" method="post">
                <header>Vendedores</header>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre">

                <label for="apellido">Apellidos</label>
                <input type="text" name="apellido" id="apellido">

                <label for="telefono">Telefono</label>
                <input type="number" name="telefono" id="telefono">

                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                <label for="emailderepuesto">Email secundario</label>
                <input type="email" name="emailderepuesto" id="emailrespuesto">
                <br>
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password">
                <br>

                <button type="submit">Enviar</button>

            </form>
        </section>
    </main>
</body>
</html>