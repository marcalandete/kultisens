<?php

$inicio= $form_params['inicioEventoAño'] . "-" . $form_params['inicioEventoMes'] . "-" . $form_params['inicioEventoDia'] . " " . $form_params['inicioEventoHora'] .  ":00";

$final= $form_params['finalEventoAño'] . "-" . $form_params['finalEventoMes'] . "-" . $form_params['finalEventoDia'] . " " . $form_params['finalEventoHora'] .  ":00";

$sql= 'INSERT INTO `eventos`(`idUsuario`,`idEvento`,`inicioEvento`,`finalEvento`, `tituloEvento`) VALUES ("'.$form_params['idUsuario'].'",NULL , "'.$inicio.'", "'.$final.'", "'.$form_params['tituloEvento'].'")';

$resultado= mysqli_query($conexion,$sql);

$json= array();

if ($resultado === "true"){
    
    $json['exito'] = true;
}
