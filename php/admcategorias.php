<?php

include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$con = getConexion();
$todasLasCategorias = dameCategorias();
$mensaje="";

if(isset($_GET['eliminar']) && in_array($_GET['eliminar'],$todasLasCategorias)){

   if (eliminarCategoria($con,$_GET['eliminar'])){
        $mensaje="Se ha eliminado la categoría ".$_GET['eliminar'];
   }else{
        $mensaje="No se ha podido eliminar la categoría ".$_GET['eliminar'].", intentelo de nuevo";

   }

   $todasLasCategorias = dameCategorias();
}


?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Adm Categorías</title>
  </head>

<body>
  
<?php include "./includes/menu.php" ?><br><br>

<div class="container">

<h1>Administración categorías</h1><br>

<?php echo "<h5>$mensaje</h5><br>"; ?>
<h2>Lista categorias</h2>
    <table class="table table-striped text-center">
        <tr>
            <th>Nombre</th>
            <th>Acción</th>
        </tr>

        <?php
        if (!empty($todasLasCategorias)) {
            foreach ($todasLasCategorias as $key => $value) {
                echo "<tr>";
                echo "<td>$value</td>";
                echo "<td><a class='btn btn-danger' href='admcategorias.php?eliminar=$value'>Eliminar</a> <a class='btn btn-warning' href='editarcategoria.php?editar=$value'>Editar</a> </td>";
                echo "<tr>";
            }
        }
        ?>
    </table>

    <a class='btn btn-success' href="addcategoria.php">Insertar Nueva Categoría</a>






</div>

</body>

</html>