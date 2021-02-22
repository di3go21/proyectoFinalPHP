<?php

include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/peticiones.php";
include "./bbdd/conexion.php";


$con=getConexion();
$error="";

$carrito=getCarritoDeUsuario($con,$_SESSION['id']);
if(empty($carrito)){
    header("location: carrito.php");
    exit;
}
//crear venta 
$idVenta = time()."-".$_SESSION['id'];
$venta=realizaVenta($con,$idVenta,$_SESSION['id'],$carrito,$_SESSION['email']);
if($venta){
    registraVentaArticulo($con,$idVenta,$carrito);
    vaciarCarrito($con,$_SESSION['id']);
}
else{
    $error="No se ha podido procesar la venta. Por favor inténtelo de nuevo.";
}
$arrayVenta["datos"]=dameVenta($con,$idVenta);
$arrayVenta["articulos"]=dameArticulosVenta($con,$idVenta);



?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Compra Realizada</title>
  </head>

<body>
<?php include "./includes/menu.php" ?>

<div class="container ">

<h1 class="mt-5 mb-5 ">¡Compra realizada con éxito!</h1>
    <?php if(!empty($error)) echo "<h2 class='mt-5 mb-5 text-danger'>$error</h2>"?>

    <h5>Estos son los datos de la Compra:</h5>

    <?php
    if(isset($arrayVenta)){
        echo "<div class='row'>";
        echo "<div class='col-md-6'>";
        echo "<h5>Datos de compra</h5>";
        
        echo "<ul>";
        foreach ($arrayVenta['datos'] as $key => $value) {
            echo "<li>$key: $value</li>";
            
        }
        echo "</ul>";
        echo "</div>";
        echo "<div class='col-md-6'>";
        
        echo "<h5>Artículos</h5>";

        echo "<ul>";
        foreach ($arrayVenta['articulos'] as $key => $articulo) {
            echo "<li>Artículo ".($key+1);
           
            foreach ($articulo as $campo => $valor) {
                echo "<ul>";
                if($campo=="xProducto"){
                    $prod=dameNombreProducto($con,$valor);
                    echo "<li>Producto: $prod</li>";
                }else{
                    echo "<li>$campo: $valor</li>";
                }
                echo "</ul>";
            }
            echo "</li>";
            
        }
        echo "</ul>";
        
        echo "</div>";



        echo "</div>";


    }



?>




</div>


    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    
</body>
</html>