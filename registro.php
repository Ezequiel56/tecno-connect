<?php

    function mostrarSiExiste($indice){

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

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

</head>

<body>

    <header>

        <a href="index.php">Tecno Connect</a>

        <a href="login.php">Login</a>

        <a href="registro.php">Registro</a>

    </header>

    <?php 
    // REGISTRAR - PASO 1
    if(isset($_POST["btn_registrar_uno"])){

        $existe_gmail = mysqli_num_rows(mysqli_query($con, "SELECT gmail FROM t_usuarios WHERE gmail = '$_POST[gmail]'"));

        if($existe_gmail == true){ $_SESSION["msj"] = "Ese gmail ya está en uso, escoja otro"; }else{
            // EN CASO DE QUE EL GMAIL NO ESTÉ EN USO
            if($_POST["clave"] != $_POST["rep_clave"]){ $_SESSION["msj"] = "Las contraseñas no coinciden"; }else{
                
                // Y SI LAS CONTRASEÑAS COINCIDEN
                $avatar = "por_defecto.png";

                $portada = "por_defecto.png";

                $clave = password_hash($_POST["clave"], PASSWORD_DEFAULT);

                if(mysqli_query($con, "INSERT INTO t_usuarios(id_rol, gmail, contrasena, avatar, portada, id_validacion, fecha_creacion) VALUES('$_POST[id_rol]', '$_POST[gmail]', '$clave', '$avatar', '$portada', '1', now())")){

                    unset($_SESSION["msj"]);

                    $_SESSION["id_usuario"] = mysqli_insert_id($con);

                    $_SESSION["id_rol"] = $_POST["id_rol"];
                        
                        // Asignarle un avatar por defecto
                        $archivo = $_SERVER["DOCUMENT_ROOT"] .'/tecno_connect/publico/img/por_defecto/avatar.png';

                        $nuevo_archivo = $_SERVER["DOCUMENT_ROOT"] ."/tecno_connect/publico/img/avatar/usuario". mysqli_insert_id($con) .".png";

                        if (!copy($archivo, $nuevo_archivo)) {
                            echo "Error al copiar el archivo $archivo...\n";
                        }

                        // Asignarle una portada por defecto
                        $archivo = $_SERVER["DOCUMENT_ROOT"] .'/tecno_connect/publico/img/por_defecto/portada.png';

                        $nuevo_archivo = $_SERVER["DOCUMENT_ROOT"] ."/tecno_connect/publico/img/portada/usuario". mysqli_insert_id($con) .".png";

                        if (!copy($archivo, $nuevo_archivo)) {
                            echo "Error al copiar el archivo $archivo...\n";
                        }

                        $nombre = "usuario". mysqli_insert_id($con) .".png";

                        mysqli_query($con, "UPDATE t_usuarios SET avatar = '$nombre', portada = '$nombre' WHERE id_usuario = '".mysqli_insert_id($con)."'");

                }else{

                    $_SESSION["msj"] = "Lo sentimos, algo salió mal :(";

                }

            }
        }

    // PASO DOS - REGISTRAR UNA EMPRESA
    }else if(isset($_POST["btn_registrar_empr"])){
        
        if(mysqli_query($con, "INSERT INTO t_empresas(id_usuario, nombre_empresa, cuit, localidad, sitio_web, sector, id_tipo, id_tamano, fecha_creacion) VALUES ('$_SESSION[id_usuario]', '$_POST[nom_empr]', '$_POST[cuit]', '$_POST[localidad]', '$_POST[sitio_web]', '$_POST[sector]', '$_POST[tipo]', '$_POST[tamano]', now())")){

            $_SESSION["msj"] = "Felicidades, te registraste exitósamente";

            unset($_SESSION["id_usuario"]);

            unset($_SESSION["id_rol"]);

            header("Location: login.php");

        }
    
    // PASO DOS - REGISTRAR UN TÉCNICO
    }else if(isset($_POST["btn_registrar_tec"])){

        if(mysqli_query($con, "INSERT INTO t_tecnicos(id_tecnico, nombre, apellido, dni, id_tecnica, id_especialidad, fecha_creacion) VALUES('$_SESSION[id_usuario]', '$_POST[nombre]', '$_POST[apellido]', '$_POST[dni]', '$_POST[tecnica]', '$_POST[especialidad]', now())")){

            $_SESSION["msj"] = "Felicidades, te registraste exitósamente";

            unset($_SESSION["id_usuario"]);

            unset($_SESSION["id_rol"]);

            header("Location: login.php");

        }

    }

    ?>

    <!-- TÍTULO (REGISTRAR USUARIO/UN PASO MÁS) -->
    <h1><?php if(empty($_SESSION["id_rol"])): echo "Registrar usuario"; else: echo "Un paso más"; endif; ?></h1>

    <?php

    if(!empty($_SESSION["msj"])){

        echo $_SESSION["msj"] ."<br>";

        unset($_SESSION["msj"]);

    }

    ?>

    <!-- FORMULARIOS DE REGISTRO -->
    <?php if(empty($_SESSION["id_usuario"])): ?>
        <!-- FORMULARIO REGISTRO - PASO UNO -->
        <form action="registro.php" method="POST">

            <label for="gmail">

                <span>Gmail (*)</span>

                <input type="email" name="gmail" id="gmail" placeholder="usuario@ejemplo.com" value="<?php mostrarSiExiste("gmail"); ?>" autofocus required>
            
            </label>

            <label for="clave">

                <span>Contraseña (*)</span>

                <input type="password" name="clave" id="clave" required>

            </label>

            <label for="rep_clave">

                <span>Repetir contraseña (*)</span>

                <input type="password" name="rep_clave" id="rep_clave" required>

            </label>

            <p>¿Qué quieres registrar? Decide bien, porque una vez escojes no hay vuelta atrás!</p>

            <div>

                <input type="radio" name="id_rol" id="empr" value="13">

                <label for="empr">Empresa</label>

            </div>

            <div>

                <input type="radio" name="id_rol" id="tec" value="14" required>
            
                <label for="tec">Técnico</label>
            
            </div>

            <div>

                <input type="checkbox" name="term_ser" id="term_ser" value="aceptado" required>

                <label for="term_ser">Acepto los términos de condiciones y servicios</label>

            </div>

            <button type="submit" name="btn_registrar_uno">Siguiente paso</button>

        </form>
    <?php elseif($_SESSION["id_rol"] == 13): ?>
        <!-- FORMULARIO PASO DOS - REGISTRAR UNA EMPRESA -->
        <form action="registro.php" method="POST">

            <label for="nom_empr">

                <span>Nombre de la empresa (*)</span>

                <input type="text" name="nom_empr" id="nom_empr" value="<?php mostrarSiExiste("nom_empr") ?>" required autofocus>

            </label>

            <label for="cuit">

                <span>Cuit (*)</span>

                <input type="text" name="cuit" id="cuit" value="<?php mostrarSiExiste("cuit") ?>" required>

            </label>
            
            <label for="localidad">

                <span>Localidad (*)</span>

                <input type="text" name="localidad" id="localidad" value="<?php mostrarSiExiste("localidad") ?>" required>

            </label>
            
            <label for="sitio_web">

                <span>Sitio web</span>

                <input type="url" name="sitio_web" id="sitio_web" value="<?php mostrarSiExiste("sitio_web") ?>">

            </label>
            
            <label for="sector">

                <span>Sector (*)</span>

                <input type="text" name="sector" id="sector" value="<?php mostrarSiExiste("sector") ?>" required placeholder="A qué se dedica tu empresa">

            </label>
            
            <label for="tipo">

                <span>Tipo (*)</span>

                <select name="tipo" id="tipo" required>
                
                    <option value="" hidden>Seleccione el tipo</option>

                    <?php

                    $res = mysqli_query($con, "SELECT * FROM t_tipos");

                    while($fila = mysqli_fetch_array($res)){

                        ?><option value="<?=$fila["id_tipo"]?>"><?=$fila["tipo"]?></option><?php

                    }

                    ?>

                </select>

            </label>
            
            <label for="tamano">

                <span>Tamaño (*)</span>

                <select name="tamano" id="tamano" required>
                
                    <option value="" hidden>Seleccione el tamaño</option>

                    <?php

                    $res = mysqli_query($con, "SELECT * FROM t_tamanos");

                    while($fila = mysqli_fetch_array($res)){

                        ?><option value="<?=$fila["id_tamano"]?>"><?=$fila["tamano"]?></option><?php

                    }

                    ?>

                </select>

            </label>

            <button type="reset"><a href="app/controlador/cerrar_sesion.php">Cancelar</a></button>

            <button type="submit" name="btn_registrar_empr">Completar registro</button>

        </form>
    <?php elseif($_SESSION["id_rol"] == 14): ?>
        <!-- FORMULARIO PASO DOS - REGISTRAR UN TÉCNICO -->
        <form action="registro.php" method="POST">

            <label for="nombre">

                <span>Nombre (*)</span>

                <input type="text" name="nombre" id="nombre" value="<?php mostrarSiExiste("nombre") ?>" autofocus required>

            </label>

            <label for="apellido">

                <span>Apellido (*)</span>

                <input type="text" name="apellido" id="apellido" value="<?php mostrarSiExiste("apellido") ?>" required>

            </label>

            <label for="dni">

                <span>Número de documento (*)</span>

                <input type="text" name="dni" id="dni" value="<?php mostrarSiExiste("dni") ?>" required>

            </label>
            
            <label for="tecnica">

                <span>Técnica (*)</span>

                <select name="tecnica" id="tecnica" required>
                
                    <option value="" hidden>Seleccione la técnica</option>

                    <?php

                    $res = mysqli_query($con, "SELECT * FROM t_tecnicas");

                    while($fila = mysqli_fetch_array($res)){

                        ?><option value="<?= $fila["id_tecnica"] ?>"><?= $fila["tecnica"] ?></option><?php

                    }

                    ?>

                </select>

            </label>
            
            <label for="especialidad">

                <span>Especialidad (*)</span>

                <select name="especialidad" id="especialidad" required>
                
                    <option value="" hidden>Seleccione una especialidad</option>

                    <?php

                    $res = mysqli_query($con, "SELECT * FROM t_especialidades");

                    while($fila = mysqli_fetch_array($res)){

                        ?><option value="<?= $fila["id_especialidad"] ?>"><?= $fila["especialidad"] ?></option><?php

                    }

                    ?>

                </select>

            </label>

            <button type="reset"><a href="app/controlador/cerrar_sesion.php">Cancelar</a></button>

            <button type="submit" name="btn_registrar_tec">Completar registro</button>

        </form>
    <?php endif; ?>

</body>

</html>