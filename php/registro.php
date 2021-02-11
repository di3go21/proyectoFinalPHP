<?php
include "./includes/sanear.php";


if(isset($_GET['enviar'])){
    include "./bbdd/conexion.php";
    $nombre = sanear("nombre");
    $email = sanear("email");
    $pass = sanear("pass");
    $apellidos = sanear("apellidos");
    $direccion = sanear("direccion");
    $fechaRegistro="10-10-1000";
    
    $con = getConexion();

    
    $st=$con->prepare("insert into USUARIO
         (nombre,apellidos,password,direccion,email,fechaRegistro) values 
        ('$nombre','$apellidos','$pass','$direccion','$email','$fechaRegistro')");
    $st->execute();



    
    $st=$con->prepare("select * from USUARIO");
    $st->execute();
    $resultado=$st->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    print_r($resultado);
  


}


?>
    

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>

    <h1>registro</h1>
<form action="registro.php" method="get">
    <label>Email<input type="text" name="email" id=""></label><br>
    <label>Password<input type="text" name="pass" id=""></label><br>
    <label>repite Pass<input type="text" name="pass2" id=""></label><br>

    <label>Nombre<input type="text" name="nombre" id=""></label><br>
    <label>Apellidos<input type="text" name="apellidos" id=""></label><br>
    <label>direccion<input type="text" name="direccion" id=""></label><br>
    <input type="submit" value="ENVIAR" name="enviar">

    </form>

        
    </body>
    </html>