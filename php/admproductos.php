<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$con=getConexion();

$productos=dameTodosLosProductos($con);
// echo "<pre>";
// print_r($productos);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>administrar productos</title>
</head>
<body>

<h1>Administracion productos</h1>

<p>Lista De Productos</p>
<?php
if(empty($productos)){
    echo "<h5>No hay productos en la tienda.</h5>";
}else{
    echo "<table>";
    echo "<tr>";
    foreach ($productos[0] as $key=> $value) {
        echo "<th>$key</th>";
    }
    echo "<th>Categorías</th>";
    echo "<th>Acción</th>";
    echo "</tr>";

    
    foreach ($productos as $producto) {
        $categorias=dameCategoriasDeProducto($con,$producto['id']);



        $categorias=(empty($categorias))?"":implode(", ",$categorias);


        echo "<tr>";
        foreach ($producto as $key => $value) {
            echo "<td>$value</td>";
        }
        echo "<td>$categorias</td>";
        echo "<td>
        <a href='eliminarProducto.php'>Eliminar</a>
        <a href='editarProducto.php'>Editar</a></td>";

    echo "</tr>";
    }

    
    echo "</table>";
}


?>

    
</body>
</html>