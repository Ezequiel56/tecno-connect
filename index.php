<?php

session_start();

// SI ESTÁ LOGUADO, REDIRECCIONAR AL INICIO.PHP, O SI NO ESTÁ VALIDADO MOSTRAR MSJ CORRESPONDIENTE
if(isset($_SESSION["id_rol"])){

    if(isset($_SESSION["id_validacion"])){
            
        switch ($_SESSION["id_validacion"]){

            case 1:

                echo "Tu cuenta está en proceso de validación";

                break;

            case 2:

                echo "Tu cuenta fué rechazada, contacta a 'tecno.connect.oficial@gmail.com' en caso de cualquier reclamo";

                break;

            case 3:

                switch ($_SESSION["id_rol"]) {
            
                    case 15:
            
                        header("Location: app/vista/adm.php");
            
                        break;
            
                    case 14:
                    
                        header("Location: app/vista/tec.php");
                    
                        break;
            
                    case 13:
                    
                        header("Location: app/vista/emp.php");
                    
                        break;
                    
                    default:
            
                        # code...
            
                        break;
                    
                    }

                break;

            default:

                echo "Algo salió mal durante la validación de tu cuenta";

                break;

        }

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tecno Connect</title>
     <link rel="stylesheet" href="publico/css/estilos.css">
</head>

<body>

    <!-- <header>

        <a href="index.php">Tecno Connect</a>

        <a href="login.php">Login</a>

        <a href="registro.php">Registro</a>

    </header> -->

    <header class="hero">
        <div class="textos-hero">
            <h1>Bienvenido a Tecno Connect</h1>
            <p>Una bolsa de trabajo para técnicos y empleadores</p>
            <!-- <a href="#contacto">Contactanos</a> -->
            <a href="login.php">Iniciar sesion</a>
            <br>
            <a href="registro.php">Registrarse</a>
        </div>
        <div class="svg-hero" style="height: 150px; overflow: hidden;"><svg viewBox="0 0 500 150" preserveAspectRatio="none"
                style="height: 100%; width: 100%;">
                <path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                    style="stroke: none; fill: #fff;"></path>
            </svg></div>
    </header>


    <section class="wave-contenedor website">
        <img src="publico/img/our_work/ilustracion1.svg" alt="">
        <div class="contenedor-textos-main">
            <h2 class="titulo left">¿Qué es Tecno Connect?</h2>
            <p class="parrafo">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Incidunt enim reiciendis
                molestias nam tempore. Ullam hic accusantium eligendi ipsam corrupti!</p>
            <a href="" class="cta">Leer más</a>
        </div>
    </section>

    <section class="info">
        <div class="contenedor">
            <h2 class="titulo left">Juntos podemos mejorar</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        </div>
    </section>

    <section class="cards contenedor">
        <h2 class="titulo">Nuestros servicios</h2>
        <div class="content-cards">
            <article class="card">
                <i class="far fa-clone"></i>
                <h3>Título de tarjeta</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                <a href="" class="cta">Leer más</a>
            </article>
            <article class="card">
                <i class="fas fa-database"></i>
                <h3>Título de tarjeta</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                <a href="" class="cta">Leer más</a>
            </article>
            <article class="card">
                <i class="far fa-object-group"></i>
                <h3>Título de tarjeta</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                <a href="" class="cta">Leer más</a>
            </article>
        </div>
    </section>

    <section class="galeria">
        <div class="contenedor">
            <h2 class="titulo">Nuestro trabajo / Tecnicas o Empresas que trabajan con nosotros / Nuestro equipo</h2>
            <article class="galeria-cont">
                <img src="publico/img/our_work/uno.jpg" alt="">
                <img src="publico/img/our_work/dos.jpg" alt="">
                <img src="publico/img/our_work/tres.jpg" alt="">
                <img src="publico/img/our_work/cuatro.jpg" alt="">
                <img src="publico/img/our_work/cinco.jpg" alt="">
                <img src="publico/img/our_work/seis.jpg" alt="">
            </article>
        </div>
    </section>s

    <section class="info-last">

        <div class="contenedor last-section">
            <div class="contenedor-textos-main">
                <h2 class="titulo left">¿Cuántas personas hay registradas?</h2>
                <p class="parrafo">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorum reprehenderit nostrum expedita quasi odio architecto laudantium sunt nemo dicta atque?</p>
                <a href="" class="cta">Leer más</a>
            </div>
            <img src="publico/img/our_work/ilustracion.svg" alt="">
        </div>
        
        <div class="svg-wave" style="height: 150px; overflow: hidden;"><svg viewBox="0 0 500 150" preserveAspectRatio="none"
            style="height: 100%; width: 100%;">
            <path d="M0.00,49.98 C149.99,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                style="stroke: none; fill: #f5576c;"></path>
        </svg></div>
    </section>

    <footer id="contacto">
        <div class="contenedor">
            <h2 class="titulo">Contáctanos</h2>
            <form action="" class="form">
                <input class="input"  type="text" name="" id="" placeholder="Nombre">
                <input class="input"  type="email" name="" id="" placeholder="Email">
                <textarea  class="input" name="" id="" cols="30" rows="10" placeholder="Mensaje"></textarea>
                <input class="input"  type="submit" value="Enviar">
            </form>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/c15b744a04.js" crossorigin="anonymous"></script>
</body>

</html>

<!-- 

    NORMAS DE CODIFICACIÓN:

        Variables: el nombre de las variables se declararán con snake_case

        Funciones: para declarar las funciones vamos a usar camelCase

        Variables constantes: para declarar variables constantes usamos MAYUS_SNAKE_CASE

        Espacios: entre línea y línea, SIEMPRE dejo un espacio de más para que el código sea más legible

        Idioma: todos los nombres (carpetas, archivos, variables, etc) van estar en español

    BASE DE DATOS:

        general: todos los nombres van a estar en minúscula

        nombre de tablas: "t" + "_" + nombre_de_la_tabla_en_plural

        nombre de las id: "id" + "_" + nombre_de_la_tabla_en_singular

-->