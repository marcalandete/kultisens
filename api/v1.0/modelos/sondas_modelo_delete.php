<?php

$json = array();

$json['exito']= true;

$sql1= "DELETE FROM sondas WHERE id= ".$query_params['sonda'];
$sql2= "DELETE FROM sensores WHERE idSonda= ".$query_params['sonda'];

$resultado1 = mysqli_query ($conexion, $sql1);
$resultado2 = mysqli_query ($conexion, $sql2);

if($resultado1!== true || $resultado2!== true){
    
    $json['exito']= false;
}