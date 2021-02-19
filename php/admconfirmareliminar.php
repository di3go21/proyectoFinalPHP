<?php

include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$con = getConexion();
$id = $_GET['eliminar'];
$emailUsuario = dameCampoUsuario($con, "email", $id);
$usuario = dameUsuario($con, $emailUsuario);

if (empty($usuario)) {
    header("location: admusuarios.php");
    exit;
}
if (isset($_GET['confirmar']) && $_GET['confirmar'] == "si") {
    if (insertaBaja($con, $emailUsuario)) {
        vaciarCarrito($con, $emailUsuario);
        if (borraUsuario($con, $emailUsuario)) {
            header("location: admusuarios.php");
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h3>seguro que quieres eliminar el usuario :</h3>
    <?php echo "<pre>";
    print_r($usuario);
    echo "</pre>";

    echo "<a href='admconfirmareliminar.php?eliminar=$id&confirmar=si'>SI</a>";
    ?>
    <a href="admusuarios.php">NO</a>


</body>

</html>