<?php
$conexion=mysqli_connect("laumega1.upv.edu.es:3306","laume_laura","123456","laumega1_proyecto_grupo03") or die("Error en la conexión"); /*servidor, usuario, contraseña, nombre de la base de datos. Si no se conecta da ese mensge de error*/
mysqli_query($conexion,'SET NAMES utf8');
?>
