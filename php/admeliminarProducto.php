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


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php 
include "./includes/menu.php"; ?>

<h4>Seguro que quieres eliminar el producto</h4>
<pre>
<?php print_r($producto); ?>
</pre>

<a href="admeliminarProducto.php?id=<?=$id ?>&confirma=si">Eliminar</a>

<a href="admproductos.php">Volver</a>

    
</body>
</html>