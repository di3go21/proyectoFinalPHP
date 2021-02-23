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
            header("location: ./admcategorias.php");
            exit;

        }else{
            
         $error="<p style='color:red'>Ocurrió un problema al intentar actualizar, inténtelo otra vez<p>";
        }


    }else{
        $error="<p style='color:red'>Categoría inválida o vacía<p>";
    }

}

else{
    header("location: ./admcategorias.php");
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

    <title>Editar Categoría App</title>
  </head>
<body>
    
<?php include "./includes/menu.php" ?>
    

<div class="container">
<form action="./editarcategoria.php" class="mt-5" method="POST">
    <h4>Editar Categoría</h4>
    <br>
    <p><label for="cat"><b>Nombre Categoría: </b><input type="text" name="cat" value="<?=$nombreCategoria ?>" id="cat"></label></p>
    <input type="hidden" name="id" value="<?= $idCat?>">
    <input type="submit" name="enviar" value="Editar" id="cat">
    <?php echo $error; ?>
</form>

</div>
    
</body>
</html>