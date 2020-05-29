<?php

$sql= "SELECT p.nombreParcela, son.nombreSonda, son.id FROM parcelas p, sondas son, relaciones r WHERE p.idParcelas=r.idParcela AND son.parcela=p.idParcelas AND r.idUsuario= ".$query_params['usuario'];

$resultado= mysqli_query($conexion,$sql);

 $json= array();

    while ($fila= mysqli_fetch_assoc($resultado)){

        array_push($json, $fila);    
    };

?>
