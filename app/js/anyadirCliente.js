function crearUsuario(form) {
	var verificado = confirm("¿Está seguro de que quiere crear el siguiente usuario?");
	if (verificado == true) {
	fetch('../api/v1.0/administrador?debug', {
		method: 'post',
		body: new FormData(form)
	}).then(function (r) {
		return r.json();
	}).then(function (s) {
		if (s.datos.id == 0) {
			document.getElementById('alerta').style.display = 'block';
			document.getElementById('exito').style.display = 'none';
		} else {
			document.getElementById('alerta').style.display = 'none';
			document.getElementById('exito').style.display = 'block';
		}
	});
	}else{
		return false;
	}
}
//--------------------------------------------------
function mostrarClave1() {
	var x = document.getElementById("psw1"); //coges la variable con id="psw" y lo guardas en la variable x
	if (x.type == "password") //si está en tipo contraseña se la cambias a tipo texto para que la muestre y cambias la imagen a la del ojo abierto
	{
		document.getElementById("eye1").src = "/././media/Images/iconfinder_icon-22-eye_314859.svg";
		x.type = "text";
		document.getElementById("psw1").focus();
	} else //haces lo contrario de lo anterior, lo pones en tipo contraseña y pones la foto del ojo cerrado
	{
		document.getElementById("eye1").src = "/././media/Images/iconfinder_icon-21-eye-hidden_314858.svg";
		x.type = "password";
		document.getElementById("psw1").focus();
	}
}
//--------------------------------------------------
function mostrarClave2() {
	var x = document.getElementById("psw2"); //coges la variable con id="psw" y lo guardas en la variable x
	if (x.type == "password") //si está en tipo contraseña se la cambias a tipo texto para que la muestre y cambias la imagen a la del ojo abierto
	{
		document.getElementById("eye2").src = "/././media/Images/iconfinder_icon-22-eye_314859.svg";
		x.type = "text";
		document.getElementById("psw2").focus();
	} else //haces lo contrario de lo anterior, lo pones en tipo contraseña y pones la foto del ojo cerrado
	{
		document.getElementById("eye2").src = "/././media/Images/iconfinder_icon-21-eye-hidden_314858.svg";
		x.type = "password";
		document.getElementById("psw2").focus();
	}
}
