<?php
session_start(); // Asegúrate de iniciar la sesión al principio
require 'conexionbd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $emailderepuesto = $_POST['emailderepuesto'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO("mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME", $DATABASE_USER, $DATABASE_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("No se pudo conectar a la base de datos: " . $e->getMessage());
    }

    // Se validan los datos de entrada
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($email) || empty($emailderepuesto) || empty($password)) {
        echo "Por favor, complete todos los campos.";
        header('Location:/integradora/main/vendedores.php');
        exit;
    } else {
        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar los datos en la base de datos
        $stmt = $pdo->prepare("INSERT INTO datosvendedores (nombre, apellido, telefono, email, emailderepuesto, password) 
                               VALUES (:nombre, :apellido, :telefono, :email, :emailderepuesto, :password)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':emailderepuesto', $emailderepuesto);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            // Obtener el ID del vendedor recién creado
            $id_vendedor = $pdo->lastInsertId();

            // Guardar los datos en la sesión
            $_SESSION['loggedin'] = true; // Indica que el usuario está logueado
            $_SESSION['id_vendedor'] = $id_vendedor; // ID del vendedor
            $_SESSION['tipo'] = 'vendedor'; // Tipo de usuario
            $_SESSION['nombre'] = $nombre; // Nombre del vendedor
            $_SESSION['apellido'] = $apellido;

            header('Location: /integradora/main/registronegocios.php');
            exit;
        } else {
            echo "Error al guardar los datos.";
        }
    }
}
?>
