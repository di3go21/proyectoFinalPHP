<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$con=getConexion();

$productos=dameTodosLosProductos($con);
$mensaje="";
// echo "<pre>";
// print_r($productos);
if(isset($_GET['eliminar'])){
    $mensaje="<h5>Se ha eliminado el producto adecuadamente</h5>";
}
?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Adm - Productos</title>
  </head>

<body>
  
<?php include "./includes/menu.php" ?>
<br><br>

<div class="container">
<h1>Administracion productos</h1>
<a class="btn btn-lg btn-success" href="./admnuevoproducto.php">Añade nuevo producto</a><br><br>

<h3 class="display-4">Lista De Productos</h3>
<?php
echo $mensaje;
if(empty($productos)){
    echo "<h5>No hay productos en la tienda.</h5>";
}else{
    echo "<table class='table table-striped'>";
    echo "<tr>";
    foreach ($productos[0] as $key=> $value) {
        if($key=="unidadesDisponibles")
            echo "<th>Unid. Disp.</th>";
        else
        echo "<th>$key</th>";
    }
    echo "<th>Categorías</th>";
    echo "<th>Acción</th>";
    echo "</tr>";

    
    foreach ($productos as $producto) {
        $categorias=dameCategoriasDeProducto($con,$producto['id']);



        $categorias=(empty($categorias))?"":implode(", ",$categorias);


        echo "<tr>";
        foreach ($producto as $key => $value) {
            if($key=="descripcion"){
                echo "<td class='text-center'>".substr($value,0,15)."...</td>";
            }else
            
            echo "<td class='text-center'>$value</td>";
        }
        echo "<td>$categorias</td>";
        echo "<td>
        <a href='./admeliminarProducto.php?id=".$producto['id']."'>Eliminar</a>
        <a href='./admeditarProducto.php?id=".$producto['id']."'>Editar</a></td>";

    echo "</tr>";
    }

    
    echo "</table>";
}


?>

    




</div>        <!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>