<?php
require_once "../api/v1.0/includes/conexion.php"; //estableces conexión
$correoEmpresa='lauramelerogarrigos@gmail.com';
//----------------------------------------------------------------------------------------
$direccionMail=$_POST['direccion']; //recoges la variable que el usuario ha ingresado como dirección
$nombre=$_POST['nombre'];
$telefono=$_POST['telefono'];
$codigoPostal=$_POST['codigo-postal'];
$mensaje=$_POST['mensaje'];

$estado=''; //declaras una variable error

$cabeceras='MIME-Version: 1.0' . "\r\n";
$cabeceras.='Content-type: text/html; charset=utf-8' . "\r\n";
$message= '
<html>
<head>
<style type="text/css" media="all">
</style>
</head>
<body>
<b>Correo electrónico: </b>'.$direccionMail.'
<p>
<b>Nombre: </b>'.$nombre.'
<p>
<b>Teléfono: </b>'.$telefono.'
<p>
<b>Código postal: </b>'.$codigoPostal.'
<p>
<b>Mensaje: </b><dd>'.$mensaje.'</dd>
</body>
</html>
';
//las cabeceras son muy importantes porque sino no cogería el html, lo mostraría como texto puro
mail($correoEmpresa,'Contacto más información',$message,$cabeceras);
$estado="correoEnviado";
header('Location:/./index.php?estado='.$estado.'#section3');