<?php

include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$con = getConexion();
$id = $_GET['eliminar'];
$emailUsuario = dameCampoUsuario($con, "email", $id);
$usuario = dameUsuario($con, $emailUsuario);

if (empty($usuario)) {
    header("location: ./admusuarios.php");
    exit;
}
if (isset($_GET['confirmar']) && $_GET['confirmar'] == "si") {
    if (insertaBaja($con, $emailUsuario)) {
        vaciarCarrito($con, $emailUsuario);
        if (borraUsuario($con, $emailUsuario)) {
            header("location: ./admusuarios.php");
            exit;
        }
    }
}

?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Inicio App</title>
  </head>

<body>
  
<?php include "./includes/menu.php" ?><br><br>

<div class="container">

<h3>¿Seguro que quieres eliminar este usuario?</h3><br><br>
    <?php 
    echo "<ul>";

    foreach ($usuario as $key => $value) {
        echo "<li><b>$key: </b>$value</li>";
    }
    echo "</ul>";

    echo "<a class='btn btn-danger btn-lg' href='./admconfirmareliminar.php?eliminar=$id&confirmar=si'>SI</a>";
    ?>
    <a  class='btn btn-secondary btn-lg' href="./admusuarios.php">NO</a>





</div>


</body>

</html>