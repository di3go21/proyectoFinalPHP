<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
//session_start();
$email = $_SESSION["email_usuario_autenticado"];
try {
    $con = getConexion();
    $st = $con->prepare("select id,email,nombre,apellidos,direccion,fechaRegistro  from usuario where email=?");
    $st->execute([$email]);
    $rs = $st->fetchAll(PDO::FETCH_ASSOC); //devuelve el numero del count consultado

    foreach ($rs[0] as $key => $value) {
        $_SESSION[$key] = $value;
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
}
$productos = [];
$productos = dameProductosDisponibles($con);


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

    <h1>bienvenido a la app</h1>

    <p><a href="./logout.php">SALIR</a></p>


    <p>PRODUCTOS</p>

    <?php
    echo "<table>";
    echo "<tr>";
    foreach ($productos[0] as $key => $value) {
        if ($key != "id" && $key != "descripcion" )
            echo "<th>$key</th>";
    }
    echo "</tr>";
    foreach ($productos as $key => $producto) {
        echo "<tr>";

        foreach ($producto as $campo => $valor) {
            
            if ($campo != "id" && $campo != "descripcion" ){

                echo "<td>";
                if($campo=="imagen")
                    echo "<img src='./public/img/$valor' height='120px'>";
                elseif($campo=="nombre")
                    echo "<a href='producto.php?id=".$producto['id']."'>$valor</a>";
                else
                    echo $valor;
            }               
        }

        echo "</tr>";
    }

    echo "</table>";
    ?>

</body>

</html>