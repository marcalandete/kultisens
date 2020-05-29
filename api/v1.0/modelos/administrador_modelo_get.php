<?php

$sql= "SELECT * FROM usuarios WHERE tipo= 0";

$resultado= mysqli_query($conexion,$sql);

$json= array();

    while ($fila= mysqli_fetch_assoc($resultado)){

        array_push($json, $fila);    
    };
?>