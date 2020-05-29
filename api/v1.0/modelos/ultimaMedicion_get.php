<?php

$sql="SELECT sondas.id, sondas.nombreSonda, sensores.dateTime, sensores.temperatura, sensores.humedad, sensores.presion, sensores.iluminacion, sensores.salinidad FROM `sensores`, sondas, relaciones, usuarios WHERE sondas.id = sensores.idSonda AND sondas.parcela = relaciones.idParcela AND relaciones.idUsuario = usuarios.id AND sondas.nombreSonda = "."'".$query_params['sonda']."' ORDER BY `sensores`.`dateTime` DESC";

$resultado=mysqli_query($conexion,$sql);

if ($resultado) {
    
    $respuestaTemporal = array(); //creamos un array
    $respuesta = array();
    //guardamos en un array multidimensional todos los datos de la consulta

    while($row = mysqli_fetch_array($resultado)){
        
      array_push($respuestaTemporal,$row);
  };
    
array_push($respuesta,$respuestaTemporal[0]);
    
};