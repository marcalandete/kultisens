<?php

$sql="SELECT sensores.idSonda, sondas.parcela ,sondas.nombreSonda ,sensores.acelerometro FROM `sensores`, sondas, relaciones, usuarios WHERE sondas.id = sensores.idSonda AND sondas.parcela = relaciones.idParcela AND relaciones.idUsuario = usuarios.id AND usuarios.id = ". $query_params['usuario']." ORDER BY `sensores`.`dateTime`  DESC";

$resultado=mysqli_query($conexion,$sql);

if ($resultado) {
    $json = array(); //creamos un array

    //guardamos en un array multidimensional todos los datos de la consulta

    while($row = mysqli_fetch_array($resultado)){
        array_push($json,$row);
    }

}

