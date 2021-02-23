<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";
$con = getConexion();
$error = [];

$categorias = dameCategorias();
if (isset($_POST['enviar'])) {

    $nombre = sanear("nombre");
    $existe = existeProducto($con, $nombre);

    $desc = sanear("desc");
    $precio = sanear("precio");
    $unidades = sanear("unidades");
    $nombre = sanear("nombre");

    //validacion categorias
    if (isset($_POST["categorias"]) && !empty($_POST["categorias"])) {
        $categoriasRec = $_POST["categorias"];
        $categoriasValidas = true;
        foreach ($categoriasRec as $key => $value) {
            if (!in_array($value, $categorias))
                $categoriasValidas = false;
        }
        if (!$categoriasValidas)
            $error[] = "Alguna categoría no es válida";
    } else {
        $error[] = "Debes seleccionar alguna categoría categorías";
    }

    //validacion nombre

    if (empty($nombre))
        $error[] = "El campo nombre es obligatorio";
    elseif ($existe == "1")
        $error[] = "Un producto con ese nombre ya existe";
    elseif (!preg_match("/^[a-zA-ZñÑçÇáéúíóÁÉÍÓÚÜü 0-9]{5,50}$/", $nombre)) {
        $error[] = "Formato de nombre inválido";
    }

    if (empty($desc))
        $error[] = "El campo descripción es obligatorio";
    elseif (!preg_match("/^[a-zA-ZñÑçÇáéúíóÁÉÍÓÚÜü 0-9\-\/,:.;\\\!?¿¿'<>\"&%\$&%()=\n\r]{10,1000}$/", $desc)) {
        $error[] = "Formato de descripción inválido";
    }

    if (empty($precio)) {
        $error[] = "El precio es obligatorio";
    } elseif (!preg_match("/^[0-9]{1,5}[,.]{1}[0-9]{2}$/", $precio)) {
        $error[] = "El precio debe ser un número con dos decimales como máximo por ejemplo 100.00";
    } else {
        $precio = str_replace(",", ".", $precio);
    }

    if (empty($unidades)) {
        $error[] = "Debes especificar las unidades disponibles";
    } elseif (!is_int(intval($unidades)) && intval($unidades) < 0) {

        $error[] = " $unidades Las unidades disponilbes deben ser un número entero positivo";
    }

    if (empty($error)) { //subimos fichero


        if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
            $directorio = "./public/img";

            $nombreFichero = $_FILES['foto']['name'];
            $nombreCompleto = $directorio . "/" . $nombreFichero;
            if (is_file($nombreCompleto)) {
                $idUnico = time();
                $nombreFichero = $idUnico . $nombreFichero;
                $nombreCompleto = $directorio . "/" . $nombreFichero;
            }
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $nombreCompleto)) {

                if (!insertaNuevoProducto($con, $nombre, $desc, $precio, $unidades, $nombreFichero)) {
                    $error[] = "No se ha podido insertar el producto";
                } else {

                    guardaCategorias($con, $nombre, $categoriasRec);


                    header("location: ./admnuevoproducto.php?insertar=ok");
                    exit;
                }
            } else {
                $error[] = "No se pudo mover el fichero de forma correcta";
            }
        } else {
            $error[] = "No se ha subido ninguna foto";
        }
    }
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

    <title>Adm- Insertar nuevo Producto</title>
</head>

<body>

    <?php include "./includes/menu.php" ?>
    <br><br>

    <div class="container">

        <h1>Insertar nuevo Producto:</h1><br><br>

        <?php if (isset($_GET['insertar']) && $_GET['insertar'] == "ok")
            echo "<h3>¡Producto insertado correctamente!</h3>";
        ?>

        <form action="./admnuevoproducto.php" method="POST" class="row" enctype="multipart/form-data">


            <?php
            if (!empty($error))
                foreach ($error as $key => $value) {
                    echo "<div class='col-12'><p class='text-danger'>$value</p></div>";
                }
            ?>

            <div class="form-group col-md-8">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" class="form-control" id="nombre">
            </div>
            <div class="form-group col-md-8">
                <label for="desc">Descripción: </label>
                <textarea class="form-control"  name="desc" id="desc" cols="30" rows="4"></textarea>
            </div>
            <div class="form-group col-md-8">
                <label for="precio">Precio: </label>
                <input type="text" name="precio" class="form-control" id="precio" placeholder="100.00">
            </div>

            <div class="form-group col-md-8">
                <label for="unidades">Unidades disponibles: </label>
                <input type="text" name="unidades" class="form-control" id="unidades" >
            </div>
            
            <div class="form-group col-md-8">
                <label for="foto">Foto: </label>
                <input type="file" name="foto" class="form-control-file" id="foto" >
            </div>
            <div class="col-md-8">
            <p>Categorías: </p>
            <?php
            foreach ($categorias as $key => $value) {
                // echo "<label><input name='categorias[]' type='checkbox' value='$value' >$value</label>";
                echo "<div class='form-check form-check-inline'>
                <input class='form-check-input' type='checkbox' name='categorias[]' id='$value'value='$value'>
                <label class='form-check-label' for='$value'>$value</label>
              </div>";
            }
            ?>
            </div>


            <div class="form-group col-md-8">
            
                 <input type="submit" value="Enviar" class="btn btn-success btn-lg mt-5" name="enviar">
            </div>


        </form>

    </div>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>