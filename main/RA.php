<?php
require '../requires/conexionbd.php';  // Asegúrate de que la ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'];
    $nombre = $_POST['nombre'];
    $pregunta = $_POST['pregunta'];
    $respuesta1 = $_POST['respuesta1'];
    $respuesta2 = $_POST['respuesta2'];
    $respuesta3 = $_POST['respuesta3'];
    $respuesta4 = $_POST['respuesta4'];
    $opcion1 = $_POST['opcion1'];

    // Validación del campo número
    if (empty($numero)) {
        echo "Error: El campo 'Número' es obligatorio.";
        exit();
    }

    // Insertar nuevo registro (con mysqli)
    if (isset($_POST['enviar'])) {
        if (empty($nombre) || empty($pregunta) || empty($respuesta1) || empty($respuesta2)) {
            echo "Error: Todos los campos son obligatorios.";
            exit();
        }

        // Preparar la consulta para insertar los datos en la tabla formulario
        $query = "INSERT INTO formulario (numero, nombre, pregunta, respuesta1, respuesta2, respuesta3, respuesta4) 
                  VALUES ('$numero', '$nombre', '$pregunta', '$respuesta1', '$respuesta2', '$respuesta3', '$respuesta4')";
        if (mysqli_query($conexion, $query)) {
            echo "Registro guardado con éxito.";
        } else {
            echo "Error al guardar los datos: " . mysqli_error($conexion);
        }

        // Insertar en la tabla de evaluación
        $query2 = "INSERT INTO evaluacion (opcion1) VALUES ('$opcion1')";
        if (mysqli_query($conexion, $query2)) {
            echo "Evaluación guardada con éxito.";
        } else {
            echo "Error al guardar la evaluación: " . mysqli_error($conexion);
        }
    }

    // Actualizar registro (con mysqli)
    if (isset($_POST['actualizar'])) {
        $query = "UPDATE formulario 
                  SET nombre = '$nombre', pregunta = '$pregunta', respuesta1 = '$respuesta1', respuesta2 = '$respuesta2', 
                      respuesta3 = '$respuesta3', respuesta4 = '$respuesta4' 
                  WHERE numero = '$numero'";

        if (mysqli_query($conexion, $query)) {
            echo "Registro actualizado con éxito.";
        } else {
            echo "Error al actualizar los datos: " . mysqli_error($conexion);
        }
    }

    // Eliminar registro (con mysqli)
    if (isset($_POST['eliminar'])) {
        $query = "DELETE FROM formulario WHERE numero = '$numero'";

        if (mysqli_query($conexion, $query)) {
            echo "Registro eliminado con éxito.";
        } else {
            echo "Error al eliminar los datos: " . mysqli_error($conexion);
        }
    }
}
?>
