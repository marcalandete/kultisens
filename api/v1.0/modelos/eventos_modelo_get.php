<?php

$sql= "SELECT * from eventos where idUsuario=".$query_params['usuario'];

$resultado= mysqli_query($conexion,$sql);

$json= array();

while ($fila= mysqli_fetch_assoc($resultado)){

    array_push($json, $fila);    
};
?>