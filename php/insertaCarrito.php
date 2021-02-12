<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";

 echo "<pre>";
 print_r($_POST);
// print_r($_SESSION);


$con = getConexion();

    $productosCarrito= getCarritoDeUsuario($con,$_SESSION['id']);
    
    echo "<br>CARRITO ANTES DE DE ISERTAR<br>";
    print_r($productosCarrito);
       insertaProductoACarritoDeUsuario($con,$productosCarrito,$_SESSION['id'],$_POST['idProducto'],$_POST['cantidad']);
       

       echo "<p>producto añadido al carrito</p>";

    echo "<br>CARRITO DESPUES DE INSERTAR<br>";

    $productosCarrito= getCarritoDeUsuario($con,$_SESSION['id']);
    print_r($productosCarrito);


?>

<p>carrito actualizado</p>


