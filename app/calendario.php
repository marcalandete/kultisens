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
    <title>Calendario</title>
    <link rel="shortcut icon" href="media/Images/logo.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no user-scalable=no, maximum-scale=1">
    <meta http-equip="x-ua-compatible" content="ie-edge">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- CALENDAR CSS -->
    <link rel="stylesheet" href="../fullcalendar/packages/bootstrap/main.css">
    <link href='../fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='../fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
    <link rel="stylesheet" href="../fullcalendar/packages/timegrid/main.min.css">
    <link rel="stylesheet" href="../fullcalendar/packages/list/main.min.css">

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/calendario.css">

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">



</head>

<body onload="obtenerEventos(<?php echo $_SESSION['id'];?>), 0">

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

                    <span class="active"><a href="calendario.php">Calendario</a></span>

                </li>
                <li>

                    <a href="notificaciones.php">Notificaciones</a>

                </li>
                <li>

                    <a href="contacto.php">Contacto</a>

                </li>
                <li>

                    <span><a href="ajustesUsuario.php">Ajustes</a></span>

                </li>
                <li>

                    <a href="logout.php">Cerrar sesión</a>

                </li>
            </ul>
        </nav>
		<div class="overlay"></div>
        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar
               -light bg-light">
                <div class="container-fluid d-flex justify-content-between">

                    <a href="paginaPrincipal.php" class="logo"><img src="media/Images/logoGTI.png" alt="gti" width="150px" height="65px"></a>
                    <button type="button" id="sidebarCollapse" class="btn btn-link ">
                        <img src="media/Images/menu.png" alt="imagen_menu" width="25">
                    </button>

                </div>
            </nav>
        </div>

        <img src="media/Images/anyadirEVento.png" alt="icono_añadir_evento" id="iconoAñadir" data-toggle="modal" data-target="#exampleModalCentered" class="btn-btn-primary rounded-circle">
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCentered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenteredLabel">Añadir evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="return crearEvento(this)">

                            <input type="hidden" name="idUsuario" id="idUsuario">

                            <h5>Título:</h5>

                            <input class="campo" type="text" name="tituloEvento" placeholder="Inserte un titulo" required>
                            <br>
                            <div class="container">

                                <h5>Inicio:</h5>

                                <div class="row">
                                    
                                    <div class="col-3">

                                        <h6>Hora</h6>
                                        <input class="campo" type="text" name="inicioEventoHora" placeholder="XX:XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Dia</h6>
                                        <input class="campo" type="number" name="inicioEventoDia" placeholder="XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Mes</h6>
                                        <input class="campo" type="number" name="inicioEventoMes" placeholder="XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Año</h6>
                                        <input class="campo" type="number" name="inicioEventoAño" placeholder="XXXX" required value="2019">

                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="container">

                                <h5>Final:</h5>

                                <div class="row">
                                    
                                    <div class="col-3">

                                        <h6>Hora</h6>
                                        <input class="campo" type="text" name="finalEventoHora" placeholder="XX:XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Dia</h6>
                                        <input class="campo" type="number" name="finalEventoDia" placeholder="XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Mes</h6>
                                        <input class="campo" type="number" name="finalEventoMes" placeholder="XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Año</h6>
                                        <input class="campo" type="number" name="finalEventoAño" placeholder="XXXX" required value="2019">

                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="volver-login" data-dismiss="modal">Volver</button>
                                <input type="submit" class="boton-enviar">
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenteredLabel">Editar evento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="return editarEvento(this)">

                            <input type="hidden" name="idEvento" id="idEvento">

                            <h5>Título:</h5>

                            <input class="campo" type="text" name="tituloEvento" id="tituloEvento" placeholder="Inserte un titulo" required>
                            <br>

                            <div class="container">

                                <h5>Inicio:</h5>

                                <div class="row">
                                    
                                    <div class="col-3">

                                        <h6>Hora</h6>
                                        <input class="campo" type="text" name="inicioEventoHora" id="inicioEventoHora" placeholder="XX:XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Dia</h6>
                                        <input class="campo" type="number" name="inicioEventoDia" id="inicioEventoDia" placeholder="XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Mes</h6>
                                        <input class="campo" type="number" name="inicioEventoMes" id="inicioEventoMes" placeholder="XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Año</h6>
                                        <input class="campo" type="number" name="inicioEventoAño" id="inicioEventoAño" placeholder="XXXX" required>

                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="container">

                                <h5>Final:</h5>

                                <div class="row">
                                    
                                    <div class="col-3">

                                        <h6>Hora</h6>
                                        <input class="campo" type="text" name="finalEventoHora" id="finalEventoHora" placeholder="XX:XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Dia</h6>
                                        <input class="campo" type="number" name="finalEventoDia" id="finalEventoDia" placeholder="XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Mes</h6>
                                        <input class="campo" type="number" name="finalEventoMes" id="finalEventoMes" placeholder="XX" required>

                                    </div>

                                    <div class="col-3">

                                        <h6>Año</h6>
                                        <input class="campo" type="number" name="finalEventoAño" id="finalEventoAño" placeholder="XXXX" required>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="volver-login" data-dismiss="modal">Volver</button>
                                <input type="submit" class="boton-enviar">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--calendario-->

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- jQuery CDN - Slim version (=without AJAX) -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- CALENDAR JS -->

<script src='../fullcalendar/packages/bootstrap/main.min.css'></script>
<script src='../fullcalendar/packages/core/main.js'></script>
<script src='../fullcalendar/packages/daygrid/main.js'></script>
<script src="../fullcalendar/packages/list/main.js"></script>
<script src="../fullcalendar/packages/timegrid/main.min.js"></script>
<script src="../fullcalendar/packages/list/main.min.js"></script>
<script src="../fullcalendar/packages/interaction/main.min.js"></script>
<script src="../fullcalendar/packages/core/locales-all.js"></script>


<!-- CUSTOM JS -->
<script type="text/javascript" src="js/menu.js"></script>
<script src="js/calendario.js"></script>

<script>


</script>

</html>
