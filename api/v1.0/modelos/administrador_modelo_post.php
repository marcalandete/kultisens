<?php
if($form_params['contrasenya'] == $form_params['contrasenyaRepetida']){
	//creamos la sentencia sql
	$sql='INSERT INTO `usuarios`(`nombre`,`apellido1`,`apellido2`,`email`,`contrasenya`,`localidad`,`tipo`) VALUES ("'.$form_params['nombre'].'","'.$form_params['apellido1'].'","'.$form_params['apellido2'].'","'.$form_params['correo'].'","'.$form_params['contrasenya'].'","'.$form_params['localidad'].'","'.$form_params['tipo'].'")';

	//lo subimos a la bd estableciendo conexion
	$resultado= mysqli_query($conexion,$sql);

	//cremos un array
	$json= array();
	//guardamos en el array un objeto id que obtenemos de la consulta sql realizada antes
	$json['id']= mysqli_insert_id($conexion);
}
else{
	//cremos un array
	$json= array();
	//guardamos en el array un objeto id que obtenemos de la consulta sql realizada antes
	$json['id']= 0;
}
?>
