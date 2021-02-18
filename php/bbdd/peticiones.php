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
    $query="INSERT INTO venta_articulo values ( ? , ? ,? ,? )";
    foreach ($carrito as $key => $articulo) {
        $precio=damePrecioDeProducto($con,$articulo['id']);
        try {
            $st = $con->prepare($query);
            $st->execute([$idVenta,$articulo['id'],$articulo['cantidad'],$precio]);
            
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
        $query = "select producto, cantidad, precio from venta_articulo where xVenta = ?";
        $rs = $con->prepare($query);
        $rs->execute([$idVenta]);
        $venta = $rs->fetchAll(PDO::FETCH_ASSOC);
        return $venta;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>