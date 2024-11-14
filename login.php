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
            header("Location: inicio.php");
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
            header("Location: inicio.php");
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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    

    <style>

        header{
          display: flex;
          text-align: center;
          background-color: rgb(19, 110, 39);
          font-style: italic;
          color: rgb(219, 219, 10);
        }
        @keyframes rgb-border {
        0% {
          border-color: red;
        }
        33% {
          border-color: green;
        }
        66% {
          border-color: blue;
        }
        100% {
          border-color: red;
        }
      }
      .login {
        text-align: center;
        align-content: center;
        align-items: center;
        border: 5px solid;
        animation: rgb-border 3s infinite;
        padding: 0px; 
        border-radius: 10px;
        background-color: rgb(28, 209, 140);
        height: 15cm;    
        margin-inline: 10cm;
        }
    </style>
</head>
<header>
    <a href="index.html">
      <img src="icon.png" alt="icono" width="176" height="44">
    </a>
</header>
<body>
   <form class="login" action="login.php" method="post">
    <H2>Login</H2>
    <div class="form-floating mb-3" >
        <input type="email" class="form-control" id="floatingInput" placeholder="" name="email">
        <label  for="floatingInput"> Email </label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
        <label for="floatingPassword">Password</label>
      </div>
      <br>
        <input type="submit" value="Login">
</form>
</body>
</html>
