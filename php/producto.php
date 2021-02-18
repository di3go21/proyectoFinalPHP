<?php
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
$producto=[];
    if(isset($_GET["id"])){
        $id=$_GET["id"];
        $con = getConexion();
        $producto=dameDatosProducto($con,$id);
    }else{
        header("location: aplicacion.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>producto individual</title>
</head>
<script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  crossorigin="anonymous"></script>
<script>
    var precio=<?php echo $producto['precio'] ?>;
    onload=()=>{
        $("input[type=number]").on("change",actualiza);
    }
    function actualiza(evento){
        var $cantidad=$("input[type=number]").val();

        $("span").text(($cantidad*(precio*100))/100);
    }
</script>
<body>
    
    
<pre>
    <?php print_r($producto);?>
</pre>



este es el producto:

<?php

    echo "<p>nombre: ".$producto['nombre']."</p>";
    echo "<p>precio: ".$producto['precio']."</p>";
    echo "<p>descripcion: ".$producto['descripcion']."</p>";
    echo "<p>imagen: <img height='150px' src='./public/img/".$producto['imagen']."'></p>";
    echo "<p>Unidades disponibles: ".$producto['unidadesDisponibles']."</p>";

    if($producto['unidadesDisponibles']>1){
?>

<form action="insertaCarrito.php" method="POST">
    <input type="hidden" name="idProducto" value="<?php echo $producto['id'] ?>">
    cantidad: <input type="number" name="cantidad" min="1" max="<?php echo $producto['unidadesDisponibles']?>" id=""><br>
    precio: <span></span>  <br>
    <input type="submit" value="Al carrito" name="insertaACarrito">
</form>
<?php } ?>
</body>
</html>