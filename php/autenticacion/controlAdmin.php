<?php
if($_SESSION['esAdmin']=="NO"){
    header("location: ./aplicacion.php ");
    exit;
}
?>