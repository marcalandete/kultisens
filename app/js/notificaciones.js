
function comprobarRobo(usuario) {
	if (usuario == 0) return;

	var url = url_api + 'sensorMovimiento/?usuario=' + usuario

	fetch(url).then(function (respuesta) {

		return respuesta.json()

	}).then(function (json) {
		console.log(json);

		if (comprobarSensor(json.datos) == true) {
			console.log("Alerta robo");
			notificacionDeRobo(usuario)

		}

	})
}


// Recibe un array de JSON --> {idSonda:"ID:Natural", parcela:"ID:Natural",nombreSonda: "Texto", acelerometro: "Bool"}

function comprobarSensor(json) {
	var comprobacion = false
	for (let i = 0; i < json.length; i++) {
		if (json[i].acelerometro == 1) {
			comprobacion = true
			return comprobacion
		}
	}
	return comprobacion
}


function notificacionDeRobo(usuario) {
	var theTitle = "ALERTA DE ROBO"
	var options = {
		type: "basic",
		icon: "../media/alerta_roja.jpg",
		image: "../media/alerta_roja.jpg",
		contextMessage: "Elimine este aviso en cuanto lo visualice",
	}

	var url = url_api + 'notificaciones'

	var form = new FormData()
	form.append("idUsuario",usuario)
	form.append("titulo","¡Robo!")
	form.append("descripcion","Detectada una alerta desde el sensor de movimiento, elimine esta notificación una vez que contacte con la policia, o compruebe que es una falsa alarma")
	form.append("tipo","alerta_robo")

        fetch(url, {
            method: 'post',
            body: form

        }).then(function (r) {

            return r.json();

        }).then(function (j) {

			var n = new Notification(theTitle, options);
			n.onclick = function(n){
				document.location.href = "/app/notificaciones.php"	
			}
			setTimeout(n.close.bind(n), 25000);
        });
	
}
// Para activar o desactivar las notificaciones

function pedirPermiso() {

	Notification.requestPermission().then(function (result) {
		console.log(result);
	});
}

// Funcion para averiguar el tiempo que ha pasado desde X fecha

// TEST

//var current= new Date(2011, 04, 24, 12, 30, 30, 30);
//alert(timeDifference(current, new Date(2011, 04, 24, 12, 30, 00, 00)));

function diferenciaTiempo(current, previous) {
    
    var msPerMinute = 60 * 1000;
    var msPerHour = msPerMinute * 60;
    var msPerDay = msPerHour * 24;
    var msPerMonth = msPerDay * 30;
    var msPerYear = msPerDay * 365;
    
    var elapsed = current - previous;
    
    if (elapsed < msPerMinute) {
         return Math.round(elapsed/1000) + ' seconds ago';   
    }
    
    else if (elapsed < msPerHour) {
         return Math.round(elapsed/msPerMinute) + ' minutes ago';   
    }
    
    else if (elapsed < msPerDay ) {
         return Math.round(elapsed/msPerHour ) + ' hours ago';   
    }

    else if (elapsed < msPerMonth) {
         return 'approximately ' + Math.round(elapsed/msPerDay) + ' days ago';   
    }
    
    else if (elapsed < msPerYear) {
         return 'approximately ' + Math.round(elapsed/msPerMonth) + ' months ago';   
    }
    
    else {
         return 'approximately ' + Math.round(elapsed/msPerYear ) + ' years ago';   
    }
}

function getNotificaciones(usuario) {
	var url_api = './../api/v1.0/'

	var url = url_api + 'notificaciones/?usuario=' + usuario

    fetch(url)

        .then(function (respuesta) {

            return respuesta.json()

        })
        .then(function (json) {
			console.log(json);
			crearListaNotificaciones(json.datos, "listaNotificaciones",usuario)
		})
}

function crearListaNotificaciones(json, id,usuario){
	var color = "whitesmoke"
	var listaNotificaciones = document.getElementById(id)
	var tipo = 0
	for (let i = 0; i < json.length; i++) {
		if (json[i].tipo == "alerta_robo") {
			color="#dc3545"
			tipo = 1
		} 
		else if(json[i].tipo == "alerta_presion") {
			color = "grey"
		}
		 else if(json[i].tipo == "alerta_temperatura") {
			color = "#FFBD6A"
		}
		 else if(json[i].tipo == "alerta_iluminacion") {
			color = "#FFF7BA"
		}
		 else if(json[i].tipo == "alerta_humedad") {
			color = "#8192FF"
		}
		 else if(json[i].tipo == "alerta_salinidad") {
			color = "whitesmoke"
		}

		
		listaNotificaciones.innerHTML += '<a style="background-color:'+color+';" class="list-group-item list-group-item-action flex-column align-items-start" data-toggle="collapse" data-target="#collapseExample' + i + '">'
		+'<div class="d-flex w-100 justify-content-between">'
		+'<h5 class="mb-1 text-capitalize">' + json[i].Titulo + '</h5>'
		+'<p class="mb-1">'+ json[i].Descripción +'</p>'
		+'<div><i class="fas fa-trash-alt" onclick="borrarNotificacion(' + json[i].idNotificacion + ','+usuario
		+','+ tipo +')"></i></div>' 
		+'</div>'
		+'</a>';
	}
}

