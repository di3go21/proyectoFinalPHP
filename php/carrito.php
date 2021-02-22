<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/peticiones.php";
include "./bbdd/conexion.php";

$con = getConexion();
$carrito = getCarritoDeUsuario($con, $_SESSION['id']);
$precioTotal = 0;


?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script>
        onload = () => {
            $("#confimacionCompra").click(avisaCompra);
            $("th").each(function (){
                $(this).text($(this).text().charAt(0).toUpperCase()+$(this).text().slice(1));
            })
        }
      

        function avisaCompra(evento) {
            evento.preventDefault();
            alert("Para realizar la compra vuelve a pulsar en el link 'COMPRA TUS PRODUCTOS'");
            $(evento.target).attr("href", "compra.php");
            $(evento.target).off();

        }
    </script>
    <title>Carrito</title>
</head>

<body>


    <?php include "./includes/menu.php" ?>

    <div class="container mt-5">
        
    <?php
        if (!empty($carrito)) {
        echo "<h3>Tu Carrito es:</h3>";

        echo "<form method='POST' action='eliminaCarrito.php'>";
        echo "<table class='table mb-5'>";

        echo "<tr>";
        foreach ($carrito[0] as $key => $value) {
            if ($key != "id")
                echo "<th>$key</th>";
        }
        echo "<th>Precio</th>";
        echo "<th>Eliminar</th>";
        echo "</tr>";

        foreach ($carrito as $key => $value) {
            echo "<tr>";
            $precioUnitario = damePrecioDeProducto($con, $value['id']);
            $precio = ($precioUnitario * $value['cantidad']);
            $precioTotal += $precio;
            foreach ($value as $campo => $valor) {

                if ($campo != "id")
                    echo "<td>$valor</td>";
            }
            echo "<td>$precio</td>";
            echo "<td><input  type='checkbox' name='prodsAEliminar[]' value='" . $value['id'] . "'></td>";

            echo "</tr>";
        }
        echo "<tr><td></td><td><b>TOTAL</b></td><td>$precioTotal</td><td></td></tr>";

        echo "</table>
        <input class='btn btn-danger' type='submit' value='Eliminar Seleccionados' name='eliminaProductos'>
    </form>";


        echo "<a class='mt-3 btn btn-success btn-lg' id='confimacionCompra' href='#'> COMPRA TUS PRODUCTOS </a>";
    } else {
        echo "<p>Tu carrito está vacío</p>";
    }


    ?>

    </div>

        <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

   
</body>

</html>