<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$error="";
if(isset($_POST['enviar'])){

    $nombre=sanear("cat");
    if($nombre!=""){
        $con=getConexion();
        if(insertarNuevaCategoria($con,$nombre)){
            header("location: admcategorias.php");
            exit;
        }else{
            $error="<p style='color:red'>Ya existe la categoría</p>";

        }
    }else{
        $error="<p style='color:red'>Debe insertar un nombre válido</p>";
    }


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

<h1>Añade una categoría</h1>

<form action="addcategoria.php" method="POST">
    
    <p><label for="cat">Nombre Categoría: <input type="text" name="cat"  id="cat"></label></p>
    
    <input type="submit" name="enviar" value="Añadir" id="cat">
    <?php echo $error; ?>
</form>
    
</body>
</html>