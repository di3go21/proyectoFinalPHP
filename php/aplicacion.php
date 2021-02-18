<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";
//session_start();
$email = $_SESSION["email_usuario_autenticado"];
try {
    $con = getConexion();
    $st = $con->prepare("select id,email,nombre,apellidos,direccion,fechaRegistro,esAdmin,puedeRealizarInformes  from usuario where email=?");
    $st->execute([$email]);
    $rs = $st->fetchAll(PDO::FETCH_ASSOC); //devuelve el numero del count consultado
   

    foreach ($rs[0] as $key => $value) {
        $_SESSION[$key] = $value;
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
}



$productos = [];
$productos = dameProductosDisponibles($con);
$numero_de_productos=count($productos);
$num_prod_por_pagina=2;
$numero_de_paginas=ceil($numero_de_productos/$num_prod_por_pagina);

if(isset($_GET['pagina'])){

    $pagina=sanear('pagina');
    if(!is_numeric($pagina) || $pagina<0 || $pagina>$numero_de_paginas){
        $pagina=1;
    }
}
else
    $pagina=1;
    
$offset=(($pagina-1)*$num_prod_por_pagina);

$productos=damePaginados($con,$offset,2);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    
<?php include "./includes/menu.php" ?>

    <h1>bienvenido a la app</h1>

    <?php echo "<pre>".print_r($_SESSION)."</pre>";  ?>



    <p>PRODUCTOS</p>

    <?php
    echo "<table>";
    echo "<tr>";
    foreach ($productos[0] as $key => $value) {
        if ($key != "id" && $key != "descripcion" )
            echo "<th>$key</th>";
    }
    echo "</tr>";
    foreach ($productos as $key => $producto) {
        echo "<tr>";

        foreach ($producto as $campo => $valor) {
            
            if ($campo != "id" && $campo != "descripcion" ){

                echo "<td>";
                if($campo=="imagen")
                    echo "<img src='./public/img/$valor' height='120px'>";
                elseif($campo=="nombre")
                    echo "<a href='producto.php?id=".$producto['id']."'>$valor</a>";
                else
                    echo $valor;
            }               
        }
        
        echo "<form action='insertaCarrito.php' method='POST'> ";
        echo "<input type='hidden' name='cantidad' value='1'> ";
        echo "<input type='hidden' name='idProducto' value='".$producto['id']."'> ";
        echo "<input type='submit' name='insertaACarrito' value='Añade al carrito'>";
        echo "</form> ";

        echo "</tr>";
    }

    echo "</table>";
    ?>

<ul class="pagination">
    <li><a href="?pagina=1">First</a></li>
    <li class="<?php if($pagina <= 1){ echo 'disabled'; } ?>">
        <a href="<?php if($pagina <= 1){ echo '#'; } else { echo "?pagina=".($pagina - 1); } ?>">Prev</a>
    </li>
    <li class="<?php if($pagina >= $numero_de_paginas){ echo 'disabled'; } ?>">
        <a href="<?php if($pagina >= $numero_de_paginas){ echo '#'; } else { echo "?pagina=".($pagina + 1); } ?>">Next</a>
    </li>
    <li><a href="?pagina=<?php echo $numero_de_paginas; ?>">Last</a></li>
</ul>
    

</body>

</html>