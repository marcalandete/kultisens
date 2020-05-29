<?php

$json = json_decode($query_params['json']);

$numeroSensores = sizeof($json->id);
$condicionesSQL ="WHERE";

for ($i=0; $i < $numeroSensores; $i++) { 
    $condicionesSQL .=" sensores.idSonda='".$json->id[$i]."' ";
    if ($i != ($numeroSensores-1)) {
        $condicionesSQL .= "OR";
    }
}

switch ($json->nombre) {
    case 'seisHoras':
        
        $periodo=(13*$numeroSensores);
        break;
    
    case 'doceHoras':
        
        $periodo=(25*$numeroSensores);
        break;
    default:
        # code...
        break;
}

$sql="SELECT sensores.idSonda, sensores.dateTime, sensores.".$json->tipoMedicion ."  FROM sensores ".$condicionesSQL ."ORDER BY sensores.dateTime DESC LIMIT " .$periodo;

$resultado= mysqli_query($conexion,$sql);

if ($resultado) {
    
    $respuesta = array(); //creamos un array

    //guardamos en un array multidimensional todos los datos de la consulta

    while($row = mysqli_fetch_array($resultado)){
        
        array_push($respuesta,$row);
    }

}