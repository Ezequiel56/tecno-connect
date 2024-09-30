<?php

    require_once "../modelo/conexion.php";

    // LA CONSULTA QUERY ESTÁ ARRIBA DE DONDE SE IMPLEMENTE EL REQUIRE_ONCE

    $res = mysqli_query($con, $query);

    if(mysqli_num_rows($res) > 0){

        ?><h2>Propuestas</h2><?php

        ?><ul><?php

        while($fila = mysqli_fetch_array($res)){

            ?>
            
            <li>

                <img src="<?=AVATAR . $fila["avatar"]?>" width="20px" alt="Foto de perfil">

                <span><a href="perfil.php?id_usuario=<?=$fila["id_usuario"]?>&id_rol=<?=$fila["id_rol"]?>"><?=$fila["nombre_empresa"]?></a></span>

                <h3><?=$fila["titulo"]?></h3>

                <p><?=$fila["descr"]?></p>

                <p>

                    <span id="pago">- Pago: <?=$fila["pago_min"]?> </span>

                    <span id="fecha_limite">- Fecha límite: <?=$fila["limite"]?> </span>

                    <?php
                    
                    // EN CASO DE SER UN TÉCNICO, IMPLEMENTAR EL SISTEMA DE POSTULAR/DESPOSTULAR
                    if($_SESSION["id_tecnico"] != false){

                        $esta_postulado = mysqli_num_rows(mysqli_query($con, "SELECT * FROM t_postulantes WHERE id_tecnico = '$_SESSION[id_tecnico]' AND id_propuesta = '$fila[id_propuesta]'"));

                        if($esta_postulado == true){

                            ?><a href="../controlador/tecnico/postular.php?id_propuesta=<?=$fila["id_propuesta"]?>&accion=2">Des-Postulate</a><?php

                        }else{

                            ?><a href="../controlador/tecnico/postular.php?id_propuesta=<?=$fila["id_propuesta"]?>&accion=1">Postulate</a><?php

                        }

                    }

                    // EN CASO DE SER UNA EMPRESA, IMPLEMENTAR EL SISTEMA PARA VER A LOS POSTULANTES
                    if($_SESSION["id_empresa"] != false){

                        $postulantes = mysqli_query($con, "SELECT * FROM t_postulantes INNER JOIN t_tecnicos ON t_postulantes.id_tecnico = t_tecnicos.id_tecnico INNER JOIN t_usuarios ON t_tecnicos.id_tecnico = t_usuarios.id_usuario WHERE id_propuesta = '$fila[id_propuesta]'");

                        if(mysqli_num_rows($postulantes) > 0){

                            ?><h4>Postulantes</h4><?php

                            ?><ul><?php

                            while($postulante = mysqli_fetch_array($postulantes)){

                                ?>
                                
                                <li>

                                    <img src="<?=AVATAR . $postulante["AVATAR"]?>" width="20px" alt="Foto de perfil">

                                    <a href="perfil.php?id_usuario=<?=$postulante["id_usuario"]?>&id_rol=<?=$postulante["id_rol"]?>"><?= $postulante["nombre"] . " " . $postulante["apellido"]?></a>

                                    <?php
                                    // Ver currículum
                                    if(mysqli_num_rows(mysqli_query($con, "SELECT id_servicio FROM t_servicios WHERE id_servicio = '$postulante[id_tecnico]'")) > 0){
                                        $curriculum = mysqli_fetch_array(mysqli_query($con, "SELECT curriculum FROM t_servicios WHERE id_servicio = '$postulante[id_tecnico]'"))["curriculum"];
                                        if(!empty($curriculum)){
                                            ?><a href="curriculum.php?id_servicio=<?=$postulante["id_tecnico"]?>&curriculum=<?=$curriculum?>" target="_blank">Ver currículum</a><?php
                                        }
                                    }
                                    ?>

                                </li>
                                
                                <?php

                            }

                            ?></ul><?php

                        }

                    }

                    // EN CASO DE ESTAR EN EL PERFIL DE LA EMPRESA, IMPLEMENTAR EL EDITAR Y EL ELIMINAR
                    if(isset($_GET["id_usuario"])){

                        if($_GET["id_usuario"] == $_SESSION["id_usuario"] AND $_SESSION["id_empresa"] != false){

                            ?><a href="">Editar</a><?php

                            ?><a href="">Eliminar</a><?php

                        }

                    }

                    ?>

                </p>

            </li>

            <?php

        }

        ?></ul><?php

    }else{



    }

?>