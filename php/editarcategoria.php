<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$con=getConexion();
$todasLasCategorias= dameCategorias();
$nombreCategoria="";
$error="";

if(isset($_GET['editar']) && in_array($_GET['editar'],$todasLasCategorias)){
    $nombreCategoria=$_GET['editar'];
    $idCat=dameIdCategoria($con,$nombreCategoria);

}
elseif(isset($_POST['enviar']) ){
    $idCat=sanear('id');
    $nuevoNombreCat=sanear("cat");

    if($idCat!="" && $nuevoNombreCat!="" ){

        if(actualizaCategoria($con,$idCat,$nuevoNombreCat)){
            header("location: admcategorias.php");
            exit;

        }else{
            
         $error="<p style='color:red'>Ocurrió un problema al intentar actualizar, inténtelo otra vez<p>";
        }


    }else{
        $error="<p style='color:red'>Categoría inválida o vacía<p>";
    }

}

else{
    header("location: admcategorias.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="editarcategoria.php" method="POST">
    
        <p><label for="cat">Nombre Categoría: <input type="text" name="cat" value="<?=$nombreCategoria ?>" id="cat"></label></p>
        <input type="hidden" name="id" value="<?= $idCat?>">
        <input type="submit" name="enviar" value="Editar" id="cat">
        <?php echo $error; ?>
    </form>
</body>
</html>