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
	<title>Ajustes Usuario</title>
	<link rel="shortcut icon" href="media/Images/logo.ico">
	<!-- Font Awesome JS -->

	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="css/ajustesUsuario.css">
	<!-- Menú -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="css/menu.css">
</head>

<body onload="getUsuarios(<?php echo $_SESSION['cliente']?>)">
	<div class="todo">
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

						<a href="notificaciones.php">Notificaciones</a>

					</li>
					<li>

						<a href="contacto.php">Contacto</a>

					</li>
					<li>

						<span class="active"><a href="ajustesUsuario.php">Ajustes</a></span>

					</li>
					<li>

						<a href="logout.php">Cerrar sesión</a>

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
	</div>
	<section id="tabs">
		<div class="container">
			<div class="row">
				<div style="width: 100%;" class="col-xs-12 ">
					<nav>
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Editar perfil</a>
							<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Editar parcelas</a>
							<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Editar sondas</a>
						</div>
					</nav>
					<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
							<div class="container">
								<div class="row">
									<div class="col-10 offset-1 col-lg-6 offset-lg-3">
										<div style='display: none' id='alerta' class='alert alert-danger' , role='alert'><strong>¡Error!</strong>Las dos contraseñas introducidas no coinciden.</div>
										<form id="crearUsuario" onsubmit="return editarPerfil(this)">
											<!------------nombre y apellidos-------------------------->
											<div class="contenedor-recuperar1">
												<img class="mail" src="media/Images/user.svg">
												<h4 class="fondoVerde">Nombre y apellidos:</h4>
											</div>
											<input class=" col-12 campoC" type="text" placeholder="Nombre" readonly>
											<div class="container">
												<div class="row">
													<input class="col-6 campoC separados" type="text" placeholder="Primer apellido" readonly>

													<input class="col-6 campoC separados dosInputs" type="text" placeholder="Segundo apellido" readonly>
												</div>
											</div>
											<!------------email-------------------------->
											<div class="contenedor-recuperar1">
												<img class="mail" src="media/Images/iconfinder_008_Mail_183573.svg">
												<h4 class="fondoVerde">Correo electrónico:</h4>
											</div>
											<input class="col-12 campoC" type="text" placeholder="Correo electrónico" readonly>
											<!--insertamos automáticamente en el correo electrónico-->
											<!------------contraseña-------------------------->
											<div class="contenedor-recuperar1">
												<img class="mail" src="media/Images/password.svg">
												<h4 class="fondoVerde">Contraseña:</h4>
												<img class="lapiz imagen1" src="media/Images/lapiz.png" onclick="cambiar(1)">
											</div>
											<div class="container">
												<div class="row">
													<input class="col-6 lapiz1 separados" type="password" placeholder="Nueva contraseña" name="contrasenya" readonly>
													<input class="col-6 lapiz1 separados dosInputs"type="password" placeholder="Nueva contraseña" name="contrasenyaCheck" readonly>
												</div>
											</div>
											<!------------localidad-------------------------->
											<div class="contenedor-recuperar1">
												<img class="mail" src="media/Images/location.svg">
												<h4 class="fondoVerde">Localidad:</h4>
												<img class="lapiz imagen2" src="media/Images/lapiz.png" onclick="cambiar(2)">
											</div>
											<input class="col-12 lapiz2" type="text" name="localidad" readonly>
											<div class="botones">
												<button class="boton-enviar" id="enviar" type="submit">Guardar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
							<div style='display: none;' id="exitoEditarParcela" class='alert alert-warning' role='alert'><strong>¡Enhorabuena!</strong> Modificación correcta.</div>

							<div class="editarParcelas">
								<div class="scrollbar" id="style-1">
									<ul class="list-group" id="listaParcelas1">

									</ul>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
							<div style='display: none;' id="exitoEditarSonda" class='alert alert-warning' role='alert'><strong>¡Enhorabuena!</strong> Modificación correcta.</div>

							<div class="editarSondas">
								<div class="scrollbar" id="style-1">
									<ul class="list-group" id="listaSondas">

									</ul>
								</div>
							</div>
							<hr>
						</div>
					</div>

				</div>
			</div>

		</div>
	</section>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

	<!-- Popper -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

	<!-- Bootstrap -->

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

	<!-- jQuery Custom Scroller -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

	<!-- Menú -->

	<script type="text/javascript" src="js/menu.js"></script>

	<!-- JS de la página -->
	<script type="text/javascript" src="js/ajustesUsuario.js"></script>

	<script>
		getParcelas(<?php echo $_SESSION['id'] ?>);
		getSondas(<?php echo $_SESSION['id'] ?>);

	</script>
</body>

</html>
