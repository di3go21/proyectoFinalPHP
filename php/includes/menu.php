
<ul>
    <li><a href="/php/aplicacion.php">Inicio</a></li>
    <li><a href="/php/productos.php">Productos</a></li>
    <?php 
        if(isset($_SESSION) && isset($_SESSION['esAdmin']) && $_SESSION['esAdmin']=="SI" ){
            echo "<li><a href='/php/areaAdmin.php'>Area de administracion</a></li>";
        }
        if(isset($_SESSION) && isset($_SESSION['id'])  ){
            echo "<li><a href='/php/areaPersonal.php'>Area personal</a></li>";
            echo "<li><a href='/php/carrito.php'>Carrito</a></li>";
            echo "<li><a href='/php/logout.php'>Salir</a></li>";
        }else{
            echo "<li><a href='/php/login.php'>Entra</a></li>";
            echo "<li><a href='/php/registro.php'>Registrate</a></li>";
        }
    ?>
    
    
    
</ul>