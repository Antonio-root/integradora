<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Together is better</title>
    <link href="https://fonts.googleapis.com/css2?family=Londrina+Outline&family=Poppins:wght@400;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="/integradora/estilos/principal.css">
    <link rel="icon" href="/integradora/imagenes/icono.svg">
    <style>
        .negocios-container {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.negocio {
  position: relative;
  width: 300px;
  height: 200px;
  background: linear-gradient(-45deg, #f89b29 0%, #ff0f7b 100%);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.negocio img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 10px;
  transition: all 0.6s ease;
}

.negocio:hover img {
  scale: 1.1;
  opacity: 0.3;
}

.negocio__content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(-45deg);
  width: 90%;
  height: 90%;
  padding: 20px;
  box-sizing: border-box;
  background-color: #fff;
  opacity: 0;
  border-radius: 10px;
  transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
}

.negocio:hover .negocio__content {
  transform: translate(-50%, -50%) rotate(0deg);
  opacity: 1;
}

.negocio__title {
  margin: 0;
  font-size: 18px;
  color: #333;
  font-weight: bold;
  text-align: center;
}

.negocio__description {
  margin: 10px 0;
  font-size: 14px;
  color: #555;
  line-height: 1.4;
  text-align: center;
}

.negocio-button {
  display: block;
  margin: 15px auto 0;
  padding: 8px 16px;
  background-color: #ff0f7b;
  color: #fff;
  text-decoration: none;
  font-size: 14px;
  font-weight: bold;
  border-radius: 5px;
  text-align: center;
  transition: background-color 0.3s ease;
}

.negocio-button:hover {
  background-color: #f89b29;
}

    </style>
</head>
<body>
    <header>
        <nav class="fade-in">
            <div class="nav-links">
                <div class="left-side">
                <img src="/integradora//imagenes/icono.svg" alt="icon" width="200" height="54">
                <h1>Together is better</h1>
                </div>
                <ul>
                    <li><a href="inicio.php">Inicio</a></li>
                    <li><a href="equipo.html">Conocenos</a></li>
                    <li><a href="comunidad.php">Comunidad</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <section id="hola" class="animate__animated animate__fadeIn">
        <h1>Bienvenido a Together is better</h1>
        <p>Hecho para la comunidad!</p>
    <div class="parent-container">    
        <div class="parent">
        <div class="card">
        <div class="content-box">
          <span class="card-title">Usuario</span>
          <p class="card-content">
            Encuentra negocios cerca de ti
        </p>
            <a class="see-more" href="registro.html">Registrame</a>
            <br>
            <a class="see-more" href="/integradora/requires/login.php">Inicia sesión</a>
        </div>
        </div>
        </div>
        <div class="parent">
            <div class="card">
                <div class="content-box">
                    <span class="card-title">Vendedor</span>
                        <p class="card-content">
                        Quieres darle mas visibilidad a tu negocio?
                        </p>
                    <a class="see-more" href="vendedores.html">Registrame</a>
                    <br>
                    <a href="/integradora/requires/login.php" class="see-more">Iniciar sesion</a>
                </div>
            </div>
        </div>
    </div>
    </section>
    
    <section id="about-us" class="fade-in">
    <div class="about-card-container">
        <div class="about-card">
            <div class="front-content">
                <p>Acerca de</p>
            </div>
            <div class="content">
                <div class="heading">Together is better</div>
                <p>Together is better es una plataforma hecha para la comunidad, donde puedes encontrar negocios emergentes cerca de ti. Esta plataforma está orientada a hacer crecer la economía de tu localidad promoviendo negocios que están empezando.</p>
            </div>
        </div>
    </div>
    
</section>


    <section id="comunidad" class="fade-in">
        <h1>Algunas categorias</h1>
        <br>
        <div class="container">
            <div class="palette">
              <div class="color" style="background-image: url(/integradora/imagenes/mecanico.jpg);"><span>Ferreterias</span></div>
              <div class="color" style="background-image: url(/integradora/imagenes/carrusel9.jpeg);"><span>Papelerias</span></div>
              <div class="color" style="background-image: url(/integradora/imagenes/hamburguesa.jpg);"><span>Comidas</span></div>
              <div class="color" style="background-image: url(/integradora/imagenes/carrusel6.jpeg);"><span>Abarrotes</span></div>
              <div class="color" style="background-image: url(/integradora/imagenes/carrusel8.jpeg);"><span>Servicios y mas</span></div>
            </div>
            <div id="stats">
              <span>Explora la comunidad y encuentra negocios emegentes cerca de ti</span>
              
            </div>
          </div>
    </section>
    
    <section id="negocios" class="fade-in">
        <h2>Explora los negocios cerca de ti</h2>
        <p>Aquí se muestran los negocios registrados:</p>
        <div class="negocios-container">
            <?php
            // Conexión a la base de datos
            require_once '../requires/conexionbd.php';
    
            // Consulta para obtener al menos 3 negocios
            $sql = "SELECT id_negocio, nombredenegocio, imagen, descripcion FROM datosnegocios LIMIT 3";
            $result = $conexion->query($sql);
    
            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <!-- Cada negocio -->
                    <div class="negocio">
                        <img src="<?php echo $row['imagen']; ?>" alt="Imagen de <?php echo $row['nombredenegocio']; ?>" class="negocio-img">
                        <div class="negocio__content">
                            <h3 class="negocio__title"><?php echo $row['nombredenegocio']; ?></h3>
                            <p class="negocio__description"><?php echo $row['descripcion']; ?></p>
                            <a href="pagina_negocio.php?id=<?php echo $row['id_negocio']; ?>" class="negocio-button">Ver más</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No hay negocios registrados por el momento.</p>";
            }
            ?>
        </div>
    </section>
    

    
    
    <section id="contact" class="fade-in">
        <h2>Contacto</h2>
        <form action="RA.php" class="form" method="post">
            <header>Formulario</header>
            <label for="nombre">¿Cuál es tu nombre?</label>
            <input type="text" name="nombre" id="nombre" placeholder="Tu nombre">
            
            <label for="pregunta">Pregunta</label>
            <input type="text" name="pregunta" id="pregunta" placeholder="Escribe tu pregunta">

            <label for="respuestas">Respuestas</label>
            <input type="text" name="respuesta1" placeholder="1. respuesta">
            <input type="text" name="respuesta2" placeholder="2. respuesta">
            <input type="text" name="respuesta3" placeholder="3. respuesta">
            <input type="text" name="respuesta4" placeholder="4. respuesta">
        
            <fieldset class="form2">
                <legend>¿Qué tan fácil de usar es el menú principal?</legend>
                <input type="radio" name="opcion1" id="muy-facil" value="Muy Fácil" checked>
                <label for="muy-facil">Muy fácil</label>
                <br>
                <input type="radio" name="opcion1" id="facil" value="Fácil">
                <label for="facil">Fácil</label>
                <br>
                <input type="radio" name="opcion1" id="poco-facil" value="Poco fácil">
                <label for="poco-facil">Poco fácil</label>
            </fieldset>

            <input type="submit" name="enviar" id="enviar" value="Enviar">
        </form>

    </section>

    <footer class="animate__animated animate__fadeIn">
        <p>Copyright © Together is better 2024</p>
    </footer>
</body>
</html>