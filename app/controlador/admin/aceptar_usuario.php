<?php

require_once "../../modelo/conexion.php";

if(isset($_GET["id_usuario"])){

    $update = "UPDATE t_usuarios SET id_validacion = '3' WHERE id_usuario = '$_GET[id_usuario]'";

    if(mysqli_query($con, $update)){

        header("Location: ../../vista/adm.php");

    }

}

?>