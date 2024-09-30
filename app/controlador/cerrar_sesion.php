<?php

session_start();

unset($_SESSION["id_usuario"]);

unset($_SESSION["id_rol"]);

unset($_SESSION["id_tecnico"]);

unset($_SESSION["id_empresa"]);

unset($_SESSION["msj"]);

session_destroy();

header("Location: ../../login.php");

?>