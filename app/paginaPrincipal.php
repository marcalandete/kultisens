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
    <title>Parcelas</title>
    <link rel="shortcut icon" href="media/Images/logo.ico">

    <!-- Font Awesome JS -->

    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- Bootstrap -->

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Menú -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="css/menu.css">

    <!-- Nuestro css -->

    <link rel="stylesheet" href="css/paginaPrincipal.css">

</head>

<body style="overflow-y:hidden" onload="comprobarRobo(<?php echo $_SESSION['id']; ?>);">
    <div class="overlay"></div>
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
                   
                    <span class="active"><a href="paginaPrincipal.php">Inicio</a></span>
                    
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
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingOne">

                <h5 class="mb-0">
                    <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> PARCELAS <i class="fas fa-sort"></i></button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div id="listaParcelas">
                        
                        <input type="text" placeholder="Buscar parcela..." id="buscar" oninput="buscar()">
                        
                        <!-- Listado de parcelas -->

                        <div class="scrollbar" id="style-1">

                            <ul class="list-group" id="selector">

                                <li class="list-group-item" onclick="seleccionar2()">

                                    <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" onchange="seleccionar()" checked><label class="custom-control-label">Seleccionar todas</label></div>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <button type="button" class="btn btn-secondary" id="centrar" onclick="centrarMapa()">Centrar</button>

    <!-- Mapa -->

    <div id="map"></div>

    <script>
        var map;
        
        function initMap() {

            map = new google.maps.Map(document.getElementById('map'), {

                center: {
                    lat: -34.397,
                    lng: 150.644,
                },

                zoom: 5,
                mapTypeId: google.maps.MapTypeId.HYBRID,
                disableDefaultUI: true
            });

            var id = <?php echo $_SESSION['cliente']; ?>;

            getSondas(id);
            getParcelas(id);
        }
        
    </script>

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


    <!-- JS de las parcelas -->

    <script type="text/javascript" src="js/parcelas.js"></script>

    <!-- JS del mapa -->

    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
    
    <!-- JS de las notificaciones -->

    <script src="js/push.min.js"></script>
    <script src="js/notificaciones.js"></script>

</body>

</html>
