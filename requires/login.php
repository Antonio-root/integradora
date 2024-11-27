<?php
session_start();
require_once 'conexionbd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar en la tabla de usuarios
    $sql_usuario = "SELECT id_usuario, nombre, apellido, password FROM datosusuarios WHERE email = ?";
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->bind_param("s", $email);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();

    if ($result_usuario->num_rows === 1) {
        $usuario = $result_usuario->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $usuario['password'])) {
            // Iniciar sesión como usuario
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['tipo'] = 'usuario';
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['apellido'] = $usuario['apellido'];
            session_regenerate_id();

            header("Location: /integradora/main/inicio.php");
            exit;
        }
    }

    // Verificar en la tabla de vendedores si no se encontró en usuarios
    $sql_vendedor = "SELECT id_vendedor, nombre, apellido, password FROM datosvendedores WHERE email = ?";
    $stmt_vendedor = $conexion->prepare($sql_vendedor);
    $stmt_vendedor->bind_param("s", $email);
    $stmt_vendedor->execute();
    $result_vendedor = $stmt_vendedor->get_result();

    if ($result_vendedor->num_rows === 1) {
        $vendedor = $result_vendedor->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $vendedor['password'])) {
            // Iniciar sesión como vendedor
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['nombre'] = $vendedor['nombre'];
            $_SESSION['tipo'] = 'vendedor';
            $_SESSION['id_usuario'] = $vendedor['id_vendedor'];
            $_SESSION['apellido'] = $vendedor['apellido'];
            session_regenerate_id();

            header("Location: /integradora/main/inicio.php");
            exit;
        }
    }

    // Si el correo o la contraseña son incorrectos
    $error = "Correo electrónico o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="/integradora/estilos/login2.css">
</head>
<body>
<header>
    <nav class="fade-in">
        <div class="nav-links">
            <div class="left-side">
                <a href="/integradora/main/index.html"> <img src="/integradora/imagenes/icono.svg" alt="icon" width="176" height="54"> </a>
                <h1>Together is better</h1>
            </div>
        </div>
    </nav>
</header>

<main>
    <div class="Login">
        <form action="login.php" method="post">
            <h1>Login</h1> 
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form> 

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
