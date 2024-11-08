
<?php

session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: loginuser.php');
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
            <li class="elemento"><a href="comida.php">Comidas</a></li>
            <li class="elemento"><a href="mercerias.php">Papeleria y merceria</a></li>
            <li class="elemento"><a href="ferreterias">Ferreterias</a></li>
            <li class="elemento"><a href="otroservicio.php">Servicios</a></li>
            <li class="elemento"><a href="acercade.php">Acerca de</a></li>
            </ul>
        </nav>
    </div>
    <main>
    <div class="main">
        <p>aqui se pondran los diferentes negocios cerca de ti</p>
    </div>
    <section>
        <a class="cerrar" href="cerrarsesion.php">Cerrar Sesion</a>
    </section>
    </main> 
</body>
</html>
