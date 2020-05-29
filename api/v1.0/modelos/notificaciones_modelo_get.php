<?php
    
    $sql= "SELECT notificaciones.* FROM `notificaciones`, usuarios WHERE notificaciones.idUsuario = usuarios.id AND usuarios.id = ".$query_params['usuario'];

    $resultado= mysqli_query($conexion,$sql);

    $json= array();

    while ($fila= mysqli_fetch_assoc($resultado)){

        array_push($json, $fila);    
    };

?>