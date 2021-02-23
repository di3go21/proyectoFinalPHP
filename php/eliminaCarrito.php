<?php

include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/peticiones.php";
include "./bbdd/conexion.php";

echo "<pre>";
print_r($_SESSION);

if(isset($_POST['eliminaProductos'])){
    $con=getConexion();
    if(isset($_POST['prodsAEliminar']) && is_array($_POST['prodsAEliminar'])){
        
        $idsAEliminar=$_POST['prodsAEliminar'];
        foreach ($idsAEliminar as $key => $id) {
           eliminaDeCarrito($con,$id,$_SESSION['id']);
        }
    }
}

 header("location: carrito.php");

?>








