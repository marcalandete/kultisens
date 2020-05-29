<?php
	    
    $sql= 'INSERT INTO `sondas`(`id`,`parcela`,`nombreSonda`,`latitud`, `longitud`) VALUES (NULL, "'.$form_params['parcela'].'", "'.$form_params['nombreSonda'].'", "'.$form_params['latitud'].'", "'.$form_params['longitud'].'")';

    $resultado= mysqli_query($conexion,$sql);

    $json= array();