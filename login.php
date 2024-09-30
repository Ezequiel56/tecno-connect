<?php

    function mostrarSiExiste($indice){
        // UTILIZADO EN LA PROPIEDAD "VALUE" DE LOS FORMULARIOS
        if(isset($_POST[$indice])){

            echo $_POST[$indice];

        }

    }

    require_once "app/modelo/conexion.php";

    session_start();

?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Tecno Connect</title>
        
        <link rel="stylesheet" href="logestilos.css">

    </head>
    <body>

        <header>

            <a href="index.php">Tecno Connect</a>

            <a href="login.php">Login</a>

            <a href="registro.php">Registro</a>

        </header>

    <?php

    if(isset($_POST["btn_login"])){
        // BOTÓN DE LOGIN

        // Validar gmail (si existe o no)
        $usuario = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM t_usuarios WHERE gmail = '$_POST[gmail]'"));

        if(empty($usuario)){ $_SESSION["msj"] = "No existe una cuenta con esa dirección de correo electrónico"; }else{
            
            // Validar contraseña (si coincide con el gmail)
            if(!password_verify($_POST["clave"], $usuario["contrasena"])){ $_SESSION["msj"] = "Contraseña incorrecta"; }else{
                
                unset($_SESSION["msj"]); // Borro cualquier mensaje que pueda haber

                switch($usuario["id_rol"]){

                    case 15:

                        $_SESSION["id_usuario"] = $usuario["id_usuario"];

                        $_SESSION["id_rol"] = $usuario["id_rol"];

                        $_SESSION["id_tecnico"] = $usuario["id_usuario"];

                        $_SESSION["id_validacion"] = $usuario["id_validacion"];

                        $_SESSION["id_empresa"] = mysqli_fetch_array(mysqli_query($con, "SELECT id_empresa FROM t_empresas WHERE id_usuario = '$usuario[id_usuario]'"))["id_empresa"];

                        header("Location: app/vista/adm.php");

                        break;

                    case 14:

                        // Validar registro completo
                        $tecnico = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM t_tecnicos WHERE id_tecnico = '$usuario[id_usuario]'"));

                        if(empty($tecnico)){

                            // El registro del técnico está incompleto
                            $_SESSION["msj"] = "Para continuar, complete el registro";

                            $_SESSION["id_usuario"] = $usuario["id_usuario"];

                            $_SESSION["id_rol"] = $usuario["id_rol"];

                            header("Location: registro.php");

                        }else{

                            // El tecnico se logueó correctamente
                            $_SESSION["id_usuario"] = $usuario["id_usuario"];

                            $_SESSION["id_rol"] = $usuario["id_rol"];

                            $_SESSION["id_tecnico"] = $tecnico["id_tecnico"];

                            $_SESSION["id_empresa"] = false;

                            $_SESSION["id_validacion"] = $usuario["id_validacion"];

                            header("Location: app/vista/tec.php");

                        }

                        break;

                    case 13:

                        // Validar registro completo

                        $empresa = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM t_empresas WHERE id_usuario = '$usuario[id_usuario]'"));

                        if(empty($empresa)){

                            // El registro de la empresa está incompleto
                            $_SESSION["msj"] = "Para continuar, complete el registro";

                            $_SESSION["id_usuario"] = $usuario["id_usuario"];

                            $_SESSION["id_rol"] = $usuario["id_rol"];

                            header("Location: registro.php");

                        }else{

                            // Se logueó correctamente
                            $_SESSION["id_usuario"] = $usuario["id_usuario"];

                            $_SESSION["id_rol"] = $usuario["id_rol"];

                            $_SESSION["id_empresa"] = $empresa["id_empresa"];

                            $_SESSION["id_tecnico"] = false;

                            $_SESSION["id_validacion"] = $usuario["id_validacion"];

                            header("Location: app/vista/emp.php");

                        }

                        break;

                    default:

                        $_SESSION["msj"] = "Lo sentimos, algo salió mal :(";

                        break;

                }

            }

        }

    }
    ?>

        <form action="login.php" method="POST">

            <div class="contenedor">
        
                <div class="login">
                    <h1>Login</h1>

                    <?php

                    if(isset($_SESSION["msj"])){

                        echo $_SESSION["msj"] ."<br>";

                        unset($_SESSION["msj"]);
                        
                    }

                    ?>

                    <label for="gmail">

                        <span>Gmail (*)</span>

                        <input type="email" name="gmail" id="gmail" placeholder="usuario@ejemplo.com" value="<?php mostrarSiExiste("gmail"); ?>" autofocus required>

                    </label>

                    <label for="clave">

                        <span>Contraseña (*)</span>

                        <input type="password" name="clave" id="clave" required>

                    </label>

                    <button type="submit" name="btn_login">Iniciar sesión</button>
                </div>

                <div class="imagen">
                    <img src="imglog.jpg" alt="imagenprueba">
                </div>

            </div>

        </form>

    </body>

</html>