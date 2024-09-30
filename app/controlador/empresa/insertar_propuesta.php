<?php

    if(isset($_POST["btn_propuesta"])){

        require_once "../../modelo/conexion.php";

        session_start();

        // RECIBO LOS DATOS ENVIADOS POR POST
        $id_empresa = $_SESSION["id_empresa"];

        $titulo = $_POST["titulo"];

        $descr = $_POST["descr"];
        
        $pago_min = $_POST["pago_min"];

        $limite = $_POST["limite"];

        $query = "INSERT INTO t_propuestas(id_empresa, titulo, descr, pago_min, limite, fecha_publicacion) VALUES('$id_empresa', '$titulo', '$descr', '$pago_min', '$limite', now())";

        if(mysqli_query($con, $query)){

            header("Location: ../../vista/emp.php");

        }

    }

?>