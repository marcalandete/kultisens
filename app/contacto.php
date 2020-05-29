<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contacto</title>
    <link rel="shortcut icon" href="media/Images/logo.ico">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="shortcut icon" href="media/Images/logo.ico">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/contacto.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

</head>

<body  overflow= hidden>
<head>
        <div class="todo">

        <!-- Sidebar  -->

        <nav id="sidebar">

            <div id="dismiss"><i class="fas fa-arrow-right"></i></div>

            <div class="sidebar-header">

                <p>
                <?php
                
                echo $_SESSION['nombre']."<br>";
                echo $_SESSION['apellido1']." ";
                echo $_SESSION['apellido2'];
                
                ?>
                </p>
                <img src="media/Images/profile.png" alt="perfil" width="50px" height="50px">
            </div>

            <ul class="list-unstyled components">
                <p></p>
                <li>
                    <a href="paginaPrincipal.php">Inicio</a> <!-- OJO, CUANDO SE PONGA EL MENÚ EN OTRA HOJA HAY QUE PONERLE LA CLASS ACTIVE Y QUITAR ESTA-->
                </li>
                <li>
                    <a href="datos_de_sensores.php">Datos de sensores</a>

                </li>
                <li>

                    <a href="calendario.php">Calendario</a>

                </li>
                <li>

                    <a href="notificaciones.php">Notificaciones</a>

                </li>
                <li>

                    <span class="active"><a href="contacto.php">Contacto</a></span>

                </li>
                <li>
                   
                    <a href="ajustesUsuario.php">Ajustes</a>
                    
                </li>
                <li>

                    <a href="logout.php" >Cerrar sesión</a>

                </li>
                
            </ul>
        </nav>
		<div class="overlay"></div>
        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <div class="container-fluid d-flex justify-content-between">

                    <a href="paginaPrincipal.php" class="logo"><img src="media/Images/logoGTI.png" alt="gti" width="150px" height="65px"></a>
                    <button type="button" id="sidebarCollapse" class="btn btn-link "><img src="media/Images/menu.png" alt="imagen_menu" width="25"></button>

                </div>
            </nav>
        </div>
    </div>

</head>
<section>
    <h2>¡Contáctanos!</h2>
    <section class="contacto">
    <section class="informacion-contacto">
                <div class="contenedor-recuperar">
                    <img class="mail" src="media/Images/iconfinder_008_Mail_183573.svg">
                    <h4>Escríbanos:</h4>
                    <p>margaritasl@gmail.com</p>
                </div>
                <div class="contenedor-recuperar">
                    <img class="mail" src="media/Images/telephone.svg">
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
        ?>
    <form enctype="multipart/form-data" id="formContacto" action="mailContactoRegistrado.php" method="post">
       <div class="contenedor-recuperar">
            <img class="mail" src="media/Images/message.svg">
            <h5>Mensaje:</h5>
        </div>
        <textarea name="mensaje" placeholder="Escriba su mensaje" form="formContacto" required></textarea>
        <div class="contenedor-recuperar">
            <img class="mail" src="media/Images/files.svg">
            <h5>Adjuntar archivos:</h5>
            <button type="button" class="btn btn-secondary" data-toggle="tooltip"
            data-placement="right" title="Formato: pdf, jpg, png, doc, docz, xml, txt. Tamaño: 2mb."><i class="fas fa-info-circle"></i>
            </button>
        </div>
        <div class="custom-file">
            <input name="archivo" type="file" class="form-control-file" id="exampleFormControlFile1" accept=".png,.jpeg,.pdf,.doc,.txt,.xml,.docx" multiple>
        </div>
        <div class="contenedor-recuperar">
            <h5>¿Con que departamento quiere hablar?</h5>
        </div>
        <div class="contenedor-recuperar">
            <div class="contenedor-recuperar1">
            <div class="custom-control custom-switch">
              <input name="administrativo" value="administrativo" onclick="checkOnlyOne(this.value)" type="checkbox" class="custom-control-input" id="customSwitch1">
              <label class="custom-control-label" for="customSwitch1">Administrativo</label>
            </div>
           <div class="custom-control custom-switch">
              <input name="tecnico" value="tecnico" onclick="checkOnlyOne(this.value)" type="checkbox" class="custom-control-input" id="customSwitch2">
              <label class="custom-control-label" for="customSwitch2">Técnico</label>
            </div>
            </div>
            <div class="contenedor-recuperar1">
            <div class="custom-control custom-switch">
              <input name="informativo" value="informativo" onclick="checkOnlyOne(this.value)" type="checkbox" class="custom-control-input" id="customSwitch3">
              <label class="custom-control-label" for="customSwitch3">Informativo</label>
            </div>
           <div class="custom-control custom-switch">
              <input name="reclamaciones" value="reclamaciones" onclick="checkOnlyOne(this.value)" type="checkbox" class="custom-control-input" id="customSwitch4">
              <label class="custom-control-label" for="customSwitch4">Reclamaciones</label>
            </div>
            </div>
        </div>
        <div class="botones">
            <input class="boton-enviar" type="submit" value="Enviar Mensaje">
        </div> 
    </form>
    </section>
    </section>
</section>
<!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
    function checkOnlyOne(b){
        var x=document.getElementsByClassName("custom-control-input");
        for(var i=0;i<x.length;i++){
            if(x[i].value!=b) x[i].checked=false;
        }
    }
</script>
</body>

</html>