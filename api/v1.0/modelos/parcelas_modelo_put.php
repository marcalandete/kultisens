<?php

$json = array();
$json['exito'] = true;

//Actualizamos todos los valores editables de la parcela menos los vertices.

$sql = 'UPDATE `parcelas` SET `nombreParcela`= "'.$body_params['nombreParcela'].'", `color`= "'.$body_params['color'].'", `cultivo`= "'.$body_params['cultivo'].'" WHERE `idParcelas`= "'.$body_params['idP'].'"';

$resultado = mysqli_query($conexion,$sql);

if($resultado === false) {
    
    $json['exito'] = false;
};

//Obtenemos los vertices anteriores de esa parcela

$sql_ = "SELECT idPosicion FROM posiciones WHERE idPos=".$body_params['idP'];

$resultado_ = mysqli_query($conexion,$sql_);

$respuesta= array();

while ($fila= mysqli_fetch_assoc($resultado_)){

    array_push($respuesta, $fila);    
};

$aux= 0;

$vertices= $body_params['vertices'];

//Recorremos cada uno de los vertices y lo modificamos

for($i=0; $i< count($respuesta); $i++){
                
    $sql__ = 'UPDATE `posiciones` SET `latitud`= "'.$vertices[$aux].'", `longitud`= "'.$vertices[$aux+1].'" WHERE `idPosicion`= "'.$respuesta[$i]['idPosicion'].'"';
    
    $resultado__ = mysqli_query($conexion,$sql__);
    
    if($resultado__ === false){
        
        $json['exito'] = false;
    }
    
    $aux= $aux +2;
}