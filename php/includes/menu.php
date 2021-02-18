
<ul>
    <li><a href="/php/aplicacion.php">Inicio</a></li>
    <?php 
        if(isset($_SESSION) && $_SESSION['esAdmin']=="SI" ){
            echo "<li><a href='/php/areaAdmin.php'>Area de administracion</a></li>";
        }
    ?>
    <li><a href="/php/areaPersonal.php">Area personal</a></li>
    <li><a href="/php/carrito.php">Carrito</a></li>
    <li><a href="/php/logout.php">Salir</a></li>
    
</ul>