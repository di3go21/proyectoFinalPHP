<?php



include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/peticiones.php";
include "./bbdd/conexion.php";
include "./includes/validaciones.php";
include "./includes/sanear.php";






$con = getConexion();
$ventas = dameVentas($con, $_SESSION['email']);
$nombreErr = $error= $apellidosErr =$mensaje  = $direccionErr = $passErr = "";

// echo "<pre>";  print_r($_SESSION);

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
    }else{
        $passErr = "Contraseña antigua incorrecta!";
        $todosLosCamposSonValidos = false;
    }
    if ($todosLosCamposSonValidos) {
        
        if (actualizaDatosUsuario($con,$_SESSION['email'],$pass1,$nombre,$apellidos,$direccion)){
            header("location: datosActualizados.php?ok=si");
            exit;
        }else{

            $error="No se han podido actualizar los datos correctamente, intentelo de nuevo!";
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
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script>
        onload=()=>{
            $('#eliminarCuenta').click(()=>{
                window.location.href="eliminarCuenta.php";
            })
        }
    </script>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>


    <?php include "./includes/menu.php"; ?>

    <h1>Estos son tus datos, los puedes personalizar si deseas:</h1>
    <?php echo "<h3>$error</h3>"; ?>
    <form action="areaPersonal.php" method="POST">

        <label>Email<input type="text" disabled id="" value="<?= $_SESSION['email'] ?>"></label>
        <br>

        <label>Password Antigua<input type="text" name="pass0" id=""></label><br>
        <label>Password Nueva<input type="text" name="pass1" id=""></label><br>
        <label>Repite Password Nueva<input type="text" name="pass2" id=""></label>
        <small>Una mayuscula, una minúscula y un numero y longitud mayor que 8</small>
        <small>Si no quieres cambiar la contraseña simplemente introducela 3 veces</small>
        <span class="error"><?php echo $passErr; ?></span><br>

        <label>Nombre<input type="text" name="nombre" id="" value="<?= $_SESSION['nombre'] ?>"></label>
        <span class="error"><?php echo $nombreErr; ?></span><br>

        <label>Apellidos<input type="text" name="apellidos" id="" value="<?= $_SESSION['apellidos'] ?>"></label>
        <span class="error"><?php echo $apellidosErr; ?></span><br>

        <label>direccion<input type="text" name="direccion" id="" value="<?= $_SESSION['direccion'] ?>"></label>
        <span class="error"><?php echo $direccionErr; ?></span><br>
        <input type="submit" value="Editar Datos" name="enviar">






    </form>
    <?php if($_SESSION['esAdmin']=="NO") echo  "<button id='eliminarCuenta'> Eliminar Cuenta</button>"  ?>


<?php

        if(!empty($ventas)){
            echo "<pre>"; print_r($ventas);
        }
         ?>

</body>

</html>