function borrarNotificacion(idNotificacion, usuario, tipoAlerta) {
	var url_api = './../api/v1.0/'

    if (confirm('¿Quieres borrar definitivamente la parcela?')) {

        url = url_api + 'notificaciones/?idNotificacion=' + idNotificacion

        fetch(url, {

            method: 'delete'

        }).then(function (respuesta) {

            return respuesta.json()

        }).then(function (json) {
			if (tipoAlerta == 1) {
				
				url = url_api + 'sensorMovimiento/?usuario=' + usuario
				
				fetch(url, {
					
					method: 'delete'
					
				}).then(function (respuesta) {
					
					return respuesta.json()
					
				}).then(function (json) {
					
					
				})
			}
			document.location.href = "http://localhost/app/notificaciones.php"
		})
}
}

function mostrarFormulario(sensor) {
	
	var form=document.getElementById('formularioNotificaciones')

	switch (sensor) {
		case "temperatura":
			console.log(sensor);
			form.innerHTML =  '<form id="formEditarParcela" onsubmit="return editarParcela(this)">' +
            '	<p>Titulo de la notificacion</p>' +
            '	<input type="text" name="nombreParcela" value="" placeholder="Titulo notificación" class="form-control campo">' +
            '	<p>Descripcion</p>' +
            '	<input type="text" name="cultivo" value="" placeholder="Descripcion" class="form-control campo">' +
            '	<p>Cuando sea mayor que</p>' +
            '	<input type="text" name="color" class="form-control campo" value="">' +
            '	<button class="boton-enviar" type="submit">Guardar</button>' +
            '</form>';
			break;
	
		case "iluminacion":
		form.innerHTML =  '<form id="formEditarParcela" onsubmit="return editarParcela(this)">' +
            '	<p>Titulo de la notificacion</p>' +
            '	<input type="text" name="nombreParcela" value="" placeholder="Titulo notificación" class="form-control campo">' +
            '	<p>Descripcion</p>' +
            '	<input type="text" name="cultivo" value="" placeholder="Descripcion" class="form-control campo">' +
            '	<p>Cuando sea mayor que</p>' +
            '	<input type="text" name="color" class="form-control campo" value="">' +
            '	<button class="boton-enviar" type="submit">Guardar</button>' +
            '</form>';	console.log(sensor);

			break;
	
		case "presion":
		console.log(sensor);
		form.innerHTML =  '<form id="formEditarParcela" onsubmit="return editarParcela(this)">' +
            '	<p>Titulo de la notificacion</p>' +
            '	<input type="text" name="nombreParcela" value="" placeholder="Titulo notificación" class="form-control campo">' +
            '	<p>Descripcion</p>' +
            '	<input type="text" name="cultivo" value="" placeholder="Descripcion" class="form-control campo">' +
            '	<p>Cuando sea menor que</p>' +
            '	<input type="text" name="color" class="form-control campo" value="">' +
            '	<button class="boton-enviar" type="submit">Guardar</button>' +
            '</form>';
			break;
	
		case "salinidad":
		console.log(sensor);
		form.innerHTML =  '<form id="formEditarParcela" onsubmit="return editarParcela(this)">' +
            '	<p>Titulo de la notificacion</p>' +
            '	<input type="text" name="nombreParcela" value="" placeholder="Titulo notificación" class="form-control campo">' +
            '	<p>Descripcion</p>' +
            '	<input type="text" name="cultivo" value="" placeholder="Descripcion" class="form-control campo">' +
            '	<p>Cuando sea menor que</p>' +
            '	<input type="text" name="color" class="form-control campo" value="">' +
            '	<button class="boton-enviar" type="submit">Guardar</button>' +
            '</form>';
			break;
	
		case "humedad":
		console.log(sensor);
		form.innerHTML =  '<form id="formEditarParcela" onsubmit="return editarParcela(this)">' +
            '	<p>Titulo de la notificacion</p>' +
            '	<input type="text" name="nombreParcela" value="" placeholder="Titulo notificación" class="form-control campo">' +
            '	<p>Descripcion</p>' +
            '	<input type="text" name="cultivo" value="" placeholder="Descripcion" class="form-control campo">' +
            '	<p>Cuando sea mayor que</p>' +
            '	<input type="text" name="color" class="form-control campo" value="">' +
            '	<button class="boton-enviar" type="submit">Guardar</button>' +
            '</form>';
			break;
	
		default:
			break;
	}
}