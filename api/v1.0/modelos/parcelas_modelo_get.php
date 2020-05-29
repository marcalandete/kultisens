<?php
if ($query_params['usuario'] == "dios") {
    $sql= "SELECT pos.idPos, pos.latitud, pos.longitud, p.idParcelas, p.nombreParcela, p.color, p.cultivo FROM parcelas p, posiciones pos, relaciones r WHERE p.idParcelas=r.idParcela AND pos.idPos=p.posiciones";
}else{

    $sql= "SELECT pos.idPos, pos.latitud, pos.longitud, p.idParcelas, p.nombreParcela, p.color, p.cultivo FROM parcelas p, posiciones pos, relaciones r WHERE p.idParcelas=r.idParcela AND pos.idPos=p.posiciones AND r.idUsuario= ".$query_params['usuario'];
}


$resultado= mysqli_query($conexion,$sql);

$json= array();

    while ($fila= mysqli_fetch_assoc($resultado)){

        array_push($json, $fila);    
    };
?>