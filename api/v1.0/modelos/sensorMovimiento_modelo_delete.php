<?php

$sql="UPDATE `sensores`, sondas, usuarios, relaciones SET sensores.acelerometro = 0 WHERE sondas.id = sensores.idSonda AND sondas.parcela = relaciones.idParcela AND relaciones.idUsuario = usuarios.id AND usuarios.id =".$query_params['usuario'];

$resultado= mysqli_query($conexion,$sql);

	//cremos un array
$json= array();
	//guardamos en el array un objeto id que obtenemos de la consulta sql realizada antes
$json['id']= mysqli_insert_id($conexion);

$respuesta="200 OK";