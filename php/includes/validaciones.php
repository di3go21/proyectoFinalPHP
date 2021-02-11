<?php

function esNombreOApellidoValido($var){
    $var=preg_replace("/\s+/", " ", $var);
    if($var!="" && preg_match("/^[a-zA-Z\-üÜáéúíóçÇÁÉÚÍÓÑñ ]{3,30}$/",$var)){
        return true;
    }
    return false;
}


function esDireccionValida($var){
    $var=preg_replace("/\s+/", " ", $var);
    if($var!="" && preg_match("/^[a-zA-Z\-üÜáéúíóçÇÁÉÚÍÓÑñ´ :º\/\\\'\"ª0-9,:]{10,150}$/",$var)){
        return true;
    }
    return false;
}



//$loco = preg_split('/ +/', $prueba, null, PREG_SPLIT_NO_EMPTY); esto es pora conseguir un array solo con palabras


?>