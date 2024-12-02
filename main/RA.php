<?php
require '../requires/conexionbd.php';

if($_SERVER['REQUEST_METHOD'] ===  'POST'){
    $nombre = $_POST['nombre'];
    $pregunta = $_POST['pregunta'];
    $respuesta1 = $_POST['respuesta1'];
    $respuesta2 = $_POST['respuesta2'];
    $respuesta3 = $_POST['respuesta3'];
    $respuesta4 = $_POST['respuesta4'];
    $opcion1 =  $_POST['opcion1'];
 

    //se validan los datos de entrada
    if ( empty($nombre) || empty($pregunta) || empty($respuesta1) || empty($respuesta2)){
        header('Location:index.php');
        echo "Error: Todos los campos son obligatorios";
        
        exit();
    } else  {
        //se inserta el nuevo registro en la tabla formulario
        $stmt = $pdo->prepare("INSERT INTO formulario (nombre, pregunta, respuesta1, respuesta2, respuesta3, respuesta4) VALUES (:nombre, :pregunta, :respuesta1, :respuesta2, :respuesta3, :respuesta4)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':pregunta', $pregunta);
        $stmt->bindParam(':respuesta1',  $respuesta1);
        $stmt->bindParam(':respuesta2', $respuesta2);
        $stmt->bindParam(':respuesta3', $respuesta3);
        $stmt->bindParam(':respuesta4', $respuesta4);

        //se inserta el nuevo registro en la tabla evaluacion
        $stmt2 = $pdo->prepare("INSERT INTO evaluacion (opcion1) VALUES (:opcion1)");
        $stmt2->bindParam(':opcion1', $opcion1);

        if($stmt->execute() && $stmt2->execute()){
            header('Location:index.php');
            echo "Preguntas y evaluacion agregadas con éxito";
        } else {
            echo'Error al guardar los datos';
        }
    }   
}
?>