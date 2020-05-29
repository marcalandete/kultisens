<?php

// Buscamos las parcelas que le pertenecen y las que no le pertenecen

$sql= "SELECT idParcela FROM relaciones WHERE idUsuario= ".$query_params['usuario'];
$excp= "SELECT idParcela FROM relaciones WHERE idUsuario!= ".$query_params['usuario'];

$resultado= mysqli_query($conexion,$sql);
$resultado_t= mysqli_query($conexion,$excp);

$parcela= array();
$todo= array();

while ($fila= mysqli_fetch_assoc($resultado)){

     array_push($parcela, $fila);  
};

while ($fila= mysqli_fetch_assoc($resultado_t)){

    array_push($todo, $fila);   
};

// Buscamos la posicion de las parcelas compartidas

$posicionCompartidas= array();

for($i=0; $i < count($parcela); $i++){
    
    for($j=0; $j < count($todo); $j++){
        
        if($parcela[$i]=== $todo[$j]){
            
            array_push($posicionCompartidas, $i);
        }
    }
}

/*------------------------------------------------------------------------------------------------------------------------------------------*/ 

// Borramos el usuario de la tabla usuarios y relaciones 

$sql1= "DELETE FROM relaciones WHERE idUsuario= ".$query_params['usuario'];
$sql2= "DELETE FROM usuarios WHERE id= ".$query_params['usuario'];

$resultado1 = mysqli_query ($conexion, $sql1);
$resultado2 = mysqli_query ($conexion, $sql2);

$json = array();

$json['exito']= true;

$aux= 0;

$contador_par= 0;

for($i=0; $i < count($parcela); $i++){
    
    // Si no hay posiciones o es la posición de la parcela compartida, y es distinto al tamaño -1 se le suma 1 a aux (Esto se hace para que siga buscando y no sobrepase los datos guardados en el array) 
    
    if(count($posicionCompartidas)!== 0 && $i === $posicionCompartidas[$aux]){
            
        if($aux !== count($posicionCompartidas)-1){
                
            $aux= $aux +1;
        }                        
    }
    
    //Si no es la posición de la parcela compartida se eliminan las sondas, las parcelas y los sensores 
    
    else{
            
        //1º Obtenemos todas las sondas y las posiciones de las parcelas, y las guardamos en dos arrays       
                        
        $sql_= "SELECT id FROM sondas WHERE parcela= ".$parcela[$i]['idParcela'];
        $sql__= "SELECT posiciones FROM parcelas WHERE idParcelas= ".$parcela[$i]['idParcela'];
                            
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
        $contador_pos= 0;

        $sql3= "DELETE FROM sondas WHERE parcela= ".$parcela[$i]['idParcela'];
        $sql4= "DELETE FROM parcelas WHERE idParcelas= ".$parcela[$i]['idParcela'];

        $resultado3 = mysqli_query ($conexion, $sql3);
        $resultado4 = mysqli_query ($conexion, $sql4);
        
        if($resultado4=== true){

            $contador_par= $contador_par + 1;
        };
            
        // 3º Borramos toda la información de los sensores de las sondas de esa parcela
                           
        for($j=0; $j < count($sonda); $j++){
                    
            if($sonda[$j]['id'] !== NULL){
                    
                $sql5= "DELETE FROM sensores WHERE idSonda= ".$sonda[$j]['id'];

                $resultado5 = mysqli_query ($conexion, $sql5);

                if($resultado5=== true){

                    $contador_sns= $contador_sns + 1;
                };
            }                                    
        };
            
        // 4º Borramos todas las posiciones de las parcelas 
            
        $sql6= "DELETE FROM posiciones WHERE idPos= ".$posiciones[0]['posiciones'];
            
        $resultado6 = mysqli_query ($conexion, $sql6);
            
        if($resultado6=== true){

            $contador_pos= $contador_pos + 1;
        };
                
        if($resultado3!== true || $contador_sns!== count($sonda) || $contador_pos!== count($posiciones)){
        
            $json['exito']= false;
        }
    }    
}

$sql7="DELETE FROM eventos WHERE idUsuario=".$query_params['usuario'];
$resultado7=mysqli_query($conexion,$sql7);

if($resultado1!== true || $resultado2!== true || $contador_par!== count($parcela)-count($posicionCompartidas) || $resultado7!==true){
    
    $json['exito']= false;
}