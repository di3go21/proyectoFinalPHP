<?php
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
$producto = [];
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $con = getConexion();
    $producto = dameDatosProducto($con, $id);
} else {
    header("location: aplicacion.php");
    exit;
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

    <title><?= $producto['nombre'] ?></title>

    <script>
        var precio = <?php echo $producto['precio'] ?>;
        onload = () => {
            $("input[type=number]").on("change", actualiza);
        }

        function actualiza(evento) {
            var $cantidad = $("input[type=number]").val();

            $("span").text(($cantidad * (precio * 100)) / 100);
        }
    </script>
</head>

<body>


    <?php include "./includes/menu.php" ?>


    <div class="container mt-5 text-center">

        <h1>Producto:</h1>

        <?php

        echo "<p><b>Nombre</b>: " . $producto['nombre'] . "</p>";
        echo "<p><b>Precio</b>: " . $producto['precio'] . "</p>";
        echo "<p><b>Descripción</b>: " . $producto['descripcion'] . "</p>";
        echo "<p><b>Foto: </b>   <img height='150px' src='./public/img/" . $producto['imagen'] . "'></p>";
        echo "<p><b>Unidades disponibles: </b>" . $producto['unidadesDisponibles'] . "</p>";

        if ($producto['unidadesDisponibles'] > 0) {
        ?>

            <form action="insertaCarrito.php" method="POST">
                <input type="hidden" name="idProducto" value="<?php echo $producto['id'] ?>"><br>
                <b>Cantidad: </b><input type="number" name="cantidad" value="1" min="1" max="<?php echo $producto['unidadesDisponibles'] ?>" id=""><br><br>
                 <b>Precio: </b><span><?= $producto['precio'] ?></span> € <br><br>
                <input type="submit" class="btn btn-success" value="Al carrito" name="insertaACarrito">
            </form>
        <?php } ?>




    </div>








    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>