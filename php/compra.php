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
print_r($carrito);


//crear venta 
$idVenta = time()."-".$_SESSION['id'];
$venta=realizaVenta($con,$idVenta,$_SESSION['id'],$carrito);
if($venta){
    registraVentaArticulo($con,$idVenta,$carrito);
    vaciarCarrito($con,$_SESSION['id']);
}
else{
    $error="No se ha podido procesar la venta. Por favor inténtelo de nuevo.";
}
$arrayVenta[]=dameVenta($con,$idVenta);
$arrayVenta[]=dameArticulosVenta($con,$idVenta);

echo "<pre>"; print_r($arrayVenta);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>
</head>
<body>
<?php include "./includes/menu.php" ?>
    
</body>
</html>