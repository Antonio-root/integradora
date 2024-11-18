<?php
session_start();
require_once 'conexionbd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar en la tabla de usuarios
    $sql_usuario = "SELECT id_usuario, nombre, password FROM datosusuarios WHERE email = ?";
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->bind_param("s", $email);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();

    if ($result_usuario->num_rows === 1) {
        $usuario = $result_usuario->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['tipo'] = 'usuario';
            session_regenerate_id();

                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['tipo'] = 'usuario';
            header("Location: /integradora/main/inicio.php");
            exit;
        }
    }

    // Verificar en la tabla de vendedores si no se encontró en usuarios
    $sql_vendedor = "SELECT id_vendedores, nombre, password FROM datosvendedores WHERE email = ?";
    $stmt_vendedor = $conexion->prepare($sql_vendedor);
    $stmt_vendedor->bind_param("s", $email);
    $stmt_vendedor->execute();
    $result_vendedor = $stmt_vendedor->get_result();

    if ($result_vendedor->num_rows === 1) {
        $vendedor = $result_vendedor->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $vendedor['password'])) {
            $_SESSION['id_vendedor'] = $vendedor['id_vendedores'];
            $_SESSION['nombre'] = $vendedor['nombre'];
            $_SESSION['tipo'] = 'vendedor';
            session_regenerate_id();

                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['tipo'] = 'vendedor';
            header("Location: /integradora/main/inicio.php");
            exit;
        }
    }

    // Si el correo o la contraseña son incorrectos
    $error = "Correo electrónico o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion</title>
    <link rel="stylesheet" href="/integradora/estilos/styles4.css">

</head>
<body>
<header>
        <nav class="fade-in">
            <div class="nav-links">
                <div class="left-side">
                <img src="/integradora/imagenes/icon.png" alt="icon" width="176" height="54">
                <h1>Together is better</h1>
                </div>
            </div>
        </nav>
    </header>
    <main>
    <div class="Login">
        <form action="login.php" method="post" ><!--anexamos etiqueta form-->
            <!--Texto o titulo-->
            <h1>Login</h1> 
            <!--etiqueta que guardara el usuario-->
            <label>Email</label>
            <input type="email" name="email">
           <!--etiqueta que guardara la contraseña-->
            <label>Password</label>
            <input type="password" name="password">
           <!--etiqueta para hacer el boton-->
           
            <button>Login</button>

        </form> 
    </div><!--terminamos etiqueta div-->
    </main>
</body>
</html>
