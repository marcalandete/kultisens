<?php
    
    $sql= "SELECT id, parcela, nombreSonda, longitud, latitud FROM sondas, parcelas, relaciones WHERE parcelas.idParcelas=relaciones.idParcela AND parcelas.idParcelas= parcela AND relaciones.idUsuario= ".$query_params['usuario'];

    $resultado= mysqli_query($conexion,$sql);

    $json= array();

    while ($fila= mysqli_fetch_assoc($resultado)){

        array_push($json, $fila);    
    };

?>