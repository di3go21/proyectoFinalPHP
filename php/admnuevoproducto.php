<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";
$con=getConexion();
$error=[];

$categorias=dameCategorias();
if(isset($_POST['enviar'])){

    $nombre=sanear("nombre");
    $existe=existeProducto($con,$nombre);
    
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

                            if(!insertaNuevoProducto($con,$nombre,$desc,$precio,$unidades,$nombreFichero)){
                                $error[]="No se ha podido insertar el producto";
                            }
                            else{

                                guardaCategorias($con,$nombre,$categoriasRec);


                                header("location: admnuevoproducto.php?insertar=ok");
                                exit;
                            }



                        }else{
                            $error[]="No se pudo mover el fichero de forma correcta";
                        }
 
        }else{
            $error[]="No se ha subido ninguna foto";
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
<h1>Insertar nuevo Producto:</h1>

<?php if (isset($_GET['insertar']) && $_GET['insertar']=="ok")
        echo "<h3>¡Producto insertado correctamente!</h3>";
?>

<form action="admnuevoproducto.php" method="POST" enctype="multipart/form-data">

    <?php
    if(!empty($error))
        foreach ($error as $key => $value) {
            echo "<p>$value</p>";
        }
    ?>

    <p><label>Nombre: <input type="text" name="nombre" id=""></label></p>
    <p><label>Descripción: </label></p>
    <textarea name="desc" id="" cols="30" rows="10"></textarea>
    <p><label>Precio: <input type="text" name="precio" placeholder="100.00" id=""></label></p>
    <p><label>Unidades disponibles <input type="text" name="unidades" id=""></label></p>
    <p><label>Foto <input type="file" name="foto" id=""></label></p>
    <span>Categoría: </span>
        <?php
            foreach ($categorias as $key => $value) {
                echo "<label><input name='categorias[]' type='checkbox' value='$value' >$value</label>";
            }
        ?>

    </select>


    <input type="submit" value="Enviar" name="enviar">

</form>
    
</body>
</html>