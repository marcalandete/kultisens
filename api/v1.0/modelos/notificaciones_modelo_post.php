<?php
//creamos la sentencia sql
	$sql='INSERT INTO `notificaciones`VALUES (NULL,"'.$form_params['idUsuario'].'","'.$form_params['titulo'].'","'.$form_params['tipo'].'","'.$form_params['descripcion'].'")';

//lo subimos a la bd estableciendo conexion
	$resultado= mysqli_query($conexion,$sql);

	//cremos un array
	$json= array();
	//guardamos en el array un objeto id que obtenemos de la consulta sql realizada antes
	$json['id']= mysqli_insert_id($conexion);