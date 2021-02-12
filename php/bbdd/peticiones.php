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
        $e->getMessage();
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

function unidadesMaximas($con,$idProducto){
    $query="SELECT unidadesDisponibles FROM `producto` WHERE id=?";
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


function insertaProductoACarritoDeUsuario($con,$carrito,$idUsuario,$idProducto,$cantidad)
{
    $posicionDeArticulo = array_search($idProducto, array_column($carrito, 'id'));
    $err="";
    
    if(is_numeric($posicionDeArticulo)){//ya está en el carrito, UPDATE EN EL CARRITO

        $cantidadMaximaProducto=unidadesMaximas($con,$idProducto);
        $cantidadActualEnCarrito=$carrito[$posicionDeArticulo]['cantidad'];

        if(($cantidadActualEnCarrito+$cantidad)>$cantidadMaximaProducto){
            $cantidad = $cantidadMaximaProducto-$cantidadActualEnCarrito;
        }

        ////////////HAY QUE ASEGURARSE DE QUE NO SUPERA EL MÁXIMO
        //////////////////
        //////////////////
        $query="UPDATE carrito_usuario
         SET cantidad = cantidad + ?
          WHERE carrito_usuario.xUsuario = ? 
          AND carrito_usuario.xProducto = ?";
        
    }else{ // no está en el carrito, HACEMOS INSERT INTO
        $query="INSERT INTO carrito_usuario (cantidad,xUsuario, xProducto ) VALUES (?,?,?)";
    }

    try {
        $st = $con->prepare($query);
        $st->execute([$cantidad,$idUsuario,$idProducto]);
        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return false;
}
function dameDatosProducto($id){

}