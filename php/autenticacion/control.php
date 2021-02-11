<?php
//header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
session_start();

//$datos['autenticado']="NO";

if(isset($_SESSION['autenticado']) && $_SESSION['autenticado']=="usuarioAutenticado"){
    $datos['autenticado']="SI";
    //return json_encode($datos);    
}else{
    //return  json_encode($datos);
}
echo json_encode($datos);

?>