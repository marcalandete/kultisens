<?php
	
    //Buscamos la id que se le va a dar a la parcela y a las posiciones

    $sql= 'SELECT idParcelas FROM parcelas';

    $resultado= mysqli_query($conexion,$sql);

    $json= array();

    while ($fila= mysqli_fetch_assoc($resultado)){

        array_push($json, $fila);    
    };

    $mayor= intval($json[0]['idParcelas']);

    for($i=0; $i< count($json); $i++){
        
        if(intval($json[$i]['idParcelas']) > $mayor){
            
            $mayor= intval($json[$i]['idParcelas']);
        }      
    }

    $id= $mayor + 1;

//------------------------------------------------------------------------------------------------------------------------------//

    //Si no está añadiendo una parcela que ya existe, creamos la parcela

    if($form_params['idP'] === NULL){
        
        $tamanyo= count($form_params)-4;
        
        //Recorremos todos los form de los vertices
        
        for($i=0; $i < $tamanyo/2; $i++){

            $latitud= "latitud" . $i;
            $longitud= "longitud" . $i;
            
            //Insertamos la posición del vertice con la misma id que la de la parcela (La que hemos buscado anteriormente)
            
            $sql1= 'INSERT INTO `posiciones`(`idPosicion`,`idPos`,`latitud`,`longitud`) VALUES (NULL, "'.$id.'", "'.$form_params[$latitud].'", "'.$form_params[$longitud].'")';

            $resultado1= mysqli_query($conexion,$sql1);
        }
        
        //Insertamos la parcela con la misa id de posicion que de parcela.

        $sql2= 'INSERT INTO `parcelas`(`idParcelas`,`posiciones`,`nombreParcela`,`color`,`cultivo`) VALUES ("'.$id.'", "'.$id.'", "'.$form_params['nombreParcela'].'", "'.$form_params['color'].'", "'.$form_params['cultivo'].'")';

        $resultado2= mysqli_query($conexion,$sql2);        
    }

    else{
        
        $id= $form_params['idP'];
    }

    //Creamos la relación entre la parcela y el usuario.

    $sql3='INSERT INTO `relaciones`(`idRelacion`,`idUsuario`,`idParcela`) VALUES (NULL,"'.$form_params['id'].'","'.$id.'")';

    $resultado3= mysqli_query($conexion,$sql3);

    $json= array();

    $json['id']= $id;