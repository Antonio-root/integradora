
<?php

session_start();
if(isset($_session['loggedin'])){
    header('Location: inicio.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    

    <style>

        header{
          display: flex;
          text-align: center;
          background-color: rgb(19, 110, 39);
          font-style: italic;
          color: rgb(219, 219, 10);
        }
        @keyframes rgb-border {
        0% {
          border-color: red;
        }
        33% {
          border-color: green;
        }
        66% {
          border-color: blue;
        }
        100% {
          border-color: red;
        }
      }
      .login {
        text-align: center;
        align-content: center;
        align-items: center;
        border: 5px solid;
        animation: rgb-border 3s infinite;
        padding: 0px; 
        border-radius: 10px;
        background-color: rgb(28, 209, 140);
        height: 15cm;    
        margin-inline: 10cm;
        }
    </style>
</head>
<header>
    <a href="index.html">
      <img src="icon.png" alt="icono" width="176" height="44">
    </a>
</header>
<body>
   <form class="login" action="loginverify.php" method="post">
    <H2>Inicia sesion</H2>
    <div class="form-floating mb-3" >
        <input type="email" class="form-control" id="floatingInput" placeholder="" name="email">
        <label  for="floatingInput"> Email </label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
        <label for="floatingPassword">Password</label>
      </div>
      <br>
        <input type="submit" value="Login">
</form>
</body>
</html>