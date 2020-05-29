<?php 
session_start();
/* comprobamos que un usuario registrado es el que accede al archivo, 
sino no tendría sentido que pasara por este archivo */
if (!isset($_SESSION['cliente'])) 
{
    header("location:index.php"); 
}
 
/* usamos la función session_unset() para liberar la variable 
de sesión que se encuentra registrada */
session_unset($_SESSION['cliente']);
 
// Destruye la información de la sesión
session_destroy();
 
//volvemos a la página del login
header("location:../index.php"); ?>