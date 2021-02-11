<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/conexion.php";
session_start();
$email=$_SESSION["email_usuario_autenticado"] ;
try{
    $con = getConexion();
    $st=$con->prepare("select id,email,nombre,apellidos,direccion,fechaRegistro  from usuario where email=?");
    $st->execute([$email]);
    $rs = $st->fetchAll(PDO::FETCH_ASSOC);//devuelve el numero del count consultado
   
    foreach ($rs[0] as $key => $value) {
        $_SESSION[$key]=$value;
    }

}catch(PDOException $e){
    $error=$e->getMessage();          
}

?>



<h1>bienvenido a la app</h1>

<p><a href="./logout.php">SALIR</a></p>

<?php echo "<pre>"; print_r($_SESSION);