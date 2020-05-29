<?php

    session_start(); //iniciamos la sesión.

    if(!isset($_SESSION['admin'])){  //Miramos si existe la variable de la sesión, que variará en función de la ID de cada cliente.

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
    <title>Administrador</title>
    <link rel="shortcut icon" href="media/Images/logo.ico">

    <!-- Font Awesome JS -->

    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- Bootstrap -->

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Menú -->

    <link rel="stylesheet" href="css/menu.css">

    <!-- Nuestro css -->

    <link rel="stylesheet" href="css/administrador.css">

</head>

<body style="overflow-y:hidden" onload="getUsuarios()">

    <div class="todo">

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <div class="container-fluid d-flex justify-content-between">

                    <a href="administrador.php" class="logo"><img src="media/Images/logoGTI.png" alt="gti" width="150px" height="65px"></a>

                    <a href="logout.php"><button type="button" class="btn btn-secondary cerrarSesion">Cerrar sesión</button></a>

                </div>
            </nav>
        </div>
    </div>

    <div class="contenedor-bloque-buscar">

        <a href="anyadirCliente.php"><button id="anyadirCliente" type="button" class="btn btn-primary">Añadir cliente</button></a>
        <input type="text" placeholder="Buscar cliente..." id="buscar" oninput="buscar()">
        <div class="multiselect">

        <div class="selectBox" onclick="showCheckboxes()">

            <select>

                <option>Filtrar:</option>

            </select>

            <div class="overSelect"></div>

        </div>

        <ul id="checkboxes" style="display: none">

            <li onclick="checkear('Nombre')">

                <div class="custom-control custom-switch">

                    <input type="checkbox" class="custom-control-input" id="Nombre" checked>
                    <label class="custom-control-label">Nombre</label>

                </div>
            </li>
            
            <li onclick="checkear('Apellidos')">

                <div class="custom-control custom-switch">

                    <input type="checkbox" class="custom-control-input" id="Apellidos" checked>
                    <label class="custom-control-label">Apellidos</label>

                </div>
            </li>
            
            <li onclick="checkear('Correo')">

                <div class="custom-control custom-switch">

                    <input type="checkbox" class="custom-control-input" id="Correo" checked>
                    <label class="custom-control-label">Correo</label>

                </div>
            </li>
            
            <li onclick="checkear('Localidad')">

                <div class="custom-control custom-switch">

                    <input type="checkbox" class="custom-control-input" id="Localidad" checked>
                    <label class="custom-control-label">Localidad</label>

                </div>
            </li>
            
            <li onclick="checkear('ID Cliente')">

                <div class="custom-control custom-switch">

                    <input type="checkbox" class="custom-control-input" id="ID Cliente" checked>
                    <label class="custom-control-label">ID Cliente</label>

                </div>
            </li>
            
            <li onclick="checkear('Nº de sondas')">

                <div class="custom-control custom-switch">

                    <input type="checkbox" class="custom-control-input" id="Nº de sondas" checked>
                    <label class="custom-control-label">Nº de sondas</label>

                </div>
            </li>
        </ul>
    </div>

    </div>
    <div id="clientes">

        <!-- Listado de parcelas -->

        <div class="scrollbar" id="style-1">

            <ul class="list-group" id="selector"></ul>

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

    <!-- Nuestro JS -->

    <script type="text/javascript" src="js/administrador.js"></script>

</body>

</html>
