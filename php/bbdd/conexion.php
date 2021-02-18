<?php
function getConexion(){
    $servidor="localhost";
    $usuarioDB="programaphp";
    $passDB="programaphp";
    $db="tiendaguitarras2";
    try{
        $dsn="mysql:host=$servidor;dbname=$db;charset=utf8mb4";
        $instanciaCon=new PDO($dsn,$usuarioDB,$passDB);
        $instanciaCon->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $instanciaCon;
    }catch(PDOException $e){
        echo $e->getMessage();
        exit;
    }
}

?>