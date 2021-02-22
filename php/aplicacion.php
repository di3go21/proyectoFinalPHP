<?php
//include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";
session_start();
$email = isset($_SESSION["email_usuario_autenticado"]) ? $_SESSION["email_usuario_autenticado"] : "";
$con = getConexion();
if ($email != "") {
    actualizaVariablesEnSession($con, $email);
}
$categorias = dameCategorias();

$productos = [];
$productos = dameProductosDisponibles($con);
$numero_de_productos = count($productos);
$num_prod_por_pagina = 4;
$numero_de_paginas = ceil($numero_de_productos / $num_prod_por_pagina);

if (isset($_GET['pagina'])) {

    $pagina = sanear('pagina');
    if (!is_numeric($pagina) || $pagina < 0 || $pagina > $numero_de_paginas) {
        $pagina = 1;
    }
} else
    $pagina = 1;

$offset = (($pagina - 1) * $num_prod_por_pagina);

$productos = damePaginados($con, $offset, $num_prod_por_pagina );
?><!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>EasyMusica - Aplicación</title>
    <script>

        onload=function (){
            $("th").each(function (){
                $(this).text($(this).text().charAt(0).toUpperCase()+$(this).text().slice(1));
            })
        }
      
    </script>

</head>

<body>





    <?php include "./includes/menu.php" ?>

    <div class="container">


        <h2 class="mt-5 mb-5">bienvenido a la app</h2>




        <h4>PRODUCTOS</h4>

        <?php
        echo "<table class='table'>";
        echo "<tr>";
        foreach ($productos[0] as $key => $value) {
            if ($key != "id" && $key != "descripcion")
                echo "<th>$key</th>";
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
        ?>
        <nav>
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="?pagina=1">Primera</a></li>
            <li class="page-item <?php if ($pagina <= 1) {
                            echo 'disabled';
                        } ?>">
                <a class="page-link" href="<?php if ($pagina <= 1) {
                                echo '#';
                            } else {
                                echo "?pagina=" . ($pagina - 1);
                            } ?>">Anterior</a>
            </li>
            <li class="page-item <?php if ($pagina >= $numero_de_paginas) {
                            echo 'disabled';
                        } ?>">
                <a class="page-link" href="<?php if ($pagina >= $numero_de_paginas) {
                                echo '#';
                            } else {
                                echo "?pagina=" . ($pagina + 1);
                            } ?>">Siguiente</a>
            </li>
            <li class="page-item"><a class="page-link" href="?pagina=<?php echo $numero_de_paginas; ?>">Última</a></li>
        </ul>
        </nav>




    </div>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>