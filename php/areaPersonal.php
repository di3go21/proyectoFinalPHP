<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/peticiones.php";
include "./bbdd/conexion.php";
include "./includes/validaciones.php";
include "./includes/sanear.php";
$con = getConexion();
$ventas = dameVentas($con, $_SESSION['email']);
$nombreErr = $error = $apellidosErr = $mensaje  = $direccionErr = $passErr = "";

if (isset($_POST['enviar'])) {
    $nombre = sanear("nombre");
    $pass0 = sanear("pass0");
    $pass1 = sanear("pass1");
    $pass2 = sanear("pass2");
    $apellidos = sanear("apellidos");
    $direccion = sanear("direccion");

    $todosLosCamposSonValidos = true;

    if ($nombre == "") {
        $nombreErr = "El nombre es obligatorio";
        $todosLosCamposSonValidos = false;
    } else {
        if (!esNombreOApellidoValido($nombre)) {
            $nombreErr = "El nombre es inválido";
            $todosLosCamposSonValidos = false;
        }
    }

    if ($apellidos == "") {
        $apellidosErr = "Los apellidos son obligatorios";
        $todosLosCamposSonValidos = false;
    } else {
        if (!esNombreOApellidoValido($apellidos)) {
            $apellidosErr = "Los apellidos son inválidos";
            $todosLosCamposSonValidos = false;
        }
    }

    if ($direccion == "") {
        $direccionErr = "La dirección es obligatoria";
        $todosLosCamposSonValidos = false;
    } else {
        if (!esDireccionValida($direccion)) {
            $direccionErr = "La dirección es inválida";
            $todosLosCamposSonValidos = false;
        }
    }

    $rs = logIn($con, $_SESSION['email'], $pass0);
    if ($rs == 1) {
        if ($pass1 == "" || $pass2 == "") {
            $passErr = "Rellena ambos campos de contraseña";
            $todosLosCamposSonValidos = false;
        } else if ($pass1 != $pass2) {
            $passErr = "Las contraseñas no coinciden";
            $todosLosCamposSonValidos = false;
        } else {
            if (strlen($pass1) < 8) {
                $passErr = "Tu contraseña tiene que ser al menos de 8 caracteres!";
                $todosLosCamposSonValidos = false;
            } elseif (!preg_match("#[0-9]+#", $pass1)) {
                $passErr = "Tu contraseña tiene que contener al menos un número!";
                $todosLosCamposSonValidos = false;
            } elseif (!preg_match("#[A-Z]+#", $pass1)) {
                $passErr = "Tu contraseña tiene que contener al menos una mayúscula!";
                $todosLosCamposSonValidos = false;
            } elseif (!preg_match("#[a-z]+#", $pass1)) {
                $passErr = "Tu contraseña tiene que contener al menos una minúscula!";
                $todosLosCamposSonValidos = false;
            }
        }
    } else {
        $passErr = "Contraseña antigua incorrecta!";
        $todosLosCamposSonValidos = false;
    }
    if ($todosLosCamposSonValidos) {

        if (actualizaDatosUsuario($con, $_SESSION['email'], $pass1, $nombre, $apellidos, $direccion)) {
            header("location: datosActualizados.php?ok=si");
            exit;
        } else {

            $error = "No se han podido actualizar los datos correctamente, intentelo de nuevo!";
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
    <script>
        onload = () => {
            $('#eliminarCuenta').click(() => {
                window.location.href = "eliminarCuenta.php";
            })
            $(".compras > li > ul").hide();
             $(".compras > li > span ").click((evento)=>{
                $(evento.target).next().toggle();
            });
        }
    </script>
    <style>
        .error {
            color: red;
        }
    </style>
    <title>Área de <?= $_SESSION['nombre'] ?></title>
</head>


<body>


    <?php include "./includes/menu.php"; ?>


    <div class="container mt-5">
        <h1>Estos son tus datos, los puedes personalizar si deseas:</h1>
        <?php echo "<h3 class='text-danger'>$error</h3>"; ?>
        <form action="areaPersonal.php" class="form mt-5" method="POST">

            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="email">Email: </label>
                        <input type="text" class="form-control" disabled id="email" value="<?= $_SESSION['email'] ?>" >
                    </div>

                    <div class="form-group">
                        <label for="pass0">Password Antigua: </label>
                        <input type="password" class="form-control" name="pass0"  id="pass0" >
                    </div>

                    <div class="form-group">
                        <label for="pass1">Password Nueva: </label>
                        <input type="password" class="form-control" name="pass1"  id="pass1" >
                    </div>
                    <div class="form-group">
                        <label for="pass2">Repite Password Nueva: </label>
                        <input type="password" class="form-control" name="pass2"  id="pass2" >
                        
                    <small>Una mayuscula, una minúscula y un numero y longitud mayor que 8</small>
                    <small>Si no quieres cambiar la contraseña simplemente introducela 3 veces</small>
                    
                    <span class="error"><?php echo $passErr; ?></span><br>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre: </label>
                        <input type="text" class="form-control" name="nombre"  id="nombre" value="<?= $_SESSION['nombre'] ?>" >
                        <span class="error"><?php echo $nombreErr; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="apellidos">Apellidos: </label>
                        <input type="text" class="form-control" name="apellidos"   id="apellidos" value="<?= $_SESSION['apellidos'] ?>" >
                        <span class="error"><?php echo $apellidosErr; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección: </label>
                        <input type="text" class="form-control" name="direccion"   id="direccion" value="<?= $_SESSION['direccion'] ?>" >
                        <span class="error"><?php echo $direccionErr; ?></span>
                    </div>
                    <input type="submit" value="Editar Datos" class="btn btn-warning" name="enviar">



                </div>


            </div>





        </form>
        <br><br><br>
        <hr>

        <?php if ($_SESSION['esAdmin'] == "NO") echo  " <h5>Si quieres <u class='text-danger'>eliminar</u> tu cuenta pulsa aquí:<button id='eliminarCuenta' class='btn btn-danger'> Eliminar Cuenta</button></h5>"  ?>

        <hr>

        <h5>Estas son tus compras realizadas:</h5>
        <?php

        if (!empty($ventas)) {
            echo "<ul class='compras'>";
            foreach ($ventas as $key => $venta) {
                echo "<li class='mb-3'><span class='btn btn-primary'>Compra ".($key+1).":</span> <ul>";
                    
                    foreach ($venta as $campo => $valor) {
                        if($campo!="articulos")
                            echo "<li>$campo: $valor</li>";
                        else{
                            echo "<li>Artículos: <ul>";
                            foreach ($valor as $keyArt => $articulo) {
                                echo "<li>Articulo ".($keyArt+1).": <ul>";
                                    foreach ($articulo as $campoArt => $valorArt) {
                                        if($campoArt=="xProducto"){
                                            $prod=dameNombreProducto($con,$valorArt);
                                            echo "<li>Producto: $prod</li>";
                                        }else{
                                            echo "<li>$campoArt: $valorArt</li>";
                                        }
                                    }


                                echo "</ul></li>";
                            }
                            echo "</ul></li>";
                        }
                    }






                echo "</ul></li>";
            }            
            echo "</ul>";
        }else{
            echo "<p>No hay compras realizadas aún</p>";
            
        }
    ?>

        



    </div>


    




    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>


</body>

</html>