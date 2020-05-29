<?php

session_start(); //iniciamos la sesión.

if(!isset($_SESSION['cliente'])){  //Miramos si existe la variable de la sesión, que variará en función de la ID de cada cliente.

    header("location:login.php");
}

else{};

$correoEmpresa='lauramelerogarrigos@gmail.com';
//----------------------------------------------------------------------------------------
$direccionMail=$_SESSION['email']; //recoges la variable que el usuario ha ingresado como dirección
$adjuntos=$_POST['archivos'];
$mensaje=$_POST['mensaje'];
if($_POST['administrativo'].checked==true){
    $titulo=$_POST['administrativo'];
}
if($_POST['tecnico'].checked==true){
    $titulo=$_POST['tecnico'];
}
if($_POST['informativo'].checked==true){
    $titulo=$_POST['informativo'];
}
if($_POST['reclamaciones'].checked==true){
    $titulo=$_POST['reclamaciones'];
}

//variables para los datos del archivo 
$nombrearchivo = $_FILES['archivo']['name'];
$archivo = $_FILES['archivo']['tmp_name'];
// Leemos el archivo a adjuntar
$archivo = file_get_contents($archivo);
$archivo = chunk_split(base64_encode($archivo));

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
<b>Mensaje: </b><dd>'.$mensaje.'</dd>
<b>Adjuntos: </b>'.$archivo.'
<p>
</body>
</html>
';
//las cabeceras son muy importantes porque sino no cogería el html, lo mostraría como texto puro
mail($correoEmpresa,$titulo,$message,$cabeceras);
$estado="correoEnviado";
header('Location:contacto.php?estado='.$estado);