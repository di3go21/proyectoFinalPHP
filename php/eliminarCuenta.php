<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/peticiones.php";
include "./bbdd/conexion.php";
include "./includes/validaciones.php";
include "./includes/sanear.php";
$mensaje = "";
$con = getConexion();
if (isset($_GET['confirmacion']) && $_GET['confirmacion'] == "si") {


    if (insertaBaja($con, $_SESSION['email'])) {
        vaciarCarrito($con, $_SESSION['email']);
        if (borraUsuario($con, $_SESSION['email'])) {
            //cierra sesion
            session_unset();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            session_destroy();
            header("location: confirmacionEliminado.php");
            exit;
        } else {
            $mensaje = "error al intentar el borrado";
        }
    } else {
        $mensaje = "error al intentar el borrado";
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

    <title>Eliminar Cuenta</title>
</head>

<body>
    <?php include "./includes/menu.php"; ?>

    <div class="container  mt-5">

        <div class="row justify-content-center  mt-5">

            <div class="col-12 ">
                <h1 class="text-center mb-5 mt-5">¿Está seguro de que desea eliminar su cuenta?</h1>
            </div>
            <div class="col-2">
                <a class="btn btn-lg btn-danger" href="eliminarCuenta.php?confirmacion=si">SI</a>

            </div>
            <div class="col-2">
                <a class="btn btn-lg btn-success" href="areaPersonal.php">NO</a>

            </div>
            <div class="col-2">
                <a class="btn btn-lg btn-primary" href="areaPersonal.php">Volver</a>

            </div>
            <div class="col-12">
                <?php if ($mensaje != "") echo "<h5>$mensaje</h5>"; ?>

            </div>
        </div>
    </div>
</body>

</html>