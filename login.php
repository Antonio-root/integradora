<?php
session_start();

//credenciales de acceso
$DATABASE_HOST = 'localhost'; //127.0.0.1
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'TsB'; //nombre de la base de datos

// conexion a la base de datos
$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_error()) {
    // error en la conexión
    exit('Fallo en la conexión de MySQL:' . mysqli_connect_error());
}else{
 
    if (empty($_POST['email']) && empty( $_POST['password'])) {
        // si no hay datos muestra error y envía a la página de inicio
        header('Location:index.html');
    }else{
 
      // evitar inyección sql
    if ($stmt = $conexion->prepare('select email, from datosusuarios where email = ?')) {
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
 
}
 
 
?>