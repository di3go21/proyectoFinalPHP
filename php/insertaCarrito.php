<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";

if(!isset($_POST['insertaACarrito'])){
    header("location: aplicacion.php");
    exit;
}


//validar y recoger bien 

$con = getConexion();

    $productosCarrito= getCarritoDeUsuario($con,$_SESSION['id']);
    
       insertaProductoACarritoDeUsuario($con,$productosCarrito,$_SESSION['id'],$_POST['idProducto'],$_POST['cantidad']);
       


    $productosCarrito= getCarritoDeUsuario($con,$_SESSION['id']);


    header("location: carrito.php");
?>

