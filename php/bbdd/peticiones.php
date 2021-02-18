<?php

function dameProductosDisponibles($con)
{
    $query = "select * from producto where unidadesDisponibles>0";

    try {
        $st = $con->query($query);
        $st->execute();
        $rs = $st->fetchAll(PDO::FETCH_ASSOC);
        return $rs;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return [];
}


function dameProductosConQuery($con,$cadena){

    $query = 'SELECT * from producto where unidadesDisponibles>0 and ( nombre like ? or descripcion like ? )';
    
    
    try {
        $st = $con->prepare($query);
        $st->execute(["%$cadena%","%$cadena%"]);
        $rs = $st->fetchAll(PDO::FETCH_ASSOC);
        return $rs;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return [];
}


function dameProductosDeCategoria($con,$cat){
    $query = 'SELECT P.*
     from producto P , categoria C , producto_categoria PC
     where unidadesDisponibles>0
      and P.id = PC.xProducto
      and PC.xCategoria = C.id
      and C.nombre = ? ';
    
    try {
        $st = $con->prepare($query);
        $st->execute([$cat]);
        $rs = $st->fetchAll(PDO::FETCH_ASSOC);
        return $rs;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return [];
}







function logIn($con,$usuario,$pass){
    try{
        
        $st=$con->prepare("select count(*)  from usuario where email=? and password=?");
        $st->execute([$usuario,md5($pass)]);
        $rs = $st->fetch(PDO::FETCH_COLUMN);//devuelve el numero del count consultado
        return $rs;

    }catch(PDOException $e){
        $error=$e->getMessage();          
    }
}


function actualizaVariablesEnSession($con,$email){
    try {
        $con = getConexion();
        $st = $con->prepare("select id,email,nombre,apellidos,direccion,fechaRegistro,esAdmin,puedeRealizarInformes  from usuario where email=?");
        $st->execute([$email]);
        $rs = $st->fetchAll(PDO::FETCH_ASSOC); //devuelve el numero del count consultado
       
            foreach ($rs[0] as $key => $value) {
            $_SESSION[$key] = $value;
        }
    } catch (PDOException $e) {
       echo $e->getMessage();
    }

}

function damePaginados($con, $num, $productosPorPagina)
{
    $query = "select * from producto where unidadesDisponibles>0 LIMIT " . $num . " , $productosPorPagina";
    try {
        $st = $con->query($query);
        $st->execute();
        $rs = $st->fetchAll(PDO::FETCH_ASSOC);
        return $rs;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return [];
}
function dameProductosOrdenados($con, $campo, $orden, $categoria = "")
{
    $query = "SELECT DISTINCT  P.*
            from producto P, producto_categoria P_C , categoria C
            where
            C.id = P_C.xCategoria and
            P.id = P_C.xProducto and
            P.unidadesDisponibles>0 and C.nombre like ? ";

    $query .= "ORDER BY P.$campo $orden";

    try {
        $st = $con->prepare($query);
        $st->execute(["%" . $categoria . "%"]);

        $rs = $st->fetchAll(PDO::FETCH_ASSOC);
        return $rs;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return [];
}


function getCarritoDeUsuario($con, $idUsuario)
{

    try {
        $query = "SELECT carrito_usuario.cantidad, producto.nombre, producto.id
        FROM carrito_usuario , producto, usuario 
        WHERE carrito_usuario.xUsuario = usuario.id
        and producto.id = carrito_usuario.xProducto
        and usuario.id=?";
        $st = $con->prepare($query);
        $st->execute([$idUsuario]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function unidadesMaximas($con, $idProducto)
{
    $query = "SELECT unidadesDisponibles FROM `producto` WHERE id=?";
    try {
        $st = $con->prepare($query);
        $st->execute([$idProducto]);
        $rs = $st->fetch(PDO::FETCH_COLUMN);
        return $rs;
    } catch (Exception $e) {
        $e->getMessage();
    }
    return 0;
}


function insertaProductoACarritoDeUsuario($con, $carrito, $idUsuario, $idProducto, $cantidad)
{
    $posicionDeArticulo = array_search($idProducto, array_column($carrito, 'id'));
    $err = "";

    if (is_numeric($posicionDeArticulo)) { //ya está en el carrito, UPDATE EN EL CARRITO

        $cantidadMaximaProducto = unidadesMaximas($con, $idProducto);
        $cantidadActualEnCarrito = $carrito[$posicionDeArticulo]['cantidad'];

        if (($cantidadActualEnCarrito + $cantidad) > $cantidadMaximaProducto) {
            $cantidad = $cantidadMaximaProducto - $cantidadActualEnCarrito;
        }

        ////////////HAY QUE ASEGURARSE DE QUE NO SUPERA EL MÁXIMO
        //////////////////
        //////////////////
        $query = "UPDATE carrito_usuario
         SET cantidad = cantidad + ?
          WHERE carrito_usuario.xUsuario = ? 
          AND carrito_usuario.xProducto = ?";
    } else { // no está en el carrito, HACEMOS INSERT INTO
        $query = "INSERT INTO carrito_usuario (cantidad,xUsuario, xProducto ) VALUES (?,?,?)";
    }

    try {
        $st = $con->prepare($query);
        $st->execute([$cantidad, $idUsuario, $idProducto]);
        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return false;
}
function dameDatosProducto($con, $id)
{
    try {
        $query = "select * from producto where id = ?";
        $rs = $con->prepare($query);
        $rs->execute([$id]);
        $res = $rs->fetchAll(PDO::FETCH_ASSOC);
        return $res[0];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
function damePrecioDeProducto($con, $id)
{
    try {
        $query = "select precio from producto where id = ?";
        $st = $con->prepare($query);
        $st->execute([$id]);
        $rs = $st->fetch(PDO::FETCH_COLUMN);
        return $rs;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function eliminaDeCarrito(PDO $con, $idProd, $idUsuario)
{

    $query = "DELETE FROM carrito_usuario where xUsuario=? and xProducto=? ";

    try {
        $st = $con->prepare($query);
        return ($st->execute([$idUsuario, $idProd]));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function realizaVenta($con,$idVenta, $idUsuario, $carrito)
{
    $totalPrecioCarrito = damePrecioTotalCarrito($con, $carrito);
    
    $direccion = dameDireccionDeUsuario($con, $idUsuario);
    $query = "insert into Venta values (? ,? ,? , ? , ?)";
    $fecha = date("Y/m/d");
    try {
        $st = $con->prepare($query);
        return ($st->execute([$idVenta, $idUsuario, $totalPrecioCarrito, $direccion, $fecha]));
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
function dameDireccionDeUsuario($con, $idUsuario)
{
    try {
        $query = "select direccion from usuario where id = ?";
        $st = $con->prepare($query);
        $st->execute([$idUsuario]);
        $rs = $st->fetch(PDO::FETCH_COLUMN);
        return $rs;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function damePrecioTotalCarrito($con, $carrito)
{
    $totalPrecioCarrito = 0;
    foreach ($carrito as $key => $articulo) {
        $cantidad = $articulo['cantidad'];
        $precioUnidad = damePrecioDeProducto($con, $articulo['id']);
        $totalPrecioCarrito += ($cantidad * $precioUnidad);
    }
    return $totalPrecioCarrito;
}


function registraVentaArticulo($con,$idVenta,$carrito){
    $query1="INSERT INTO venta_articulo values ( ? , ? ,? ,? )";
    $query2="UPDATE producto SET unidadesDisponibles =unidadesDisponibles- ? WHERE id = ?";
    foreach ($carrito as $key => $articulo) {
        $precio=damePrecioDeProducto($con,$articulo['id']);
        try {
            $st = $con->prepare($query1);
            $st->execute([$idVenta,$articulo['id'],$articulo['cantidad'],$precio]);
            
            $st = $con->prepare($query2);
            $st->execute([$articulo['cantidad'],$articulo['id']]);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

function vaciarCarrito(PDO $con,$idUsuario){
    $query="DELETE FROM carrito_usuario where xUsuario = ?";
   
        try {
            $st = $con->prepare($query);
            return $st->execute([$idUsuario]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    
}

function dameVenta($con,$idVenta){
    $venta=[];
    try {
        $query = "select * from venta where id = ?";
        $rs = $con->prepare($query);
        $rs->execute([$idVenta]);
        $venta = $rs->fetch(PDO::FETCH_ASSOC);
        return $venta;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }


}
function dameArticulosVenta($con,$idVenta){
    $articulos=[];
    try {
        $query = "select P.nombre , VA.xProducto, VA.cantidad, VA.precio
        from venta_articulo VA, producto P        
        where P.id = VA.xProducto        
        and xVenta = ?";
        $rs = $con->prepare($query);
        $rs->execute([$idVenta]);
        $articulos = $rs->fetchAll(PDO::FETCH_ASSOC);
        return $articulos;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function dameVentas(PDO $con,$idUser){

    $ventas=[];
    try {
        $query = "select id from venta where xUsuario = ? ";
        $rs = $con->prepare($query);
        $rs->execute([$idUser]);
        $idsVentas = $rs->fetchAll(PDO::FETCH_ASSOC);
        foreach ($idsVentas as $key => $value) {
            $venta=dameVenta($con,$value['id']);
            $articulosVenta=dameArticulosVenta($con,$value['id']);
            $venta['articulos']=$articulosVenta;
            array_push($ventas,$venta);

        }
        return $ventas;

    } catch (PDOException $e) {
        echo $e->getMessage();
    }    

}

function actualizaDatosUsuario($con,$email,$pass1,$nombre,$apellidos,$direccion){
    $query="UPDATE  usuario
     set password = ? , nombre= ?, apellidos = ? , direccion = ? 
     where email=?";
    
    try {
        $st = $con->prepare($query);
        $rs=$st->execute([md5($pass1),$nombre,$apellidos,$direccion,$email]);
       return $rs;

    } catch (PDOException $e) {
        echo $e->getMessage();
    }  
}

function dameCategorias(){ 
    $categ=[];
    $con=getConexion();
    try {
        $query = "select nombre from categoria";
        $rs = $con->query($query);
        $categ = $rs->fetchAll(PDO::FETCH_COLUMN);
       
        return $categ;

    } catch (PDOException $e) {
        echo $e->getMessage();
    }    
}

?>