<?php
$sql = 'UPDATE `sondas` SET `nombreSonda` ="'.$body_params['nombreSonda'].'",`latitud`="'.$body_params['latitud'].'",`longitud`="'.$body_params['longitud'].'" WHERE `id` = "'.$body_params['idS'].'"';

$resultado = mysqli_query($conexion,$sql);
$json = array();

if($resultado === true) {
    
    $json['exito'] = true;
};