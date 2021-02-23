<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";


$con=getConexion();

?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Area de Administración</title>
  </head>

<body>
  
<?php include "./includes/menu.php" ?>
<br><br>
<div class="container">
<h1>¡Bienvenido <?php echo $_SESSION['nombre'] ?>!</h1>
<br>

<h4>Que deseas consultar?</h4>
<br>




<a class="btn btn-outline-warning" href="./admusuarios.php">gestionar usuarios</a> 
<a class="btn btn-outline-success" href="./admproductos.php">gestionar productos</a> 
<a class="btn btn-outline-info" href="./admcategorias.php">gestionar categorias</a>
<?php if($_SESSION['puedeRealizarInformes']=="SI")
    echo "<a class='btn btn-outline-danger' href='./adminformes.php'>Ver Informes</a>" ;
?>
    

</div>

        <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

   
</body>

</html>