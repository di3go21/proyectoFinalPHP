<?php 
    include "./autenticacion/controlPaginasPrivadas.php";
    include "./bbdd/peticiones.php";
    include "./bbdd/conexion.php";

    $con = getConexion();
     $carrito=getCarritoDeUsuario($con,$_SESSION['id']);
    $precioTotal=0;


    ?>



    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  crossorigin="anonymous"></script>
        <script>
        onload=()=>{
            $("#confimacionCompra").click(avisaCompra);
        }
        function avisaCompra(evento) {
            evento.preventDefault(); 
            alert("Para realizar la compra vuelve a pulsar en el link 'COMPRA TUS PRODUCTOS'");
            $(evento.target).attr("href","compra.php");
            $(evento.target).off();
            
        }
        </script>
        
    </head>
    <body>

    
<?php include "./includes/menu.php" ?>
        
<?php



if(!empty($carrito)){
    echo "<p>Tu Carrito es:</p>";

    echo "<form method='POST' action='eliminaCarrito.php'>";
    echo "<table>";
    
   echo "<tr>";
    foreach ($carrito[0] as $key => $value) {
        if($key!="id")
           echo "<th>$key</th>";
    }
    echo "<th>Precio<th>";
    echo "<th>Eliminar<th>";
    echo "</tr>";

    foreach ($carrito as $key => $value) {
        echo "<tr>";
        $precioUnitario=damePrecioDeProducto($con,$value['id']);
        $precio=($precioUnitario*$value['cantidad']);
        $precioTotal+=$precio;
        foreach ($value as $campo => $valor) {
            
            if($campo!="id")
          echo "<td>$valor</td>";
       
        }
        echo "<td>$precio</td>";
        echo "<td><input type='checkbox' name='prodsAEliminar[]' value='".$value['id']."'></td>";
        
        echo "</tr>";
} 
echo "<tr><td></td><td><b>TOTAL</b></td><td>$precioTotal</td><td></td></tr>";
    
    echo "</table>
        <input type='submit' value='Eliminar Seleccionados' name='eliminaProductos'>
    </form>";


    echo "<a id='confimacionCompra' href='#'> COMPRA TUS PRODUCTOS </a>";
 }else{
     echo "<p>Tu carrito está vacío</p>";
 }


?>

    </body>
    </html>
  

