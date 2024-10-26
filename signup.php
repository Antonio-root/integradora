<?php
session_start();
// Credenciales de acceso
$DATABASE_HOST = 'localhost'; //127.0.0.1
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'TsB'; // Nombre de la base de datos

// Conexión a la base de datos
$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_error()) {
    // Error en la conexión
    exit('Fallo en la conexión de MySQL:' . mysqli_connect_error());
}
echo 'Conexión exitosa';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
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
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($emailsecundario) || empty($telefono) || empty($password)) {
        $error = 'Todos los campos son requeridos.';
        echo $error;
        header('Location: index.html');
        exit();
    } else {
        // Insertar datos en la base de datos
        $stmt = $pdo->prepare("INSERT INTO datosusuarios (nombre, apellidos, email, emailsecundario, telefono, password) VALUES (:nombre, :apellidos, :email, :emailsecundario, :telefono, :password)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':emailsecundario', $emailsecundario);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $success = 'Datos guardados exitosamente.';
            echo $success;
        } else {
            $error = 'Hubo un problema al guardar los datos.';
            echo $error;
        }
    }
}






 /* else{
 
    if (empty($_POST['nombre']) && empty( $_POST['password'])) {
        // si no hay datos muestra error y envía a la página de inicio
        header('Location:registro.html');
    }else{
 
      // evitar inyección sql
    if ($stmt = $conexion->prepare('select idUsuario, password, tipoUsuario from usuarios where username = ?')) {
        // parámetros de enlace de la cadena s
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password, $tipo);
            $stmt->fetch();
 
            if($_POST['password'] === $password ){
 
                session_regenerate_id();
 
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['id'] = $id;
       
                header('Location: inicio.php');
            }else{
 
                // username incorrecto
                echo "<script> alert('La contraseña es incorrecta!!');
                         window.location= 'index.php'
                     </script>";
           
                //  header('Location: .index.php');    
            }
            }
        else {
            // username incorrecto
            header('Location: index.php');
        }
        $stmt->close();
 
    }
    }
 
    } */

?>