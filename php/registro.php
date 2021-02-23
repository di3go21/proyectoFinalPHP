<?php
include "./includes/sanear.php";
$nombreErr = $apellidosErr = $emailErr = $direccionErr = $passErr = "";
$usuarioExistente = "";

if (isset($_POST['enviar'])) {

    $nombre = sanear("nombre");
    $email = sanear("email");
    $pass1 = sanear("pass1");
    $pass2 = sanear("pass2");
    $apellidos = sanear("apellidos");
    $direccion = sanear("direccion");


    $todosLosCamposSonValidos = true;

    include "./includes/validaciones.php";

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

    if ($email == "") {
        $emailErr = "El email es obligatorio";
        $todosLosCamposSonValidos = false;
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "El email es inválido";
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

    if ($direccion == "") {
        $direccionErr = "La dirección es obligatoria";
        $todosLosCamposSonValidos = false;
    } else {
        if (!esDireccionValida($direccion)) {
            $direccionErr = "La dirección es inválida";
            $todosLosCamposSonValidos = false;
        }
    }

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
            $passwpassErrordErr = "Tu contraseña tiene que contener al menos una minúscula!";
            $todosLosCamposSonValidos = false;
        }
    }

    if ($todosLosCamposSonValidos) {
        $fechaRegistro = date("Y-m-d");


        include "./bbdd/conexion.php";

        $pass1 = md5($pass1);
        try {
            $con = getConexion();
            $st = $con->prepare("INSERT into USUARIO
                 (nombre,apellidos,password,direccion,email,fechaRegistro) values 
                (?,?,?,?,?,?)");
            $st->execute([$nombre, $apellidos, $pass1, $direccion, $email, $fechaRegistro]);
            $rs = $con->prepare("INSERT into alta
                    (email,nombre,apellidos,fechaRegistro,hora) values 
                (?,?,?,?,?) ");
            $rs->execute([$email, $nombre, $apellidos, $fechaRegistro, date("H:i:s")]);
            $st = "";
            $con = "";
            header("location: ./login.php?registrado=$email");
            exit;
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $pos = strpos($error, "Duplicate entry");
            if ($pos !== false)
                $usuarioExistente = "<p class='text-danger'>la cuenta con ese usuario ya existe, <a href='login.php?usuario=$email'>pulse aquí</a> para entrar con sus credenciales<p>";
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

    <title>Registro App</title>
</head>

<body>

    <?php include "./includes/menu.php" ?><br><br>
    <div class="container">


        <h1 class="text-center">Registro</h1><br>


        <?php echo $usuarioExistente ?><br>

        <form action="registro.php" class="row justify-content-center" method="POST">
            <div class="form-group col-md-8">
                <label for="email">Email: </label>
                <input type="email" name="email" class="form-control" id="email">
                <span class="text-danger"><?php echo $emailErr; ?></span>
            </div>

            <div class="form-group col-md-8">
                <label for="pass1">Password: </label>
                <input type="password" name="pass1" class="form-control" id="pass1">
            </div>
            <div class="form-group col-md-8">
                <label for="pass2">Repite Password: </label>
                <input type="password" name="pass2" class="form-control" id="pass2">                
                <span class="text-danger"><?php echo $passErr; ?></span>
            </div>
            <div class="form-group col-md-8">
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" class="form-control" id="nombre">                
                <span class="text-danger"><?php echo $nombreErr; ?></span>
            </div>
            <div class="form-group col-md-8">
                <label for="apellidos">Apellidos: </label>
                <input type="text" name="apellidos" class="form-control" id="apellidos">                
                <span class="text-danger"><?php echo $apellidosErr; ?></span>
            </div>
            <div class="form-group col-md-8">
                <label for="direccion">Dirección: </label>
                <input type="text" name="direccion" class="form-control" id="direccion">                
                <span class="text-danger"><?php echo $direccionErr; ?></span>
            </div>
            <div class="form-group col-md-8">
            <input type="submit" class="btn btn-lg btn-success" value="ENVIAR" name="enviar">     
            </div>
            


        </form>


    </div>

</body>

</html>