<?php
include "./autenticacion/controlLogin.php";
include "./includes/sanear.php";

$usuario = "";
$mensaje=$error = "";


if (isset($_GET['usuario'])){
    $usuario=sanear('usuario');
}
if (isset($_GET['registrado'])){
    $usuario=sanear('registrado');
    $mensaje="¡Enhorabuena ya estás registrado! ingresa tu contraseña para entrar!";
}

if(isset($_POST['enviar'])){
    $usuario=sanear('email');
    $pass=sanear('pass');
    $camposValidos=true;

    if($usuario==""|| $pass==""){
        $camposValidos=false;
        $error="debe rellenar ambos campos";
    }else if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
                $error = "El email es inválido";
                $camposValidos = false;
    }else{

        include "./bbdd/conexion.php";
        include "./bbdd/peticiones.php";

            $con = getConexion();
            
            $rs = logIn($con,$usuario,$pass);
            if($rs==1){

                //LOGUEAR Y REDIRIGIR A APPLICACION
                $_SESSION["autenticado"]="SI";
                $_SESSION["email_usuario_autenticado"]=$usuario;

                


                header("location:aplicacion.php");
                exit;
            }else{
                $error="Credenciales incorrectas";
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

<?php include "./includes/menu.php" ?>



<h1>login</h1>
<p><?=$mensaje?></p>

<form action="" method="POST"><br><br>


<label>Email: <input type="text" name="email" id="" value= "<?php echo $usuario ?>" ></label><br><br>
<label>Pass: <input type="text" name="pass" id=""></label>
<p style="color:red"><?php echo $error ?> </p>
<!-- <p><a href="recuperarPass.php">olvidé mi contraseña</a></p> -->
<input type="submit" value="Entrar" name="enviar">
</form>
    
</body>
</html>