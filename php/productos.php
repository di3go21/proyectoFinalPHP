<?php
//include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";
session_start();
$con = getConexion();

$categorias = dameCategorias();

$productos = dameProductosDisponibles($con);

if (isset($_GET['query']) && $_GET['query'] != "") {
    $cadena = sanear("query");
    $productos = dameProductosConQuery($con, $cadena);
}

if (isset($_GET['categoria']) && in_array($_GET['categoria'], $categorias)) {
    $categoria = sanear("categoria");
    $productos = dameProductosDeCategoria($con, $categoria);
}

$orden = ["precio", "unidadesDisponibles", "asc", "desc"];

if (isset($_GET['orden']) && in_array($_GET['orden'], $orden)  && isset($_GET['tipo']) && in_array($_GET['tipo'], $orden)) {

    $productos = dameProductosOrdenados($con, $_GET['orden'], $_GET['tipo']);
}



?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>Inicio App</title>
</head>

<body>





    <?php include "./includes/menu.php" ?>

    <div class="container">

    
    <h1>Bienvenido a la app</h1>

        <p><a href="productos.php">Limpiar Filtros</a></p>
        <p>Buscar
        <form action="productos.php">
            <input type="text" name="query" id=""> <input type="submit" value="buscar" name="buscar">
        </form>
        </p>
        <p>Categorías</p>
        <form action="productos.php">
            <label for="categoria">Elije categoría</label>
            <select name="categoria" id="categoria">
                <option selected>Todos</option>
                <?php foreach ($categorias as $value) {
                    if ($_GET['categoria'] == $value)
                        echo "<option selected>$value</option>";
                    else

                        echo "<option >$value</option>";
                } ?>
            </select>
            <input type="submit" value="mostrar categoria" name="buscPorCat">
        </form>

<br><br>

        <h3>Estos son todos los productos disponibles:</h3>

        <?php
        if (!empty($productos)) {

            echo "<table class='table table-striped'>";
            echo "<tr>";
            foreach ($productos[0] as $key => $value) {
                if ($key != "id" && $key != "descripcion") {
                    if (in_array($key, $orden))
                        echo "<th> <a href='productos.php?orden=$key&tipo=desc'><i class='bi bi-arrow-bar-up'></i></a> $key <a href='productos.php?orden=$key&tipo=asc'>
                        <i class='bi bi-arrow-bar-down'></i></a></th>";
                    else
                        echo "<th>$key</th>";
                }
            }
            echo "</tr>";
            foreach ($productos as $key => $producto) {
                echo "<tr>";

                foreach ($producto as $campo => $valor) {

                    if ($campo != "id" && $campo != "descripcion") {

                        echo "<td>";
                        if ($campo == "imagen")
                            echo "<img src='./public/img/$valor' height='120px'>";
                        elseif ($campo == "nombre")
                            echo "<a href='producto.php?id=" . $producto['id'] . "'>$valor</a>";
                        else
                            echo $valor;
                    }
                }

                echo "<form action='insertaCarrito.php' method='POST'> ";
                echo "<input type='hidden' name='cantidad' value='1'> ";
                echo "<input type='hidden' name='idProducto' value='" . $producto['id'] . "'> ";
                echo "<input type='submit' name='insertaACarrito' value='Añade al carrito'>";
                echo "</form> ";

                echo "</tr>";
            }

            echo "</table>";
        } else {

            echo "<h2>No hay productos disponibles con el actual criterio de búsqueda</h2>";
        }
        ?>


    </div>



</body>

</html>