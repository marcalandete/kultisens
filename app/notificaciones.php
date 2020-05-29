<?php

    session_start(); //iniciamos la sesión.

    if(!isset($_SESSION['cliente'])){  //Miramos si existe la variable de la sesión, que variará en función de la ID de cada cliente.

        header("location:login.php");
    }

    else{};
?>

<!DOCTYPE html>
<html lang="es">

<head>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no user-scalable=no, maximum-scale=1">
    <meta http-equip="x-ua-compatible" content="ie-edge">
    <title>Notificaciones</title>
    <link rel="shortcut icon" href="media/Images/logo.ico">

    <!-- Font Awesome JS -->

    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- Bootstrap -->

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Menú -->
    <link rel="stylesheet" href="css/ajustes.css">
    <link rel="stylesheet" href="css/notificaciones.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="css/menu.css">

    <!-- Nuestro css -->

</head>
<body onload="getNotificaciones(<?php echo $_SESSION['id']; ?>)">

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
           
            <a href="paginaPrincipal.php">Inicio</a>
            
        </li>
        <li>

            <a href="datos_de_sensores.php">Datos de sensores</a>

        </li>
        <li>

            <a href="calendario.php">Calendario</a>

        </li>
        <li>

            <span class="active"><a href="notificaciones.php">Notificaciones</a></span>

        </li>
        <li>

            <a href="contacto.php">Contacto</a>

        </li>
        <li>
           
            <a href="ajustesUsuario.php">Ajustes</a>
            
        </li>
        <li>

            <a href="logout.php" >Cerrar sesión</a>

        </li>
    </ul>
</nav>

<div id="content">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-between">
        <a href="paginaPrincipal.php" class="logo"><img src="media/Images/logoGTI.png" alt="gti" width="150px" height="65px"></a>
        <button type="button" id="sidebarCollapse" class="btn btn-link "><img src="media/Images/menu.png" alt="imagen_menu" width="25"></button>
    </div>
</nav>
</div>
<br>
<h3>Administrador de notificaciones</h3>
<!-- Añadir nuevas alertas -->
<br>
<div class="nuevaAlerta" id="">

  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Crear nueva alerta o recordatorio
  </button>

<div class="collapse" id="collapseExample">
  <div class="container card card-body" id="contenedor" style="border: none;">
<form action="" name="formTipoMedicion" onsubmit="return seleccionTipoMedicion(this)">

<div class="btn-group btn-group-toggle" data-toggle="buttons">
    <label class="btn btn-secondary active">
        <input type="radio" name="options" class="listaInputs" id="humedad" onchange="mostrarFormulario('humedad')" autocomplete="off" checked>
        <img src="media/Images/aguaW.png">
    </label>
    <label class="btn btn-secondary" for="iluminacion" onchange="mostrarFormulario('iluminacion')">
        <input type="radio" name="options" class="listaInputs" id="iluminacion" autocomplete="off">
        <img src="media/Images/creativeW.png">

    </label>
    <label class="btn btn-secondary" for="presion" onchange="mostrarFormulario('presion')">
        <input type="radio" name="options" class="listaInputs" id="presion" autocomplete="off">
        <img src="media/Images/pressureW.png">
    </label>
    <label class="btn btn-secondary" for='temperatura' onchange="mostrarFormulario('temperatura')">
        <input type="radio" name="options" class="listaInputs" id="temperatura" autocomplete="off">
        <img src="media/Images/thermometerW.png">
    </label>
    <label class="btn btn-secondary" for='salinidad' onchange="mostrarFormulario('salinidad')">
        <input type="radio" name="options" class="listaInputs" id="salinidad" autocomplete="off">
        <img src="media/Images/iconW.png">
    </label>
</div>
</form>
</div>
<div class="container" id="formularioNotificaciones"></div>
</div>
</div>

<!-- Empieza la lista de notificaciones -->

<br>
<hr>
<div class="container">
    <div class="row">
        <div class="list-group" id="listaNotificaciones">



        </div>
    </div>
</div>



<!-- jQuery -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<!-- Popper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

<!-- Bootstrap -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<!-- jQuery Custom Scroller -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Menú -->

<script type="text/javascript" src="js/menu.js"></script>
<!-- JS de las notificaciones -->

<script src="js/notificaciones.js"></script>
<script>

</script>
 </body>
 </html>