
<?php

session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <style>
        .nav1{
            font-family: monospace;
            text-align: space-around;
            background-color: aqua;
            color: red;
            justify-content: space-around;
            height: 40px;
        }
        .barra{
            justify-content: space-around;
            display: flex;   
        }
        .elemento{
            background-color: aqua;
            text-align: center;
            margin: 0px;
            height: 20px;
            padding: 10px;
        }
        li:hover{
            transition: 350ms;
            background-color: blueviolet;
        }
        .cerrar{
            padding: 1rem 2rem;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        .cerrar :hover{
            transform: rotate(20cm);
            transition: 350ms;
            background-color: aqua;

        }
        .section1{
            width: 20%;
        }
    </style>
</head>
<body>
    <header>
        <h1>pagina de inicio yeaa shiit</h1>
    </header>
    <div class="nav1">
        <nav>
            <ul class="barra">
            <li class="elemento"><a href="index.html">Inicio</a></li>
            <li class="elemento">Pendejadas</li>
            <li class="elemento">Chingaderas</li>
            <li class="elemento">Mas cosas</li>
            <li class="elemento">Acerca de</li>
            </ul>
        </nav>
    </div>
    <main>
    <p>aqui es la pagina bien verga de inicio</p>
    <p>armando no puede caminar</p>
    <aside class="section1">
    <form action="seleccion.php" method="post">
    <fieldset>
        <legend>Armando puede caminar?</legend>
        <input type="radio" name="eleccion" id="amigo" value="amigo">
        <label for="amigo">Si ya se curo el pendejo</label>
        <br>
        <input type="radio" name="eleccion" id="internet">
        <label for="internet">No aun esta cojo el pendejo</label>
        <br>
        <input type="radio" name="eleccion" id="pasando" value="pasando">
        <label for="pasando">Le dicen el chueco por estar bien torcido</label>
    </fieldset>
    <input type="submit" value="SEND">
    </form>
    </aside>
    <section>
        <a class="cerrar" href="cerrarsesion.php">Cerrar Sesion</a>
    </section>
    </main> 
</body>
</html>
