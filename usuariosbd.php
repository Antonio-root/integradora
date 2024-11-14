<?php
require("conexionbd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $emailsecundario = $_POST['emailsecundario'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO("mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME", $DATABASE_USER, $DATABASE_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("No se pudo conectar a la base de datos: " . $e->getMessage());
    }

    // Validar datos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($emailsecundario) || empty($telefono) || empty($password)) {
        $error = 'Todos los campos son requeridos.';
        echo $error;
        header('Location: index.html');
        exit();
    } else {
        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar datos en la base de datos
        $stmt = $pdo->prepare("INSERT INTO datosusuarios (nombre, apellido, email, emailsecundario, telefono, password) VALUES (:nombre, :apellido, :email, :emailsecundario, :telefono, :password)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':emailsecundario', $emailsecundario);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            header('Location: inicio.php');
            $success = 'Datos guardados exitosamente.';
            echo $success;
        } else {
            $error = 'Hubo un problema al guardar los datos.';
            echo $error;
        }
    }
}
?>
