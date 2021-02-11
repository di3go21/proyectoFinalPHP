<?php
session_start();
if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado']!="usuarioAutenticado"){
    echo json_encode($datos);
}
?>