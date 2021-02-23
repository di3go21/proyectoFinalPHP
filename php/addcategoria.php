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

?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Adm Añade Categoría</title>
  </head>

<body>

<?php include "./includes/menu.php" ?><br><br>
<div class="container">

    <h1>Añade una categoría</h1><br><br>

    <form action="addcategoria.php" method="POST">
        
        <p><label for="cat">Nombre Categoría: <input type="text" name="cat"  id="cat"></label></p>
        
        <input type="submit" class="btn btn-success" name="enviar" value="Añadir" id="cat">
        <?php echo "<p class='text-danger'>$error</p>"; ?>
    </form>
    

</div>


</body>
</html>