<?php

include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
if(!isset($_GET['ok'])){
    header('location: areaPersonal.php');
    exit;
}
$con=getConexion();
actualizaVariablesEnSession($con, $_SESSION["email_usuario_autenticado"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos actualizados</title>
</head>
<body>

<?php include "./includes/menu.php"; ?>

<h3>Datos actualizados correctamente</h3>
<p><a href="areaPersonal.php">Volver al área Personal</a></p>
    
</body>
</html>