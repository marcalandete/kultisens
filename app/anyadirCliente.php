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
	<link rel="shortcut icon" href="media/Images/logo.ico">
	<title>Añadir Cliente</title>
	<link rel="shortcut icon" href="media/Images/logo.ico">
	<!-- Font Awesome JS -->

	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/all.min.css">
	<!-- Menú -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="css/menu.css">
	<!-- Nuestro css -->
	<link rel="stylesheet" href="css/anyadirCliente.css">
</head>

<body>
	<div class="todo">
		<!-- Page Content  -->
		<div id="content">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">

				<div class="container-fluid d-flex justify-content-between">

					<a href="administrador.php" class="logo"><img src="media/Images/logoGTI.png" alt="gti" width="150px" height="65px"></a>
					<div class="menuDos">

						<a href="logout.php"><button type="button" class="btn btn-secondary">Cerrar sesión</button></a>
						<a href="administrador.php" class="volver_inicio"><i class="fas fa-home"></i></a>

					</div>

				</div>
			</nav>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-10 offset-1 col-lg-6 offset-lg-3">
					<div style='display: none;' id='alerta' class='alert alert-danger' , role='alert'><strong>¡Error!</strong>Las dos contraseñas introducidas no coinciden.</div>
					<div style='display: none;' id="exito" class='alert alert-warning' role='alert'><strong>¡Enhorabuena!</strong> Ha creado el usuario correctamente.</div>
					<form id="crearUsuario" onsubmit="return crearUsuario(this)">
						<!------------nombre y apellidos-------------------------->
						<div class="contenedor-recuperar1">
							<img class="mail" src="media/Images/user.svg">
							<h4 class="fondoVerde">Nombre y apellidos:</h4>
						</div>
						<input class="campo" type="text" placeholder="Nombre del cliente" name="nombre" required>
						<div class="container">
							<div class="row">
								<input class="col-6 campo separados" type="text" placeholder="Primer apellido" name="apellido1" required>
								<input id="dosInputs" class="col-6 campo separados" type="text" placeholder="Segundo apellido" name="apellido2">
							</div>
						</div>
						<!------------email-------------------------->
						<div class="contenedor-recuperar1">
							<img class="mail" src="media/Images/iconfinder_008_Mail_183573.svg">
							<h4 class="fondoVerde">Correo electrónico:</h4>
						</div>
						<input class="campo" type="email" placeholder="E-mail" name="correo" required autocomplete="off">
						<!------------contraseña-------------------------->
						<div class="contenedor-recuperar1">
							<img class="mail" src="media/Images/password.svg">
							<h4 class="fondoVerde">Contraseña:</h4>
						</div>
						<div class="container">
							<div class="row">
								<input id="psw1" class="col-6 campo separados" type="password" placeholder="Contraseña" name="contrasenya" required autocomplete="off">
								<label><img id="eye1" src="media/Images/iconfinder_icon-21-eye-hidden_314858.svg" onclick="mostrarClave1()"></label>
								<input id="psw2" class="col-6 campo separados" type="password" placeholder="Repetir contraseña" name="contrasenyaRepetida" required autocomplete="off">
								<label id="desplazado"><img id="eye2" src="media/Images/iconfinder_icon-21-eye-hidden_314858.svg" onclick="mostrarClave2()"></label>
							</div>
						</div>
						<!------------localidad-------------------------->
						<div class="contenedor-recuperar1">
							<img class="mail" src="media/Images/location.svg">
							<h4 class="fondoVerde">Localidad:</h4>
						</div>
						<input class="campo" type="text" placeholder="Localidad" name="localidad" required>
						<!------------tipo-------------------------->
						<div class="contenedor-recuperar1">
							<img class="mail" src="media/Images/tipo.png">
							<h4 class="fondoVerde">Tipo:</h4>
							<select class="campo" name="tipo" id="seleccion">
								<option value="0">Cliente</option>
								<option value="1">Administrador</option>
							</select>
						</div>
						<div class="botones">
							<a href="administrador.php" class="volver-login">Cancelar proceso</a>
							<button class="boton-enviar" type="submit">Guardar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/anyadirCliente.js"></script>
</body>

</html>
