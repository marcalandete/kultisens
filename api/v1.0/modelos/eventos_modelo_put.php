<?php

$sql = 'UPDATE `eventos` SET `idUsuario` ="'.$body_params['idUsuario'].'",`inicioEvento`="'.$body_params['inicioEvento'].'",`finalEvento`="'.$body_params['finalEvento'].'",`tituloEvento`="'.$body_params['tituloEvento'].'" WHERE `idEvento` = '.$body_params['id'];

var_dump($body_params['inicioEvento']);

$resultado = mysqli_query($conexion,$sql);
$json = array();

if($resultado === true) {
    $json['exito'] = true;
};