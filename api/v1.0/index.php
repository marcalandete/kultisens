<?php

require_once('includes/conexion.php');

//recuperar el metodo de la peticion
$metodo = strtolower($_SERVER['REQUEST_METHOD']);/*convierte a minusculas*/

//recuperar el recurso solicitado
$uri = explode('v1.0/', parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH))[1]; /* convertimos la url en cadena de texto y separamos sus componentes con una array, y señalamos la casilla del elemento con el que nos queremos quedar*/

$uri_array = explode('/', $uri);
$recurso = array_shift($uri_array);

//recuperar parametros de la query

$query_params= $_GET;

//TODO:recuperar parametros de la URI

$uri_params= array();

for($i=0; $i < count($uri_array); $i++){
    
    if($uri_array[$i] != "")$uri_params[$uri_array[$i]]= $uri_array[++$i];
};

//TODO:recuperar parametros del body

$body_params= (array) json_decode(file_get_contents('php://input'));

//TODO:recuperar parametros del Form Data

$form_params= $_POST;

$output = array();
$output['metodo'] = $metodo;
$output['recurso'] = $recurso;
$output['body_params']= $uri_params;

// realizar la operacion
require('controladores/'.$recurso.'_controlador.php');