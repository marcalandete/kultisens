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
	<title>Parcelas</title>
	<link rel="shortcut icon" href="media/Images/logo.ico">

	<!-- Font Awesome JS -->

	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

	<!-- Bootstrap -->

	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Menú -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="css/barra_menu_datos_admin.css">

	<!-- Nuestro css -->

	<link rel="stylesheet" href="css/mapas_admin.css">

</head>

<body style="overflow-y:hidden">


	<!-- Page Content  -->

	<div class="todo">
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

			<script>

			</script>
			<!-- tabs para poder cambiar entre las páginas de visualización de datos del cliente seleccionado-->

		</div>
	</div>
	<!-- insertada la página de mapas  ya que el método de visualización es el mismo -->
	<div class="overlay"></div>
	<section id="tabs">
		<div class="container">
			<div class="row">
				<div style="width: 100%;" class="col-xs-12 ">
					<nav>
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Visualizar parcelas</a>
							<a onclick="redirigir()" class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Visualizar sondas</a>
						</div>
					</nav>
					<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
							<div id="map"></div>
							<div class="overlay"></div>
							<div>
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

							</div>


						</div>
						<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
							<script>
								function redirigir() {
									location.href = "datos_admin.php?idUsuario=<?php echo $_GET['idUsuario']; ?>"
								}

							</script>
						</div>
					</div>

				</div>
			</div>

		</div>
	</section>

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

			/* le pasamos al js el idUsuario recogido de la url */
			var id = <?php echo $_GET['idUsuario'];?>;

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

	<!-- JS de las parcelas -->

	<script type="text/javascript" src="js/parcelas_admin.js"></script>

	<!-- JS del mapa -->

	<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>

	<!-- JS de las gráficas -->

	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script>
		/* le pasamos al js el idUsuario recogido de la url */
		var grafica = conexion(<?php echo $_GET['idUsuario'].$idSonda; ?>);

	</script>

</body>

</html>
