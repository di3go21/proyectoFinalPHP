<?php

include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/peticiones.php";
include "./bbdd/conexion.php";


$con=getConexion();


$carrito=getCarritoDeUsuario($con,$_SESSION['id']);
if(empty($carrito)){
    header("location: carrito.php");
    exit;
}

$venta=realizaVenta($con,$_SESSION['id']);



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