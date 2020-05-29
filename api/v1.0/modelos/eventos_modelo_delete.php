<?php

$json = array();

$json['exito']= true;

$sql= "DELETE FROM eventos WHERE idEvento= ".$query_params['idEvento'];

$resultado = mysqli_query ($conexion, $sql);

if($resultado === true){
    
    $json['exito']= true;
}