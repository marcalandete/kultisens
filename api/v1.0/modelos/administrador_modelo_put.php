<?php
$sql = 'UPDATE `usuarios` SET `contrasenya`= "'.$body_params['contrasenya'].'", `localidad`= "'.$body_params['localidad'].'", `nombre`= "'.$body_params['nombre'].'", `apellido1`= "'.$body_params['apellido1'].'", `apellido2`= "'.$body_params['apellido2'].'", `email`= "'.$body_params['correo'].'", `tipo`= "'.$body_params['tipo'].'" WHERE `id`= "'.$body_params['id'].'"';

$resultado = mysqli_query($conexion,$sql);
$json = array();

if($resultado === true) {
    
    $json['exito'] = true;
};