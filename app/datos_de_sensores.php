<?php
    session_start(); //iniciamos la sesión.
    $idSonda ="";
    if(!isset($_SESSION['id'])){  //Miramos si existe la variable de la sesión, que variará en función de la ID de cada cliente.
        header("location:login.php");
    }else{
        if (isset($_GET['idSonda'])) {
            $idSonda = ",".$_GET['idSonda'] ;
        }
    }
    ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no user-scalable=no, maximum-scale=1">
    <meta http-equip="x-ua-compatible" content="ie-edge">
    <title>Gráficos</title>
    <link rel="shortcut icon" href="media/Images/logo.ico">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/menu.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/datosSensores.css">
    <!-- FUTURE añadir css -->
    <script type="text/javascript" src="js/datosSensores.js"></script>
    <script type="text/javascript" src="js/menu.js"></script>

</head>

<body>

    <div class="todo">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-right"></i>
            </div>

            <div class="sidebar-header">
                <p>
                    <?php
                
                echo $_SESSION['nombre']."<br>";
                echo $_SESSION['apellido1'].' '.$_SESSION['apellido2'];
                
                ?>
                </p>

                <img src="media/Images/profile.png" alt="perfil" width="50px" height="50px">
            </div>

            <ul class="list-unstyled components">

                <li>
                    <a href="paginaPrincipal.php">Inicio</a>
                </li>
                <li>
                    <span class="active"><a href="datos_de_sensores.php">Datos de sensores</a></span>
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

        <div class="overlay"></div>

        <input type="checkbox" class="checkbox" id="check">

        <label class="menu" for="check">SELECCIONAR SONDA</label>

        <div class="left-panel">

            <fieldset class="seleccion">

                <h4> Visualice y compare sus sondas: </h4>

                <input type="text" placeholder="Buscar sonda..." id="buscar" oninput="buscar()">
                
                <div class="scrollbar" id="style-1">
                    <ul class="list-group" id="ul-parcelas"></ul>
                </div>

            </fieldset>
        </div>

        <div id="contenedor">

            <!-- Selector con la selección de días -->

            <form action="" name="formPeriodo" onsubmit="return seleccionPeriodo(this)" class="horas">

                <select class="custom-select" onchange="seleccionarParcela()">
                   
                    <!--<option selected>Selecciona las horas</option>-->
                    <option class="listaInputs" id="seisHoras" value="6">Últimas 6h</option>
                    <option class="listaInputs" id="doceHoras" value="12">Últimas 12h</option>
                    <option class="listaInputs" id="todoElDia" value="24" disabled>Últimas 24h</option>
                    <option class="listaInputs" id="todaLaSemana" value="168" disabled>Última semana</option>
                    <option class="listaInputs" id="todoElMes" value="744" disabled>Último mes</option>
                </select>
                
            </form>

            <!-- El grupo de botones para la selección del sensor: -->

            <form action="" name="formTipoMedicion" onsubmit="return seleccionTipoMedicion(this)">

                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="options" class="listaInputs" id="humedad" onchange="seleccionarParcela()" autocomplete="off" checked>
                        <img src="media/Images/aguaW.png">
                    </label>
                    <label class="btn btn-secondary" for="iluminacion" onchange="seleccionarParcela()">
                        <input type="radio" name="options" class="listaInputs" id="iluminacion" autocomplete="off">
                        <img src="media/Images/creativeW.png">

                    </label>
                    <label class="btn btn-secondary" onchange="seleccionarParcela()">
                        <input type="radio" name="options" class="listaInputs" id="presion" autocomplete="off">
                        <img src="media/Images/pressureW.png">
                    </label>
                    <label class="btn btn-secondary" onchange="seleccionarParcela()">
                        <input type="radio" name="options" class="listaInputs" id="temperatura" autocomplete="off">
                        <img src="media/Images/thermometerW.png">
                    </label>
                    <label class="btn btn-secondary" onchange="seleccionarParcela()">
                        <input type="radio" name="options" class="listaInputs" id="salinidad" autocomplete="off">
                        <img src="media/Images/iconW.png">
                    </label>
                </div>
            </form>
        </div>
		<div style='display: block' id='alerta' class='alert alert-warning' , role='alert'><strong>No hay sondas seleccionadas.</strong> Seleccione una o más.</div>
        <canvas id="myChart"></canvas>

    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- MENU -->
    <script type="text/javascript" src="js/menu.js"></script>
    
        <script type="text/javascript" src="js/datosSensores.js"></script>


    <!-- CHART -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!-- Menú -->

    <script type="text/javascript" src="js/menu.js"></script>
    <script>
        
        var grafica = conexion(<?php echo $_SESSION['id']. $idSonda; ?>)

    </script>

</body>

</html>
