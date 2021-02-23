<?php
include "./autenticacion/controlPaginasPrivadas.php";
include "./autenticacion/controlAdmin.php";
include "./bbdd/conexion.php";
include "./bbdd/peticiones.php";
include "./includes/sanear.php";

$con = getConexion();
$usuarios = dameUsuariosParaAdministrar($con);
$nombreErr = $apellidosErr = $emailErr = $direccionErr = $passErr = "";
$eNombre = $eApellidos = $eEmail = $eDireccion = $mensajeEdicion = "";
$usuarioExistente = "";
if (isset($_POST['enviar']) || isset($_POST['confirmaEditar'])) {
    $nombre = sanear("nombre");
    $email = sanear("email");
    $pass1 = sanear("pass1");
    $pass2 = sanear("pass2");
    $apellidos = sanear("apellidos");
    $direccion = sanear("direccion");


    $todosLosCamposSonValidos = true;

    include "./includes/validaciones.php";

    if ($nombre == "") {
        $nombreErr = "El nombre es obligatorio";
        $todosLosCamposSonValidos = false;
    } else {
        if (!esNombreOApellidoValido($nombre)) {
            $nombreErr = "El nombre es inválido";
            $todosLosCamposSonValidos = false;
        }
    }

    if ($apellidos == "") {
        $apellidosErr = "Los apellidos son obligatorios";
        $todosLosCamposSonValidos = false;
    } else {
        if (!esNombreOApellidoValido($apellidos)) {
            $apellidosErr = "Los apellidos son inválidos";
            $todosLosCamposSonValidos = false;
        }
    }

    if ($email == "") {
        $emailErr = "El email es obligatorio";
        $todosLosCamposSonValidos = false;
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "El email es inválido";
            $todosLosCamposSonValidos = false;
        }
    }

    if ($direccion == "") {
        $direccionErr = "La dirección es obligatoria";
        $todosLosCamposSonValidos = false;
    } else {
        if (!esDireccionValida($direccion)) {
            $direccionErr = "La dirección es inválida";
            $todosLosCamposSonValidos = false;
        }
    }

    if ($direccion == "") {
        $direccionErr = "La dirección es obligatoria";
        $todosLosCamposSonValidos = false;
    } else {
        if (!esDireccionValida($direccion)) {
            $direccionErr = "La dirección es inválida";
            $todosLosCamposSonValidos = false;
        }
    }

    if ($pass1 == "" || $pass2 == "") {
        $passErr = "Rellena ambos campos de contraseña";
        $todosLosCamposSonValidos = false;
    } else if ($pass1 != $pass2) {
        $passErr = "Las contraseñas no coinciden";
        $todosLosCamposSonValidos = false;
    } else {
        if (strlen($pass1) < 8) {
            $passErr = "Tu contraseña tiene que ser al menos de 8 caracteres!";
            $todosLosCamposSonValidos = false;
        } elseif (!preg_match("#[0-9]+#", $pass1)) {
            $passErr = "Tu contraseña tiene que contener al menos un número!";
            $todosLosCamposSonValidos = false;
        } elseif (!preg_match("#[A-Z]+#", $pass1)) {
            $passErr = "Tu contraseña tiene que contener al menos una mayúscula!";
            $todosLosCamposSonValidos = false;
        } elseif (!preg_match("#[a-z]+#", $pass1)) {
            $passwpassErrordErr = "Tu contraseña tiene que contener al menos una minúscula!";
            $todosLosCamposSonValidos = false;
        }
    }

    if ($todosLosCamposSonValidos) {
        $fechaRegistro = date("Y-m-d");


        $pass1 = md5($pass1);
        try {
            if (isset($_POST['enviar'])) {
                $st = $con->prepare("INSERT into USUARIO
                 (nombre,apellidos,password,direccion,email,fechaRegistro) values 
                (?,?,?,?,?,?)");
                $st->execute([$nombre, $apellidos, $pass1, $direccion, $email, $fechaRegistro]);
                $rs = $con->prepare("INSERT into alta
                        (email,nombre,apellidos,fechaRegistro,hora) values 
                    (?,?,?,?,?) ");
                $rs->execute([$email, $nombre, $apellidos, $fechaRegistro, date("H:i:s")]);
                $st = "";
                $con = "";

                header("location: admusuarios.php");
                exit;
            } else {
                actualizaDatosUsuario($con, $email, $pass1, $nombre, $apellidos, $direccion);

                header("location: admusuarios.php");
                exit;
            }
        } catch (PDOException $e) {
            echo $error = $e->getMessage();
            $pos = strpos($error, "Duplicate entry");
            if ($pos !== false)
                $usuarioExistente = "<p>la cuenta con ese usuario ya existe, <a href='login.php?usuario=$email'>pulse aquí</a> para entrar con sus credenciales<p>";
        }
    } else {
        $mensajeEdicion = "No se ha podido realizar la edición, revise todos los campos";
    }
} elseif (isset($_GET['editar'])) {
    $emailParaEditar = dameCampoUsuario($con, "email", $_GET['editar']);
    $usuarioAEditar = dameUsuario($con, $emailParaEditar);
    if (!empty($usuarioAEditar)) {
        $eNombre = $usuarioAEditar['nombre'];
        $eApellidos = $usuarioAEditar['apellidos'];
        $eEmail = $usuarioAEditar['email'];
        $eDireccion = $usuarioAEditar['direccion'];
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>Adm-Usuarios</title>
</head>

<body>

    <?php include "./includes/menu.php" ?>
    <br><br>

    <div class="container">


        <h1>Administración usuarios</h1><br>

        <a class='btn btn-secondary' href="admusuarios.php?crear=1">insertar Nuevo Usuario</a>

        <?php echo "<p>$mensajeEdicion</p>" ?>

        <?php if (isset($_GET['crear']) && $_GET['crear'] == "1" || isset($_POST['enviar'])   || isset($_GET['editar'])) {
        ?>


            <?php echo $usuarioExistente ?>
            <form action="admusuarios.php" method="POST">
                <?php if (isset($_GET['editar'])) { ?>
                    <label>Email: <input value="<?= $eEmail ?>" type="text" name="" id="" disabled></label>
                   <input value="<?= $eEmail ?>" type="text" name="email" id="" hidden>
                <?php  } else { ?>
                    <label>Email: <input value="<?= $eEmail ?>" type="text" name="email" id=""></label>
                <?php   } ?>
                <span class="error"><?php echo $emailErr; ?></span><br>

                <label><?php if (isset($_GET['editar'])) echo "Nueva ";?>Password: <input type="text" name="pass1" id=""></label><br>
                <label>Repite Password: <input type="text" name="pass2" id=""></label><br>
                <small>Una mayuscula, una minúscula y un numero y longitud mayor que 8</small>
                <span class="error"><?php echo $passErr; ?></span><br>

                <label>Nombre: <input value="<?= $eNombre ?>" type="text" name="nombre" id=""></label>
                <span class="error"><?php echo $nombreErr; ?></span><br>

                <label>Apellidos: <input value="<?= $eApellidos ?>" type="text" name="apellidos" id=""></label>
                <span class="error"><?php echo $apellidosErr; ?></span><br>

                <label>Dirección: <input value="<?= $eDireccion ?>" type="text" name="direccion" id=""></label>
                <?php if (isset($_GET['editar']))
                    echo "<input type='submit' value='Insertar' name='confirmaEditar'>";
                else

                    echo "<input type='submit' value='Insertar' name='enviar'>"; ?>
            </form>

        <?php
        }; ?>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Direccion</th>
                <th>Fecha de registro</th>
                <th>Accion</th>
            </tr>
            <?php
            foreach ($usuarios as  $usuario) {

                echo "<tr>";
                foreach ($usuario as $prop) {

                    echo "<td>$prop</td>";
                }

                echo "<td><a class='btn btn-danger' href='admconfirmareliminar.php?eliminar=" . $usuario['id'] . "'>Eliminar</a></td>";
                echo "<td><a class='btn btn-warning' href='admusuarios.php?editar=" . $usuario['id'] . "'>Editar</a></td>";

                echo "</tr>";
            }
            ?>

        </table>


    </div>

</body>

</html>