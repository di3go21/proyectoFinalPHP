<?php
include "./includes/sanear.php";

$usuario = "";
$error = "";


if (isset($_GET['usuario'])){
    $usuario=sanear('usuario');
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
        try{
            $con = getConexion();
            $st=$con->prepare("select count(*)  from usuario where email=? and password=?");
            $st->execute([$usuario,md5($pass)]);
            $rs = $st->fetch(PDO::FETCH_COLUMN);//devuelve el numero del count consultado
            if($rs==1){

                //LOGUEAR Y REDIRIGIR A APPLICACION
                

                session_start();
                $_SESSION["autenticado"]="SI";
                $_SESSION["email_usuario_autenticado"]=$usuario;
                header("location:aplicacion.php");
                exit;
            }else{
                $error="Credenciales incorrectas";
            }

        }catch(PDOException $e){
            $error=$e->getMessage();          
        }




    }
        

    
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
Logueate


<form action="" method="POST"><br><br>

<label>Email: <input type="text" name="email" id="" value= "<?php echo $usuario ?>" ></label><br><br>
<label>Pass: <input type="text" name="pass" id=""></label>
<p style="color:red"><?php echo $error ?> </p>
<p><a href="recuperarPass.php">olvidé mi contraseña</a></p>
<input type="submit" value="Entrar" name="enviar">
</form>
    
</body>
</html>