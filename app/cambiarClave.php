<?php
require_once('../api/v1.0/includes/conexion.php');
$idCliente=$_GET['id'];
$sql="SELECT `id`,`email` FROM `usuarios` WHERE `id`='$idCliente' COLLATE utf8_bin";
$resultado = mysqli_query($conexion, $sql);
$fila=mysqli_fetch_assoc($resultado); //creas como arrays asociativos
$correo=$fila['email'];
?>
<!--hasta aqúi lo que haces es guardar variables y haces la consulta sql-->
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equip="x-ua-compatible" content="ie-edge">
	<title>Cambiar Contraseña</title>
	<link rel="shortcut icon" href="media/Images/logo.ico">
	<script type="text/javascript" src="js/ojo.js"> </script>
	<!--añades una función javascript externa-->
	<link rel="shortcut icon" href="media/Images/logo.ico">
	<!-- BOOTSTRAP CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel=stylesheet type="text/css" href="css/cambiarClave.css">
	<!--añades una función externa css-->
</head>

<body>
	<header>
		<a href="#"><img src="media/Images/logoGTI.png" class="logo" alt="hola"></a>
		<nav>
			<ul>
				<li>
					<a href="index.php">
						<div class="btn-group">
							<button type="button" class="btn "><i class="fas fa-sign-out-alt"></i></button>
						</div>
					</a>
				</li>
			</ul>
		</nav>
	</header>

	<section class="modal-body">
		<h2>Cambiar contraseña</h2>

		<div class="container">
			<div class="row">
				<div class="col-10 offset-1 col-lg-6 offset-lg-3">
					<div>
						<?php
        				if(isset($_GET["error"]))
        				{
            				echo"<div class='alert alert-danger', role='alert';><strong>¡Error!</strong> Las dos contraseñas introducidas no coinciden.</div>";
        				}
        				?>
						<!--mostramos un error en caso de que las dos contraseñas sean iguales-->
					</div>
					<form action="guardarClave.php" method="post">
						<input type="hidden" name="id" value="<?php echo $idCliente;?>">
						<!------------email-------------------------->
						<div class="contenedor-recuperar1">
							<img class="mail" src="media/Images/iconfinder_008_Mail_183573.svg">
							<h4 class="fondoVerde">Correo electrónico:</h4>
						</div>
						<input class="campoC" type="email" placeholder="E-mail" value="<?php echo $correo;?>" readonly>
						<!------------contraseña-------------------------->
						<div class="contenedor-recuperar1">
							<img class="mail" src="media/Images/password.svg">
							<h4 class="fondoVerde">Contraseña:</h4>
						</div>
						<div class="container">
							<div class="row">
								<input id="psw1" class="col-6 campo" type="password" placeholder="Nueva contraseña" name="clave" required>
								<label><img id="eye1" src="media/Images/iconfinder_icon-21-eye-hidden_314858.svg" onclick="mostrarClave1()"></label>
								<input id="psw2" class="col-6 campo" type="password" placeholder="Repetir contraseña" name="repetirClave" required>
								<label><img id="eye2" src="media/Images/iconfinder_icon-21-eye-hidden_314858.svg" onclick="mostrarClave2()"></label>
							</div>
						</div>
						<div class="botones">
							<a class="volver-login" href="/./index.php">Cancelar</a>
							<input class="boton-enviar" type="submit" value="Cambiar Datos">

						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
    if(mysqli_num_rows($resultado) > 0) 
    {
        $fila = mysqli_fetch_assoc($resultado);
    ?>
		<!--miras si existe la variable y creas fila para poder acceder a cada elemento-->


		<?php
    }
    else 
    {
        echo "No se encontró el usuario";
    }
    ?>
	</section>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>
