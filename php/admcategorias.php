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


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion Categorias</title>
</head>

<body>

    <h1>administración categorías</h1>

    <?php echo "<h5>$mensaje</h5>"; ?>
    <h2>Lista categorias</h2>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Acción</th>
            </tr>

            <?php
            if (!empty($todasLasCategorias)) {
                foreach ($todasLasCategorias as $key => $value) {
                    echo "<tr>";
                    echo "<td>$value</td>";
                    echo "<td><a href='admcategorias.php?eliminar=$value'>Eliminar</a> <a href='editarcategoria.php?editar=$value'>Editar</a> </td>";
                    echo "<tr>";
                }
            }
            ?>
        </table>

        <a href="addcategoria.php">Insertar Nueva Categoría</a>


</body>

</html>