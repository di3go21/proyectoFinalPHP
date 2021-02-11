<?php
session_start();
if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado']!="SI"){
    header("location: /index.html");
    exit;
}
?>