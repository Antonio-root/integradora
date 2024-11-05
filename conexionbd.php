<?php
//credenciales de acceso
$DATABASE_HOST = 'localhost'; //127.0.0.1
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'tsb'; //nombre de la base de datos
// conexion a la base de datos
$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_error()) {
    // error en la conexión
    exit('Fallo en la conexión de MySQL:' . mysqli_connect_error());
}

?>