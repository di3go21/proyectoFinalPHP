<?php
include "./autenticacion/controlLogin.php";
include "./includes/sanear.php";

$usuario = "";
$mensaje = $error = "";


if (isset($_GET['usuario'])) {
    $usuario = sanear('usuario');
}
if (isset($_GET['registrado'])) {
    $usuario = sanear('registrado');
    $mensaje = "¡Enhorabuena ya estás registrado! ingresa tu contraseña para entrar!";
}

if (isset($_POST['enviar'])) {
    $usuario = sanear('email');
    $pass = sanear('pass');
    $camposValidos = true;

    if ($usuario == "" || $pass == "") {
        $camposValidos = false;
        $error = "debe rellenar ambos campos";
    } else if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
        $error = "El email es inválido";
        $camposValidos = false;
    } else {

        include "./bbdd/conexion.php";
        include "./bbdd/peticiones.php";

        $con = getConexion();

        $rs = logIn($con, $usuario, $pass);
        if ($rs == 1) {

            //LOGUEAR Y REDIRIGIR A APPLICACION
            $_SESSION["autenticado"] = "SI";
            $_SESSION["email_usuario_autenticado"] = $usuario;




            header("location:aplicacion.php");
            exit;
        } else {
            $error = "Credenciales incorrectas";
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

    <title>¡Entra!</title>
    <link rel="stylesheet" href="/php/public/css/">
    <style>
        .container{
            margin-top: 100px;
        }
    </style>
</head>

<body>

    <?php include "./includes/menu.php" ?>

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
            <h1>login</h1>
        <p><?= $mensaje ?></p>

        <form class="form" action="" method="POST"><br><br>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" style="width: 20em;" class="form-control" name="email" id="email" value="<?php echo $usuario ?>" >            
        </div>
        <div class="form-group">
            <label for="pass">Pass:</label>
            <input type="password" style="width: 20em;" class="form-control" name="pass" id="pass"  >            
        </div>

            <p class="text-danger"><?php echo $error ?> </p>
            <input type="submit" class="btn btn-success" value="Entrar" name="enviar">
        </form>



            </div>
      

        </div>

      

    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>

</html>