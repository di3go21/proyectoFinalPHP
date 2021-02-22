<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$con= getConexion();
$error=[];
$id=sanear('id');
$producto=dameDatosProducto($con,$id);
$categoriasDeProducto=dameCategoriasDeProducto($con,$id);
$categorias=dameCategorias();
if(empty($producto)){
    header("location: admproductos.php");
    exit;
}


if(isset($_POST['enviar'])){

    $nombre=sanear("nombre");
    $existe="";
    if($nombre!=$producto['nombre']){
        $existe=existeProducto($con,$nombre);
    }

    
    $desc=sanear("desc");
    $precio=sanear("precio");
    $unidades=sanear("unidades");
    $nombre=sanear("nombre");

    //validacion categorias
    if(isset($_POST["categorias"]) && !empty($_POST["categorias"])){
        $categoriasRec=$_POST["categorias"];
        $categoriasValidas=true;    
        foreach ($categoriasRec as $key => $value) {
            if(!in_array($value,$categorias))
                $categoriasValidas=false;
        }
        if(!$categoriasValidas)
            $error[]="Alguna categoría no es válida";
    }else{
        $error[]="Debes seleccionar alguna categoría categorías";
    }

    //validacion nombre

    if(empty($nombre))
        $error[]="El campo nombre es obligatorio";
    elseif($existe=="1")
        $error[]="Un producto con ese nombre ya existe";
    elseif(!preg_match("/^[a-zA-ZñÑçÇáéúíóÁÉÍÓÚÜü 0-9]{5,25}$/",$nombre)){
        $error[]="Formato de nombre inválido";
    }

     if(empty($desc))
        $error[]="El campo descripción es obligatorio";
    elseif(!preg_match("/^[a-zA-ZñÑçÇáéúíóÁÉÍÓÚÜü 0-9\-\/,.;\\\!?¿¿'<>\"&%\$&%()=\n\r]{10,1000}$/",$desc)){
        $error[]="Formato de descripción inválido";
    }
      
    if(empty($precio)){
        $error[]="El precio es obligatorio";
    }elseif(!preg_match("/^[0-9]{1,5}[,.]{1}[0-9]{2}$/",$precio)){
        $error[]="El precio debe ser un número con dos decimales como máximo por ejemplo 100.00";        
    }else{
        $precio=str_replace(",",".",$precio);
    }
    
    if(empty($unidades)){
        $error[]="Debes especificar las unidades disponibles";
    }elseif(!is_int(intval($unidades)) && intval($unidades)<0){
        
        $error[]=" $unidades Las unidades disponilbes deben ser un número entero positivo";        
    }

    if(empty($error)){//subimos fichero


        if(is_uploaded_file($_FILES['foto']['tmp_name']) ){                   
                $directorio="./public/img";
                
                    $nombreFichero=$_FILES['foto']['name'];
                    $nombreCompleto=$directorio."/".$nombreFichero;
                        if(is_file($nombreCompleto)){
                            $idUnico=time();
                            $nombreFichero=$idUnico.$nombreFichero;
                            $nombreCompleto=$directorio."/".$nombreFichero;
                        }
                        if(move_uploaded_file($_FILES['foto']['tmp_name'],$nombreCompleto)){

                            if(!actualizaProducto($con,$id,$nombre,$desc,$precio,$unidades,$nombreFichero)){
                                $error[]="No se ha podido actualizar el producto";
                            }
                            else{

                                actualizaCategoriasDeProducto($con,$id,$nombre,$categoriasRec);


                                header("location: admeditarProducto.php?editar=ok");
                                exit;
                            }



                        }else{
                            $error[]="No se pudo mover el fichero de forma correcta";
                        }
 
        }else{
            if(!actualizaProducto($con,$id,$nombre,$desc,$precio,$unidades,$producto['imagen'])){
            $error[]="No se ha podido actualizar el producto";
            }
            else{
                actualizaCategoriasDeProducto($con,$id,$nombre,$categoriasRec);


                header("location: admeditarProducto.php?editar=ok");
                exit;
            }
            }

               



    }


}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php include "./includes/menu.php"; ?>

<form action="admeditarProducto.php" method="POST" enctype="multipart/form-data">

    <?php
    if(!empty($error))
        foreach ($error as $key => $value) {
            echo "<p>$value</p>";
        }
    ?>
    <input type="hidden" name="id" value="<?=$id?>">
    <p><label>Nombre: <input type="text" value="<?= $producto['nombre']?>" name="nombre" id=""></label></p>
    <p><label>Descripción: </label></p>
    <textarea name="desc" id="" cols="30" rows="10"><?= $producto['descripcion']?></textarea>
    <p><label>Precio: <input type="text" value="<?= $producto['precio']?>" name="precio" placeholder="100.00" id=""></label></p>
    <p><label>Unidades disponibles <input type="text" value="<?= $producto['unidadesDisponibles']?>" name="unidades" id=""></label></p>
    <p><label>Foto <input type="file" name="foto" id=""></label></p>
    <span>Categoría: </span>
        <?php
            foreach ($categorias as $key => $value) {
                if(in_array($value,$categoriasDeProducto)){
                    echo "<label><input name='categorias[]' checked type='checkbox' value='$value' >$value</label>";
                }
                else
                    echo "<label><input name='categorias[]' type='checkbox' value='$value' >$value</label>";
            }
        ?>

    </select>


    <input type="submit" value="Enviar" name="enviar">

</form>
    
</body>
</html>