<?php

$sql= "SELECT DISTINCT parcelas.idParcelas, parcelas.nombreParcela, parcelas.color, parcelas.cultivo FROM parcelas, relaciones r, usuarios WHERE parcelas.idParcelas NOT IN (SELECT parcelas.idParcelas FROM parcelas, usuarios, relaciones WHERE parcelas.idParcelas = relaciones.idParcela AND usuarios.id = relaciones.idUsuario AND usuarios.id =".$query_params['usuario'].")";

//$sql= "SELECT DISTINCT parcelas.idParcelas, parcelas.nombreParcela FROM `parcelas`, usuarios, relaciones WHERE parcelas.idParcelas NOT IN (SELECT parcelas.idParcelas FROM parcelas, usuarios, relaciones WHERE parcelas.idParcelas = relaciones.idParcela AND usuarios.id = relaciones.idUsuario AND usuarios.id =".$query_params['usuario'].")";


$resultado= mysqli_query($conexion,$sql);

$json= array();

    while ($fila= mysqli_fetch_assoc($resultado)){

        array_push($json, $fila);    
    };
?>