<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$con= getConexion();
$error=[];
$id=sanear('id');
$producto=dameDatosProducto($con,$id);
if(empty($producto)){
    header("location: admproductos.php");
    exit;
}
if(isset($_GET['confirma']) && $_GET['confirma']=="si"){
    eliminarProducto($con,$id);
    header("location: admproductos.php?eliminar=ok");
    exit;
}


?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Adm - Eliminar Producto</title>
  </head>

<body>
  
<?php include "./includes/menu.php" ?>
<br><br>

<div class="container">

<h4 class="display-4">¿Seguro que quieres eliminar el producto?</h4>
<br>
<ul>
    <?php
    foreach ($producto as $key => $value) {
        echo "<li><b>$key</b>: $value</li>";
    }

?>

</ul>

<a class="btn btn-danger" href="admeliminarProducto.php?id=<?=$id ?>&confirma=si">Eliminar</a>

<a class="btn btn-primary" href="admproductos.php">Volver</a>





</div>

    
</body>
</html>