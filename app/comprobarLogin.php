<?php
session_start();

require_once "../api/v1.0/includes/conexion.php"; //estableces conexión
$direccionMail=$_POST['direccion']; //recoges la variable que el usuario ha ingresado como dirección
$clave=$_POST['psw']; //recoges la variable que ha puesto como contraseña
$sql="SELECT * FROM `usuarios` WHERE `email`='$direccionMail' COLLATE utf8_bin"; //selecciones la id, el correo, la contraseña y el tipo de la base de datos usuarios mientras que encuente un correo electrónico acorde con el que va antes y COLLATE utf8_bin es para que reconozca mayúsculas de minúsculas
$resultado=mysqli_query($conexion,$sql);

$error=''; //declaras una variable error

if(mysqli_num_rows($resultado)>0) //si encuentra alguna columna (es decir el correo está bien)
{
    $fila=mysqli_fetch_assoc($resultado); //creas como arrays asociativos
    if($fila['contrasenya']==$clave) //miras si la clave es correcta, si lo es:
    {
        if($fila['tipo']==0) //miras si el tipo es 0 es decir es un cliente y le rediriges a la pagina principal personalizada, por eso le pasas la id
        {
            
            $_SESSION['cliente']=$fila['id'];
            $_SESSION['id']=$fila['id'];
            $_SESSION['nombre']=$fila['nombre'];
            $_SESSION['apellido1']=$fila['apellido1'];
            $_SESSION['apellido2']=$fila['apellido2'];
            $_SESSION['email']=$direccionMail;
            $_SESSION['contrasenya']=$fila['contrasenya'];
            $_SESSION['localidad']=$fila['localidad'];
            header('Location:paginaPrincipal.php');
        }
        else //sino significa que es administrador
        {
            session_start();
            $_SESSION['admin']=$fila['id'];
            $_SESSION['id']=$fila['id'];

            header('Location:administrador.php');
        }
    }
    else //si encuentra correo pero la contraseña no cuadra te envia un mensage de error y lo lleva otra vez al login
    {
        $error='claveIncorrecta';
        header('Location:../index.php?error='.$error);
    }
    
}
else //si no cuadra el correo muestra otro mensage de error y le redirige otra vez al login
{
    $error='correoIncorrecto';
    header('Location:../index.php?error='.$error);
}
?> <!--llamo a la base de datos y guardo únicamente el correo y la contraseña-->