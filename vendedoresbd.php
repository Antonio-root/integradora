<?php
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
        die("No se pudo conectar a la base de datos");
    }

    // Se validan los datos de entrada
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($email) || empty($emailderepuesto) || empty($password)) {
        $error = "Por favor, complete todos los campos";
        echo $error;
        header('Location:vendedores.php');
        exit;
    } else {
        // Hashear la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Se insertan los datos a la base de datos
        $stmt = $pdo->prepare("INSERT INTO datosvendedores (nombre, apellido, telefono, email, emailderepuesto, password) VALUES (:nombre, :apellido, :telefono, :email, :emailderepuesto, :password)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':emailderepuesto', $emailderepuesto);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['tipo'] = 'vendedor';
            $_SESSION['nombre'] = $nombre;
            header('Location: registronegocios.php');
            echo 'Los datos fueron guardados correctamente';
        } else {
            echo 'Error al guardar los datos';
        }
    }
}
?>
