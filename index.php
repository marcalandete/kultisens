<!doctype html>
<html lang="es" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no user-scalable=no, maximum-scale=1">

    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="media/Images/logo.ico">
    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
    <title>Kultisens</title>
</head>

<body>
    <img src="media/Images/next-page.png" alt="subir" width="48" height="48" onclick="topFunction();" id="subir_arriba">
    <img src="media/Images/next-pageW.png" alt="subir" width="48" height="48" onclick="topFunction();" id="subir_arribaW">
    <a href="#section2" class="cd-scroll-down">
        <img src="media/Images/next-pageDown.png" alt="subir" width="48" height="48" id="bajar">
    </a>

    <nav id="cd-vertical-nav">
        <ul>
            <li>
                <a href="#section1" data-number="1">
                    <span class="cd-dot"></span>
                    <span class="cd-label">Landing Page</span>
                </a>
            </li>
            <li>
                <a class="tag" href="#section2" data-number="2">
                    <span class="cd-dot"></span>
                    <span class="cd-label">Descripción</span>
                </a>
            </li>
            <li>
                <a href="#section3" data-number="3">
                    <span class="cd-dot"></span>
                    <span class="cd-label">Contactar</span>
                </a>
            </li>
        </ul>
    </nav>

    <section id="section1" class="cd-section">
        <header>
            <img src="media/Images/logoGTI_gris.png" alt="Logo Empresa">
        </header>
        <article class="djg-eslogan">
            <h1>Es hora de conectar tus cultivos con Kultisens</h1>
            <h3>Sacarás el máximo partido a tus plantaciones, gracias a los datos obtenidos por nuestros sensores.</h3>
        </article>
        <!--ESTO ES EL MODAL DE INICIAR SESIÓN! OJO, IMPRESCINDIBLE QUE ESTÉ EN EL BODY-->
        <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!--Contido de un modal-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> <!--Botón para cerrar el popUp-->
                    <h2 class="modal-title">Iniciar Sesión</h2>
                </div>
                <div class="modal-body">
                <div> <!--TODO ESTOS SON LAS POSIBLES ALERTAS QUE PUEDEN SALIR-->
                    <?php
                    if(isset($_GET["error"])) //miras si existe un mensaje de error
                    {
                    $hayError=$_GET["error"]; //guardas el mensaje en una variable
                        if($hayError=='correoIncorrecto')
                        {
                    ?>
                            <script type="text/javascript">$(document).ready(function() {$('#myModal').modal('show');});</script>
                    <?php
                            echo"<div class='alert alert-danger', role='alert';><strong>¡Error!</strong> El correo electrónico y/o la contraseña no son validos.</div>";
                        } 
                        else 
                        {
                    ?>
                            <script type="text/javascript">$(document).ready(function() {$('#myModal').modal('show');});</script>
                    <?php
                            echo"<div class='alert alert-danger', role='alert';><strong>¡Error!</strong> El correo electrónico y/o la contraseña no son validos.</div>";
                        }
                    } 
                    if(isset($_GET["estado"]))
                    {
                      if($_GET["estado"]=="cambiadas")
                        {
                    ?>
                       <script type="text/javascript">$(document).ready(function() {$('#myModal').modal('show');});</script>
                    <?php
                        echo"<div class='alert alert-warning' role='alert'>
                        <strong>¡Enhorabuena!</strong> Su contraseña ha sido cambiada con éxito; ya puede iniciar sesión.</div>";
                    }
                    }
                    ?>
                </div>
    
        <form action="app/comprobarLogin.php" id="bloque-login" method="post">
            <div class="contenedor-recuperar1">
               <img class="mail" src="media/Images/iconfinder_008_Mail_183573.svg">
               <h4 class="fondoVerde">Correo Electrónico:</h4>
            </div>
                <input class="campo" size="33" type="email" placeholder="E-mail" name="direccion" required id="correoE">
            <div class="contenedor-recuperar1">
               <img class="mail" src="media/Images/password.svg">
               <h4 class="fondoVerde">Contraseña:</h4>
            </div>
            <div class="clave1">
                <input class="campo" size="29" id="psw" type="password" placeholder="Contraseña" name="psw" required>
				<label><img id="eye" src="media/Images/iconfinder_icon-21-eye-hidden_314858.svg" onclick="mostrarLogin()"></label>
                <!--esto es lo que hace que aparezca el ojo, llama a la función externa en js-->
            </div>
            <input type="submit" value="Entrar" class="boton-enviar">
        </form>
        </div>
        <div class="modal-footer">
            <div class="recuperar-contrasenya">
            <a onclick="$('#myModal').modal('hide'); setTimeout(function(){$('#myModal2').modal('show');},325);" type="button" data-toggle="modal" href="#" class="recuperar-contrasenya">Cambiar contraseña</a>
            </div>
        </div>
        </div> <!--contenido del modal-->
        </div>
        </div> <!--cierras el moda-->
        <!--ESTO ES EL MODAL DE RECUPERAR CONTRASEÑA! OJO, IMPRESCINDIBLE QUE ESTÉ EN EL BODY-->
        <div class="modal" id="myModal2" role="dialog">
        <div class="modal-dialog">

            <!--Contido de un modal-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> <!--Botón para cerrar el popUp-->
                    <h2 class="modal-title">¿Ha olvidado su contraseña?</h2>
                </div>
                <div class="modal-body">
                <article>
                    <p>Si ha perdido u olvidado su contraseña; introduzca su correo electrónico y le enviaremos un enlace para cambiarla.</p>  
                </article>
                <div> <!--TODO ESTOS SON LAS POSIBLES ALERTAS QUE PUEDEN SALIR-->
                    <?php
                    if(isset($_GET["estado"])) //miras si existe un mensaje de error
                    {
                        if($_GET["estado"]=="error")
                        {
                        ?>
                            <script type="text/javascript">$(document).ready(function() {$('#myModal2').modal('show');});</script>
                        <?php
                            echo"<div class='alert alert-danger', role='alert';><strong>¡Error!</strong> El correo electrónico no es valido. Porfavor, vuelva a intentarlo o <a href='#' type='button' data-toggle='modal' data-target='#myModal2' onclick='?>$('#myModal2').modal('hide');<?php' class='enlaceContacto'> contáctenos.</a></div>";
                        }
                        if($_GET["estado"]=="enviado")
                        {
                        ?>
                       <script type="text/javascript">$(document).ready(function() {$('#myModal2').modal('show');});</script>
                    <?php
                        echo"<div class='alert alert-warning' role='alert'>
                        <strong>¡Enhorabuena!</strong> Su correo electrónico ha sido enviado con éxito.</div>";
                        }
                    }
                    ?>
                </div>
    
        <form action="app/mail.php" id="bloque-recuperar" method="post">
            <div class="contenedor-recuperar1">
                <img class="mail" src="media/Images/iconfinder_008_Mail_183573.svg">
                <h4 class="fondoVerde">Correo Electrónico:</h4>
            </div>
            <input class="campo" type="email" placeholder="Correo Electrónico" name="direccion" required>
            <div class="botones">
               <a onclick="$('#myModal2').modal('hide');$('#myModal').modal('show');" type="button" class="volver-login" href="#">Volver</a>
                <input type="submit" value="Enviar Correo" class="boton-enviar">
            </div>
        </form>
        </div>
        </div> <!--contenido del modal-->
        </div>
        </div>
        <footer>
            <div class="contenedor-1">
                <div class="container">
                    <!-- Trigger the modal with a button -->
                    <button id="boton-iniciar-sesion" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Iniciar Sesión</button>
                </div>
            </div>
            <div class="contenedor-2">
                <a href="#section2" class="boton-mas-info">Más información</a>
            </div>
        </footer>
        <!--<a href="#section2" class="cd-scroll-down cd-img-replace">scroll down</a>-->
    </section><!-- cd-section -->

    <section id="section2" class="cd-section">
        <nav class="division-1">
            <article class="djg-contenido">

                <h2>¿Qué es kultisens?</h2>

                <p>Kultisens es el nombre de nuestro producto, el cual está formado por un total de 7 sensores que te permitirán medir con precisón los diferentes parámetros de tus cultivos. Además, podrás acceder a estos datos con para el estudio y la mejora de tus parcelas, sacándoles el mejor rendimiento.<p>

            </article>
            <!--información producto-->
            <aside class="video">

                <video src="media/Videos/PROMO_VIDEO.mp4" autoplay muted loop></video>

            </aside>
            <!--video producto-->
        </nav>
        <nav class="division-2">
            <!--CARRUSEL DE IMAGENES-->
            <div id="myCarousel" class="carousel slide" data-ride="carousel">

                <ol class="carousel-indicators">

                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>

                </ol>

                <div class="carousel-inner">

                    <div class="item active">

                        <img src="media/Images/foto%201.JPG" alt="Carrusel Foto 1">

                    </div>

                    <div class="item">

                        <img src="media/Images/foto%202.JPG" alt="Carrusel Foto 2">

                    </div>

                    <div class="item">

                        <img src="media/Images/foto%203.JPG" alt="Carrusel Foto 3">

                    </div>

                    <div class="item">

                        <img src="media/Images/foto%204.JPG" alt="Carrusel Foto 4">

                    </div>
                </div>

                <a class="left carousel-control" href="#myCarousel" data-slide="prev">

                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>

                </a>

                <a class="right carousel-control" href="#myCarousel" data-slide="next">

                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>

                </a>
            </div>

            <article class="djg-contenido">
                <!--información producto-->
                <span>

                    <p>En Margarita SL nos preocupamos por el medio ambiente, por eso esta sonda emplea la energía de una placa solar además de la de una batería.</p>
                    <p>Si desea adquirir nuestros servicios póngase en contacto con nosotros mediante el siguiente formulario:</p>

                </span>
            </article>
        </nav>
    </section><!-- cd-section -->

    <section id="section3" class="cd-section">
        <h2>¡Contáctanos!</h2>
        <section class="contacto">
            <section class="informacion-contacto">
                <div class="contenedor-recuperar">
                    <img class="mail" src="media/Images/iconfinder_008_Mail_183573W.svg">
                    <h4>Escríbanos:</h4>
                    <p>margaritasl@gmail.com</p>
                </div>
                <div class="contenedor-recuperar">
                    <img class="mail" src="media/Images/telephoneW.svg">
                    <h4>Llame al:</h4>
                    <p>+34 628496137</p>
                </div>
                <div class="contenedor-recuperar">
                    <img class="mail" src="media/Images/home.svg">
                    <h4>Visítenos:</h4>
                    <p>C/ França Nº15 (46730 Gandía , Valencia)</p>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d651.9724644206375!2d-0.16846506482530138!3d38.98516571323357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd61e81f812c8a3d%3A0xecf40c86d54f2ff5!2sCalle+de+Fran%C3%A7a%2C+46730+Gand%C3%ADa%2C+Valencia!5e0!3m2!1ses!2ses!4v1554737982367!5m2!1ses!2ses" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </section>
            <section class="formulario-contacto">
                <div class="mensajeError">
                <?php
            if(isset($_GET["estado"]))
            {
                $estado=$_GET["estado"];
                if($estado=='correoEnviado')
                {
                    echo"<div id='alertaNoTransparente' class='alert alert-warning' role='alert'>
                    <strong>¡Correo enviado con éxito!</strong> Gracias por contactarnos, en breve recibirá un respuesta.</div>";
                } 
            }
            ?> <!--mostramos un error en caso de que las dos contraseñas sean iguales-->
                </div>
                <form id="formContactoB" action="/app/mailContactoNoRegistrado.php" method="post">
                    <!--<h3 class="titulo-form">Envianos un correo electrónico:</h3>-->
                    <div class="contenedor-recuperar">
                        <img class="mail" src="media/Images/iconfinder_008_Mail_183573W.svg">
                        <h4>Correo electrónico:</h4>
                    </div>
                    <input id="inputs" name="direccion" class="campoW" type="text" placeholder="Correo electrónico" required>
                    <div class="contenedor-recuperar">
                        <img class="mail" src="media/Images/userW.svg">
                        <h4>Nombre completo:</h4>
                    </div>
                    <input id="inputs" name="nombre" class="campoW" type="text" placeholder="Nombre y apellidos" required>
                    <div class="contenedor-recuperar">
                        <img class="mail" src="media/Images/telephoneW.svg">
                        <h4>Teléfono:</h4>
                        <img id="localizacion" class="mail" src="media/Images/locationW.svg">
                        <h4>Código postal:</h4>
                    </div>
                    <div class="misma-linea">
                        <input id="inputs mini" name="telefono" class="campoW" type="text" placeholder="Número de teléfono">
                        <input id="inputs" name="codigo-postal" class="campoW" type="text" placeholder="Código postal">
                    </div>
                    <div class="contenedor-recuperar-text">
                        <img class="mail" src="media/Images/messageW.svg">
                        <h4 style="margin-top:0; color: white;">Mensaje:</h4>
                    </div>
                    <textarea name="mensaje" placeholder="Escriba su mensaje" form="formContacto" required></textarea>
                    <div class="botones">
                        <input class="boton-mas-info" type="submit" value="Enviar Mensaje">
                    </div>
                </form>
            </section>
        </section><!-- cd-section -->
    </section>
    <script src="js/ojo.js"></script>
    <script>
        //Cuando se mueva la pantalla arriba o abajo(window.onscroll), llamamos a la función scrollFunction
        window.onscroll = function() {
            scrollFunction()
        };
        // Esta función lo que hace es que cuando la pantalla esté a 20px de la parte de arriba, entonces mostrará la imagen
        // para subir cambiando su display a block, y en caso que se suba desaparecerá, poniendo el display en none de nuevo.
        function scrollFunction() {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                if (document.body.scrollTop > 1000 || document.documentElement.scrollTop > 1000) {
                    document.getElementById("subir_arribaW").style.display = "block";
                    document.getElementById("subir_arriba").style.display = "none";
                    document.getElementById("bajar").style.display = "none";
                } else {
                    document.getElementById("subir_arribaW").style.display = "none";
                    document.getElementById("subir_arriba").style.display = "block";
                    document.getElementById("bajar").style.display = "none";
                }
            } else {
                document.getElementById("subir_arribaW").style.display = "none";
                document.getElementById("subir_arriba").style.display = "none";
                document.getElementById("bajar").style.display = "block";
            }
        }
        // Función del onclick de la flecha, que hará que suba arriba del todo cuando se haga click en ella.
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

    </script>
</body>

</html>
