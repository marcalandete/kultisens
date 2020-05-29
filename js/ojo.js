function mostrarLogin()
{
    var x=document.getElementById("psw"); //coges la variable con id="psw" y lo guardas en la variable x
    if (x.type=="password") //si está en tipo contraseña se la cambias a tipo texto para que la muestre y cambias la imagen a la del ojo abierto
    { document.getElementById("eye").src="media/Images/iconfinder_icon-22-eye_314859.svg";
        x.type="text";
    } 
    else //haces lo contrario de lo anterior, lo pones en tipo contraseña y pones la foto del ojo cerrado
    { document.getElementById("eye").src="media/Images/iconfinder_icon-21-eye-hidden_314858.svg";
    x.type="password";
    }
}
//--------------------------------------------------
function mostrarClave1()
{
    var x=document.getElementById("psw1"); //coges la variable con id="psw" y lo guardas en la variable x
    if (x.type=="password") //si está en tipo contraseña se la cambias a tipo texto para que la muestre y cambias la imagen a la del ojo abierto
    { document.getElementById("eye1").src="media/Images/iconfinder_icon-22-eye_314859.svg";
        x.type="text";
    } 
    else //haces lo contrario de lo anterior, lo pones en tipo contraseña y pones la foto del ojo cerrado
    { document.getElementById("eye1").src="media/Images/iconfinder_icon-21-eye-hidden_314858.svg";
    x.type="password";
    }
}
//--------------------------------------------------
function mostrarClave2()
{
    var x=document.getElementById("psw2"); //coges la variable con id="psw" y lo guardas en la variable x
    if (x.type=="password") //si está en tipo contraseña se la cambias a tipo texto para que la muestre y cambias la imagen a la del ojo abierto
    { document.getElementById("eye2").src="media/Images/iconfinder_icon-22-eye_314859.svg";
        x.type="text";
    } 
    else //haces lo contrario de lo anterior, lo pones en tipo contraseña y pones la foto del ojo cerrado
    { document.getElementById("eye2").src="media/Images/iconfinder_icon-21-eye-hidden_314858.svg";
    x.type="password";
    }
}