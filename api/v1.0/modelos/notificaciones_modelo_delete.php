<?php

$sql="DELETE FROM `notificaciones` WHERE `notificaciones`.`idNotificacion` =".$query_params['idNotificacion'];

$resultado= mysqli_query($conexion,$sql);

	//cremos un array
$json= array();
	//guardamos en el array un objeto id que obtenemos de la consulta sql realizada antes
$json['id']= mysqli_insert_id($conexion);