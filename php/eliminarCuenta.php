<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/peticiones.php";
include "./bbdd/conexion.php";
include "./includes/validaciones.php";
include "./includes/sanear.php";
$mensaje="";
$con=getConexion();
if(isset($_GET['confirmacion']) && $_GET['confirmacion']=="si"){
    
    
    if(insertaBaja($con,$_SESSION['email'])){
        vaciarCarrito($con,$_SESSION['email']);
        if(borraUsuario($con,$_SESSION['email'])){
             //cierra sesion
            session_unset();

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
            header("location: confirmacionEliminado.php");
            exit;
        }else{
            $mensaje= "error al intentar el borrado";
        }      
    }else{
        $mensaje= "error al intentar el borrado";
    }

   








}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
</head>
<body>


<?php include "./includes/menu.php"; ?>
    
<h1>Está seguro de que desea Eliminar su cuenta?</h1>
<a href="eliminarCuenta.php?confirmacion=si">SI</a>
<a href="areaPersonal.php">NO</a>
<a href="areaPersonal.php">volver</a>
<?php if ($mensaje!="") echo "<h5>$mensaje</h5>";?>
</body>
</html>