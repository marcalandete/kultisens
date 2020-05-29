<?php

// Buscamos las parcelas que le pertenecen y las que no le pertenecen

$json= json_decode($query_params['json']);

$usuario= $json->usuario;
$parcela= $json->parcela;

$excp= "SELECT idParcela FROM relaciones WHERE idUsuario!= ".$usuario;

$resultado_t= mysqli_query($conexion,$excp);

$todo= array();

while ($fila= mysqli_fetch_assoc($resultado_t)){

    array_push($todo, $fila);   
};

// Buscamos la posicion de las parcelas compartidas

$comparte= false;
    
for($i=0; $i < count($todo); $i++){
  
    if(strval($parcela)=== $todo[$i]['idParcela']){
            
        $comparte= true;
    }
}

/*------------------------------------------------------------------------------------------------------------------------------*/ 

$json = array();

$json['exito']= true;

// Borramos la parcela de la tabla relaciones 

$sql1= 'DELETE FROM relaciones WHERE idUsuario= "'.$usuario.'" AND idParcela= "'.$parcela.'"';

$resultado1= mysqli_query ($conexion, $sql1);

if($resultado1 !== true){
    
    $json['exito']= false;        
}

if ($comparte=== false){
        
    //1º Obtenemos todas las sondas y las posiciones de las parcelas, y las guardamos en dos arrays 
                        
    $sql_= "SELECT id FROM sondas WHERE parcela= ".$parcela;
    $sql__= "SELECT posiciones FROM parcelas WHERE idParcelas= ".$parcela;
    
    $resultado_= mysqli_query($conexion,$sql_);
    $resultado__= mysqli_query($conexion,$sql__);
            
    $sonda= array();
    $posiciones= array();
            
    while ($fila= mysqli_fetch_assoc($resultado_)){
                
        if($fila !== NULL){
                    
            array_push($sonda, $fila);
        }  
    };
                
    array_push($posiciones, mysqli_fetch_assoc($resultado__));
        
    // 2º Borramos las sondas de esa parcela y la parcela 
        
    $contador_sns= 0;

    $sql2= "DELETE FROM sondas WHERE parcela= ".$parcela;
    $sql3= "DELETE FROM parcelas WHERE idParcelas= ".$parcela;

    $resultado2 = mysqli_query ($conexion, $sql2);
    $resultado3 = mysqli_query ($conexion, $sql3);
            
    // 3º Borramos toda la información de los sensores de las sondas de esa parcela
                           
    for($i=0; $i < count($sonda); $i++){
                    
        if($sonda[$i]['id'] !== NULL){
                    
            $sql4= "DELETE FROM sensores WHERE idSonda= ".$sonda[$i]['id'];

            $resultado4 = mysqli_query ($conexion, $sql4);

            if($resultado4=== true){

                $contador_sns= $contador_sns + 1;
            };
        }                                    
    };
    
    // 4º Borramos todas las posiciones de las parcelas 
            
    $sql5= "DELETE FROM posiciones WHERE idPos= ".$posiciones[0]['posiciones'];
            
    $resultado5 = mysqli_query ($conexion, $sql5);
            
    if($resultado2!== true || $resultado3!== true || $resultado5!== true || $contador_sns!== count($sonda)){
        
        $json['exito']= false;
    }    
}