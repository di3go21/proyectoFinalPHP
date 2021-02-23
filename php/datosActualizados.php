<?php

include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
if(!isset($_GET['ok'])){
    header('location: ./areaPersonal.php');
    exit;
}
$con=getConexion();
actualizaVariablesEnSession($con, $_SESSION["email_usuario_autenticado"]);

?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Datos Actualizados</title>
  </head>

<body>
  
<?php include "./includes/menu.php" ?>
<br><br>
<div class="container">
<h2>Datos actualizados correctamente</h2>
<br><br>
<p><a class="btn btn-lg btn-success" href="./areaPersonal.php">Volver al área Personal</a></p>
    
    
</div>

</body>
</html>