<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";


$con=getConexion();



?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido al area de admin</title>
</head>
<body>

<?php include "./includes/menu.php"; ?>

<h1>bienvenido <?php echo $_SESSION['nombre'] ?></h1>

<h4>Que deseas consultar?</h4>



<ul>
<li><a href="admusuarios.php"></a> gestionar usuarios</li>
<li><a href="admproductos.php"></a> gestionar productos</li>
<li><a href="admcategorias.php"></a> gestionar categorias</li>
<?php if($_SESSION['puedeRealizarInformes']=="SI")
    echo "<li><a href='adminformes.php'></a> gestionar categorias</li>" ;
?>
</ul>
    
</body>
</html>