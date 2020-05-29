<?php

    session_start(); //iniciamos la sesión.

    if(!isset($_SESSION['admin'])){  //Miramos si existe la variable de la sesión, que variará en función de la ID de cada cliente.

        header("location:login.php");
    }

    else{
        
		require_once "../api/v1.0/includes/conexion.php"; 
		$id=$_GET['id'];
		$sql="SELECT * FROM `usuarios` WHERE `id`=".$id;
		$resultado=mysqli_query($conexion,$sql);
		$fila=mysqli_fetch_assoc($resultado);
	};
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no user-scalable=no, maximum-scale=1">
	<meta http-equip="x-ua-compatible" content="ie-edge">
	<title>Ajustes</title>
	<link rel="shortcut icon" href="media/Images/logo.ico">
	<!-- Font Awesome JS -->

	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="css/ajustes.css">
	<!-- Menú -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="css/menu.css">

</head>

<body onload="enviar(<?php echo $_GET['id'] ?>)">

	<div class="todo">
		<!-- Page Content  -->
		<div id="content">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">

				<div class="container-fluid d-flex justify-content-between">

					<a href="administrador.php" class="volver_inicio"><img src="media/Images/logoGTI.png" alt="volver al inicio" width="150px" height="65px"></a>
					<div class="menuDos">

						<a href="logout.php"><button type="button" class="btn btn-secondary cerrarSesion">Cerrar sesión</button></a>
						<a href="administrador.php" class="volver_inicio"><i class="fas fa-home"></i></a>

					</div>

				</div>

			</nav>
		</div>
	</div>
	<section id="tabs">
		<div class="container">
			<div class="row">
				<div style="width: 100%;" class="col-xs-12 ">
					<nav>
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Editar perfil</a>
							<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Editar/añadir parcelas</a>
							<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Editar/añadir sondas</a>
						</div>
					</nav>
					<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
							<div class="container">
								<div class="row">
									<div class="col-10 offset-1 col-lg-6 offset-lg-3">
										<div style='display: none;' id='alerta' class='alert alert-danger' , role='alert'><strong>¡Error!</strong>Las dos contraseñas introducidas no coinciden.</div>
										<div style='display: none;' id="exito" class='alert alert-warning' role='alert'><strong>¡Enhorabuena!</strong> Modificación correcta.</div>
										<form id="crearUsuario" onsubmit="return editarPerfil(this)">
											<input type='hidden' name='id' value="<?php echo $id; ?>">
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
											<input class="campo" type="email" placeholder="E-mail" name="correo" required>
											<!------------contraseña-------------------------->
											<div class="contenedor-recuperar1">
												<img class="mail" src="media/Images/password.svg">
												<h4 class="fondoVerde">Contraseña:</h4>
											</div>
											<div class="container">
												<div class="row">
													<input id="psw1" class="col-6 campo separados" type="password" placeholder="Contraseña" name="contrasenya" required>
													<label><img id="eye1" src="media/Images/iconfinder_icon-21-eye-hidden_314858.svg" onclick="mostrarClave1()"></label>
													<input id="psw2" class="col-6 campo separados" type="password" placeholder="Repetir contraseña" name="contrasenyaRepetida" required>
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
												<a onclick="window.location.reload();" class="volver-login">Cancelar</a>
												<button class="boton-enviar" type="submit">Guardar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
							<div style='display: none;' id="exitoEditarParcela" class='alert alert-warning' role='alert'><strong>¡Enhorabuena!</strong> Modificación correcta.</div>

							<div class="editarParcelas">
								<h3>Editar</h3>
								<div class="scrollbar" id="style-1">
									<ul class="list-group" id="listaParcelas1">

									</ul>
									<!-- Modal -->
									<div class="modal" id="mapaParcela" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content" style="margin: 10px;">
												<div id="map"></div>
												<div class="botones">
													<button class="boton-cancelar" data-dismiss="modal">Cancelar</button>
													<button class="boton-enviar" onclick="actualizarVertices()" data-dismiss="modal">Actualizar vértices</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="añadirParcelas">
								<h3>Añadir</h3>
								<div class="scrollbar" id="style-1">

									<ul class="list-group" id="listaParcelas2">
									</ul>
								</div>
							</div>

							<div class="crearParcelas">
								<h3>Crear</h3>
								<div style='display: none;' id='error-vertices' class='alert alert-danger' , role='alert'>Inserta un número mayor que 3 para poder dibujar un poligono.</div>

								<form id="crearParcela" onsubmit="return crearParcela(this)">

									<input type='hidden' name='id' value="<?php echo $id; ?>">
									<div class="container">
										<div class="row">
											<div class="col-6 col-md-4">
												<!------------Nombre Parcela-------------------------->
												<div class="contenedor-recuperar1">

													<img class="mail" src="media/Images/tipo.png">
													<h4 class="fondoVerde">Nombre parcela:</h4>

												</div>
												<input class="campo" type="text" placeholder="Nombre de la parcela" name="nombreParcela" required>
											</div>
											<div class="col-6 col-md-4">
												<!------------Cultivo-------------------------->
												<div class="contenedor-recuperar1">

													<img class="mail" src="media/Images/fruta.svg">
													<h4 class="fondoVerde">Tipo de cultivo:</h4>

												</div>
												<input class="campo" type="text" placeholder="Tipo de cultivo" name="cultivo" required>
											</div>
											<div class="col-6 col-md-2">
												<!------------color-------------------------->
												<div class="contenedor-recuperar1">

													<img class="mail" src="media/Images/color.svg">
													<h4 class="fondoVerde">Color del mapa:</h4>
												</div>

												<input type="color" name="color" class="form-control campo">
											</div>
											<div class="col-6 col-md-2">
												<!------------vertices-------------------------->

												<div class="contenedor-recuperar1">
													<img class="mail" src="media/Images/location.svg">
													<h4 class="fondoVerde">Vertices:</h4>
												</div>
												<input class="campo" type="number" placeholder="Nº de vertices" id="vertices" value="3">



											</div>
											<div class="scrollbar" id="style-1">

												<div class="container" id="contenedor-vertices">

													<div class="row" id="contenedorNuevosVertices">
													<div class="col-12">
														<h4 class="fondoVerde">Vértice 0</h4>
													</div>
														<div class="col-12 col-xl-6 serie">
															<div class="col-6 col-md-4">
															<h4 class="fondoVerde2">Longitud:</h4><input class="campo separadosVertices" type="number" placeholder="Longitud" name="longitud0" step="any" required>
															</div>
															<div class="col-6 col-md-4">
															<h4 class="fondoVerde2">Latitud:</h4><input class="campo separadosVertices" type="number" placeholder="Latitud" name="latitud0" step="any" required>
															</div>
														</div>
														<div class="col-12">
															<h4 class="fondoVerde">Vértice 1</h4>
														</div>
														<div class="col-12 col-xl-6 serie">
															<div class="col-6 col-md-4">
																<h4 class="fondoVerde2">Latitud:</h4><input class="campo separadosVertices" type="number" placeholder="Latitud" name="latitud1" step="any" required>
															</div>
															<div class="col-6 col-md-4">
																<h4 class="fondoVerde2">Longitud:</h4><input class="campo separadosVertices" type="number" placeholder="Longitud" name="longitud1" step="any" required>
															</div>
														</div>
														<div class="col-12">
															<h4 class="fondoVerde">Vértice 2</h4>
														</div>
														<div class="col-12 col-xl-6 serie">
															<div class="col-6 col-md-4">
																<h4 class="fondoVerde2">Latitud:</h4><input class="campo separadosVertices" type="number" placeholder="Latitud" name="latitud2" step="any" required>
															</div>
															<div class="col-6 col-md-4">
																<h4 class="fondoVerde2">Longitud:</h4><input class="campo separadosVertices" type="number" placeholder="Longitud" name="longitud2" step="any" required>
															</div>
														</div>
													</div>

												</div>

											</div>

										</div>
									</div>

									<button class="boton-enviar2 botones" type="submit">Guardar</button>

								</form>
							</div>
						</div>
						<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
							<div style='display: none;' id="exitoEditarSonda" class='alert alert-warning' role='alert'><strong>¡Enhorabuena!</strong> Modificación correcta.</div>

							<div class="editarSondas">
								<h3>Editar</h3>

								<div class="scrollbar" id="style-1">

									<ul class="list-group" id="listaSondas"> </ul>

								</div>
							</div>
							<hr>

							<div class="crearSondas">

								<h3>Crear</h3>

								<form id="crearSonda" onsubmit="return crearSonda(this)">

									<input type='hidden' name='id' value="<?php echo $id; ?>">
									<div class="container">
										<div class="row">
											<div class="col-6 col-md-4">
												<!------------Nombre Sonda-------------------------->
												<div class="contenedor-recuperar1">

													<img class="mail" src="media/Images/tipo.png">
													<h4 class="fondoVerde">Nombre:</h4>

												</div>
												<input class="campo" type="text" placeholder="Nombre de la sonda" name="nombreSonda" required>
											</div>
											<div class="col-6 col-md-3">
												<!------------Parcela-------------------------->
												<div class="contenedor-recuperar1 paralelos">
													<div class="serie">
														<img class="mail" src="media/Images/location.svg">
														<h4 class="fondoVerde">Parcela:</h4>
													</div>


													<select class="campo" name="parcela" id="Sondas">

													</select>

												</div>
											</div>
											<!------------vertices-------------------------->
											<div class="col-12 col-md-5">
												<div class="contenedor-recuperar1">

													<img class="mail" src="media/Images/tipo.png">
													<h4 class="fondoVerde">Vertices:</h4>

												</div>
												<div class="serie">
													<!-- <h4 class="fondoVerde">Latitud:</h4> --><input class="campo separadosVertices" type="number" placeholder="Latitud" name="latitud" step="any" required>

													<!-- <h4 class="fondoVerde">Longitud:</h4> --><input class=" campo separadosVertices" type="number" placeholder="Longitud" name="longitud" step="any" required>

												</div>
											</div>
										</div>
										<button class="boton-enviar2 botones" type="submit">Guardar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/ajustes.js"></script>
	<!-- JS del mapa -->


	<script>
		var map;

		function initMap() {

			map = new google.maps.Map(document.getElementById('map'), {

				center: {
					lat: 38.934247863156585,
					lng: -0.18875101880803413
				},

				zoom: 18,
				mapTypeId: google.maps.MapTypeId.HYBRID,
				disableDefaultUI: true
			});
		}
		getParcelas(<?php echo $_GET['id'] ?>);
		getParcelas2(<?php echo $_GET['id'] ?>);
		getSondas(<?php echo $_GET['id'] ?>);

	</script>
	<!-- JS del mapa -->
	
	<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>

</body>

</html>
