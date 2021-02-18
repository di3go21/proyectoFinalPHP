<?php
include "./includes/sanear.php";
$nombreErr = $apellidosErr = $emailErr = $direccionErr = $passErr = "";
$usuarioExistente="";

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

    if ($todosLosCamposSonValidos){
         $fechaRegistro=date("Y-m-d");
    

        include "./bbdd/conexion.php";

        $pass1=md5($pass1);
        try{
            $con = getConexion();       
            $st=$con->prepare("insert into USUARIO
                 (nombre,apellidos,password,direccion,email,fechaRegistro) values 
                (?,?,?,?,?,?)");
            $st->execute([$nombre,$apellidos,$pass1,$direccion,$email,$fechaRegistro]);
            $st="";
            $con="";

            header("location: ./login.php");
            exit;
        }catch(PDOException $e){
            $error=$e->getMessage();
            $pos = strpos($error, "Duplicate entry");
            if($pos!==false)
                $usuarioExistente="<p>la cuenta con ese usuario ya existe, <a href='login.php?usuario=$email'>pulse aquí</a> para entrar con sus credenciales<p>";
                
            
        }
        
    }



}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

<?php include "./includes/menu.php" ?>

    <h1>registro</h1>


    <?php echo $usuarioExistente ?>

    <form action="registro.php" method="POST">
        <label>Email<input type="text" name="email" id=""></label>
        <span class="error"><?php echo $emailErr; ?></span><br>

        <label>Password<input type="text" name="pass1" id=""></label><br>
        <label>Repite Password<input type="text" name="pass2" id=""></label>
        <small>Una mayuscula, una minúscula y un numero y longitud mayort que 8</small>
        <span class="error"><?php echo $passErr; ?></span><br>

        <label>Nombre<input type="text" name="nombre" id=""></label>
        <span class="error"><?php echo $nombreErr; ?></span><br>

        <label>Apellidos<input type="text" name="apellidos" id=""></label>
        <span class="error"><?php echo $apellidosErr; ?></span><br>

        <label>direccion<input type="text" name="direccion" id=""></label>
        <span class="error"><?php echo $direccionErr; ?></span><br>
        <input type="submit" value="ENVIAR" name="enviar">

    </form>
</body>

</html>