<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: /integradora/requires/login.php');
    exit;
}

require '../requires/conexionbd.php';

$id_vendedor = $_SESSION['id_vendedor'];

if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $nombredenegocio = $_POST['nombredenegocio'];
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
    if(empty($nombredenegocio) ||  empty($ubicacion) || empty($horarios) || empty($contacto) || empty($tipo) || empty($descripcion)){
        header('Location:registronegocios.php');
        $error = "Por favor llenar todos los campos";
        echo $error;
        exit;

    } else{

        //se insertan los datos  en la base de datos
        $stmt = $pdo->prepare("INSERT INTO datosnegocios(id_vendedor, nombredenegocio, ubicacion, horarios, contacto, tipo, descripcion) VALUES (:id_vendedor,:nombredenegocio, :ubicacion, :horarios, :contacto, :tipo, :descripcion)");
        $stmt->bindParam(':id_vendedor', $id_vendedor);
        $stmt->bindParam(':nombredenegocio', $nombredenegocio);
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
    <style>
        /* Estilo General */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "yatra-one-regular", sans-serif;
    font-size: 18px;
    background: url(Negoci2.jpg) no-repeat center center fixed;
    background-size: cover;
    color: #114607;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

/* Contenedor principal */
main {
    width: 100%;
    max-width: 600px;
    background: rgba(255, 255, 255, 0.8); /* Fondo translúcido */
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0px 8px 32px rgba(0, 0, 0, 0.2);
}

/* Encabezado principal */
header h1 {
    text-align: center;
    color: #04be3c;
    font-size: 1.8rem;
    margin-bottom: 20px;
}

/* Estilo del formulario */
form {
    display: flex;
    flex-direction: column;
    gap: 15px; /* Espaciado entre elementos */
}

form header {
    font-size: 1.5rem;
    color: #269b43;
    text-align: center;
    margin-bottom: 10px;
}

/* Etiquetas y campos */
form label {
    font-size: 1rem;
    color: #114607;
    font-weight: bold;
}

form input,form textarea, form select {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.9);
}

form input::placeholder,
form textarea::placeholder {
    color: #aaa;
}

form textarea {
    height: 80px; /* Altura específica para el campo de texto */
    resize: none; /* Desactiva el redimensionado manual */
}

/* Botón */
form button {
    background-color: #04be3c;
    color: #fff;
    border: none;
    padding: 12px;
    font-size: 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #039b33; /* Más oscuro al pasar el mouse */
}

/* Estilo responsivo */
@media (max-width: 768px) {
    main {
        padding: 15px;
    }

    form button {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    header h1 {
        font-size: 1.5rem;
    }

    form header {
        font-size: 1.2rem;
    }

    form input,
    form textarea {
        font-size: 0.9rem;
    }
}

    </style>
</head>
<body>
    <main>
    <header>
        <h1>Ahora que eres vendedor puedes registrar tu negocio</h1>
    </header>
    <form action="registronegocios.php" method="post">
        <header>Registra tu negocio</header>
        <label for="nombredenegocio">Nombre de tu negocio</label>
        <input type="text" name="nombredenegocio" placeholder="Nombre del negocio">
        <br>
        <label for="ubicacion">Ubicacion de tu negocio</label>
        <select name="ubicacion" id="ubicacion">
                <option value="">Selecciona tu zona</option>
                <option value="Monterrey">Monterrey</option>
                <option value="Apodaca">Apodaca</option>
                <option value="San Nicolas">San Nicolas</option>
                <option value="Escobedo">Escobedo</option>                    
                <option value="Guadalupe">Guadalupe</option>
                <option value="San Pedro">San Pedro</option>
            </select>
        <br>
        <label for="horarios">Horario de tu negocio</label>
        <input type="text" name="horarios" placeholder="Horario del negocio">
        <br>
        <label for="contacto">Contacto de tu negocio</label>
        <input type="text" name="contacto" placeholder="Contacto del negocio">
        <br>
        <label for="tipo">Tipo de negocio</label>
        <select name="tipo" id="tipo">
                <option value="">Categoria</option>            
                <option value="Ferreterias">Ferreteria</option>
                <option value="Papelerias">Papelerias</option>
                <option value="Comidas">Comidas</option>
                <option value="Abarrotes">Abarrotes</option>                    
                <option value="Servicios y mas">Servicios y mas</option>
            </select>
        <br>
        <label for="descrpcion">Descripcion</label>
        <textarea name="descripcion" placeholder="Descripcion del negocio"></textarea>
        <button type="submit">Registrar</button>

    </form>
    </main>
</body>
</html>