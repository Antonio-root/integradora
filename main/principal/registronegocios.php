<?php


require '/requires/conexionbd.php';

if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $nombredenegocios = $_POST['nombredenegocios'];
    $ubicacion = $_POST['ubicacion'];
    $horarios  = $_POST['horarios'];
    $contacto = $_POST['contacto'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];

    try {
        $pdo = new PDO("mysql:host=$DATABASE_HOST;dbname=$DATABASE_NAME", $DATABASE_USER,  $DATABASE_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e){
        die ("No se pudo conectar con la base de datos" . $e->getMessage());
    }

    //se validan los datos de entrada
    if(empty($nombredenegocios) ||  empty($ubicacion) || empty($horarios) || empty($contacto) || empty($tipo) || empty($descripcion)){
        header('Location:registronegocios.php');
        $error = "Por favor llenar todos los campos";
        echo $error;
        exit;

    } else{

        //se insertan los datos  en la base de datos
        $stmt = $pdo->prepare("INSERT INTO datosnegocios(nombredenegocios, ubicacion, horarios, contacto, tipo, descripcion) VALUES (:nombredenegocios, :ubicacion, :horarios, :contacto, :tipo, :descripcion)");
        $stmt->bindParam(':nombredenegocios', $nombredenegocios);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':horarios', $horarios);
        $stmt->bindParam(':contacto', $contacto);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':descripcion', $descripcion);
        
        if ($stmt->execute()){
            header('Location:editarnegocio.php');

        } else{
            echo 'Error al guardar los datos';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Negocios</title>
</head>
<body>
    <main>
    <header>
        <h1>Aqui va el registro de negocios</h1>
    </header>
    <form action="registronegocios.php" method="post">
        <header>Registra tu negocio</header>
        <label for="nombredenegocios">Nombre de tu negocio</label>
        <input type="text" name="nombredenegocios" placeholder="Nombre del negocio">
        <br>
        <label for="ubicacion">Ubicacion de tu negocio</label>
        <input type="text" name="ubicacion" placeholder="Ubicacion del negocio">
        <br>
        <label for="horarios">Horario de tu negocio</label>
        <input type="text" name="horarios" placeholder="Horario del negocio">
        <br>
        <label for="contacto">Contacto de tu negocio</label>
        <input type="text" name="contacto" placeholder="Contacto del negocio">
        <br>
        <label for="tipo">Tipo de negocio</label>
        <input type="text" name="tipo" placeholder="Tipo de negocio">
        <br>
        <label for="descrpcion">Descripcion</label>
        <textarea name="descripcion" placeholder="Descripcion del negocio"></textarea>
        <button type="submit">Registrar</button>

    </form>
    </main>
</body>
</html>