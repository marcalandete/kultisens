var url_api = './../api/v1.0/'
idUsuario = 0
/*  -----------------------------
    -                           -
    -   	GET PARCELAS		-
    -                           -
	-----------------------------   */

//Obtiene las parcelas de la consulta a la base de datos y llama a crearListaParcelas.

function getParcelas(usuario) {

	idUsuario = usuario

	if (usuario == 0) return;

	var url = url_api + 'parcelas/?usuario=' + usuario

	fetch(url)

		.then(function (respuesta) {

			return respuesta.json()

		})
		.then(function (json) {

			//Separa las parcelas, de forma que hay una lista de objetos. Dentro de cada objeto están la id de laparcela, su color, nombre y cultivo, y una lista con los vértices:{lat, lng}.

			//Estructura: [{id, nombreParcela:, color:, cultivo:, vertices: [{lat:, lng: }]}, ...]

			var parcela = separarParcelas(json.datos)

			//Transforma el texto que debería ser real a real.

			for (var i = 0; i < parcela.length; i++) {

				for (var j = 0; j < parcela[i].vertices.length; j++) {

					parcela[i].id = parseFloat(parcela[i].id)
					parcela[i].vertices[j].lat = parseFloat(parcela[i].vertices[j].lat)
					parcela[i].vertices[j].lng = parseFloat(parcela[i].vertices[j].lng)
				}
			}

			crearListaParcelas(parcela)
		})
}


function separarParcelas(json) {

	var idPos = json[0].idPos

	var TodasPosiciones = []

	vertices = []

	var parcela = 0

	for (var i = 0; i < json.length; i++) {

		if (json[i].idPos == idPos) {

			datosParcelas = {

				id: json[i].idPos,
				nombreParcela: json[i].nombreParcela,
				color: json[i].color,
				cultivo: json[i].cultivo,
				vertices: vertices
			}

			vertice = {

				lat: json[i].latitud,
				lng: json[i].longitud,

			}

			datosParcelas.vertices.push(vertice)
			TodasPosiciones[parcela] = datosParcelas
		} else {

			idPos = json[i].idPos
			parcela++
			vertices = []
			i = i - 1
		}
	}

	return TodasPosiciones
}

function crearListaParcelas(json) {

	var listadoParcelas = document.getElementById("listaParcelas1")

	//Incluye las parcelas a la lista desplegable

	//console.log(json);

	for (var i = 0; i < json.length; i++) {
		// Añadimos cada opcion a la lista
		listadoParcelas.innerHTML +=
			'<a aria-expanded="false" id="desplegarParcelas' + i + '" onclick="flechas(' + i + ')" class="list-group-item list-group-item-action flex-column align-items-start" data-toggle="collapse" data-target="#collapseParcelas' + i + '"> ' +
			'<div class="d-flex w-100 justify-content-between">' +
			' <h5 class="mb-1 text-capitalize">' +

			' <small class="colorDesplegable" onclick="cambiarColor()" style="background:' + json[i].color + ';">&nbsp;&nbsp;&nbsp;&nbsp;</small>' + json[i].nombreParcela + '</h5>' +
			'</div>'
			/*+ '<p class="mb-1">Aqui iria una breve descripcion almacenada en la BBDD</p>'*/
			+
			'<small class="text-capitalize">Tipo de Cultivo: ' + json[i].cultivo + '</small>' +
			'<img class="mail1 bajar" id="flecha' + i + '" src="media/Images/bajar.png">' +
			'</a>';

		// Desplegable
		listadoParcelas.innerHTML +=
			'<div class="collapse" id="collapseParcelas' + i + '">' +
			'<div class="card card-body">' +
			'<form id="formEditarParcela" onsubmit="return editarParcela(this)">' +
			' <div class="container">' +
			' <div class="row">' +
			'	<input type="hidden" name="id" value="' + json[i].id + '">' +
			'	<div class="col-12 col-md-5 alLado">' +
			'	<p>Nombre: </p>' +
			'	<input type="text" name="nombreParcela" value="' + json[i].nombreParcela + '" placeholder="Nombre Parcela" class="form-control campo">' +
			' </div>' +
			'	<div class="col-8 col-md-5 alLado">' +
			'	<p>Cultivo: </p>' +
			'	<input type="text" name="cultivo" value="' + json[i].cultivo + '" placeholder=" Tipo de cultivo" class="form-control campo">' +
			' </div>' +
			'	<div class="col-4 col-md-2 alLado">' +
			'	<p>Color: </p>' +
			'	<input type="color" name="color" class="form-control campo" value="' + json[i].color + '">' +
			'</div>' +
			'</div>' +
			'<div >' + ' <div class="container"><div class="row" id= "contenedor-vertice' + i + '"></div></div>' +
			'<div>' +
			'</form>' +
			'	<div class="botones"><button onclick="recargarParcelas(' + i + ')" class="volver-login" type="button">Cancelar</button><button class="boton-enviar" type="submit">Guardar</button>' +
			'</div>';

		//Inclue los vertices de la parcela al desplegable

		for (var j = 0; j < json[i].vertices.length; j++) {

			document.getElementById("contenedor-vertice" + i).innerHTML += '<div class="col-6 col-xl-3"><input class="col-4 campo separadosVertices" type="hidden" placeholder="Latitud" name="latitud' + j + '" step="any" value="' + json[i].vertices[j].lat + '" required><input class="col-4 campo separadosVertices" type="hidden" placeholder="Longitud" name="longitud' + j + '" step="any"  value="' + json[i].vertices[j].lng + '" required></div>'
		}
	}
}

/*lo que hace esta función es mirar cual es el desplegable en el que se ha hecho click, y mira si está plegado o desplegado y cambia la imagen*/
function flechas(valor) {
	imagen = document.getElementById("flecha" + valor)
	if (imagen.className == "mail1 bajar") {
		imagen.src = "media/Images/subir.png"
		imagen.className = "mail1 subir"
	} else {
		imagen.src = "media/Images/bajar.png"
		imagen.className = "mail1 bajar"
	}
}

function flechas2(valor) {
	imagen1 = document.getElementById("flechita" + valor)
	if (imagen1.className == "mail1 bajar") {
		imagen1.src = "media/Images/subir.png"
		imagen1.className = "mail1 subir"
	} else {
		imagen1.src = "media/Images/bajar.png"
		imagen1.className = "mail1 bajar"
	}
}
/*--------------------------------------------------------------*/
/*esto es por si el usuario se arreptiene de lo que está escribiendo y quiere cancelar*/
function recargarParcelas(numeroParcela) {
	//vacias la lista de parcelas
	var listadoParcelas = document.getElementById("listaParcelas1")
	listadoParcelas.innerHTML = "";
	//vuelves a llamar a la función para que recarge las lista
	getParcelas(idUsuario)
	//cambias las clases de cada elemento para que aquella que estaba abierta lo siga estando
	setTimeout(function () {
		var desplegable = document.getElementsByClassName("list-group-item list-group-item-action flex-column align-items-start collapsed")
		var desplegar = document.getElementById("collapseParcelas" + numeroParcela)
		var desplegar1 = document.querySelector("#desplegarParcelas" + numeroParcela)
		desplegar1.setAttribute('aria-expanded', 'true')
		desplegar1.className = "list-group-item list-group-item-action flex-column align-items-start"
		desplegar.className = "collapse show"
		flechas(numeroParcela)
	}, 800)
}

function recargarSondas(numeroSonda) {
	//vacias la lista de sondas
	var listadoSondas = document.getElementById("listaSondas")
	listadoSondas.innerHTML = "";
	//vuelves a llamar a la función para que recarge las lista
	getSondas(idUsuario)
	//cambias las clases de cada elemento para que aquella que estaba abierta lo siga estando
	setTimeout(function () {
		var desplegable = document.getElementsByClassName("list-group-item list-group-item-action flex-column align-items-start collapsed")
		var desplegar = document.getElementById("collapseExample" + numeroSonda)
		var desplegar1 = document.querySelector("#desplegarSondas" + numeroSonda)
		desplegar1.setAttribute('aria-expanded', 'true')
		desplegar1.className = "list-group-item list-group-item-action flex-column align-items-start"
		desplegar.className = "collapse show"
		flechas2(numeroSonda)
	}, 800)
}
/*--------------------------------------------------------------*/

function editarParcela(form) {
	var verificado = confirm("¿Está seguro de que quiere preservar los cambios realizados en la parcela?");
	if (verificado == true) {
		vert = []

		//Guardamos en la lista de verices todos los vertices, guardando en los pares la latidtud y en los impares la longitud

		for (var i = 0; i < (form.length - 6) / 2; i++) {

			vert.push(form['latitud' + i].value)
			vert.push(form['longitud' + i].value)
		}
		var url = url_api + 'parcelas'

		fetch(url, {
			method: 'put',
			body: JSON.stringify({

				id: idUsuario,
				idP: form['id'].value,
				nombreParcela: form['nombreParcela'].value,
				color: form['color'].value,
				cultivo: form['cultivo'].value,
				vertices: vert
			})

		}).then(function (r) {
			return r.json();
		}).then(function (j) {});
	} else {
		return false;
	}

}

/*  -----------------------------
    -                           -
    -   	GET SONDAS			-
    -                           -
	-----------------------------   */

function editarSonda(form) {
	var verificado = confirm("¿Está seguro de que quiere preservar los cambios realizados en la sonda?");
	if (verificado == true) {
		var url = url_api + 'sondas'
		fetch(url, {
			method: 'put',
			body: JSON.stringify({

				id: idUsuario,
				idS: form['id'].value,
				nombreSonda: form['nombreSonda'].value,
				latitud: form['latitud'].value,
				longitud: form['longitud'].value
			})

		}).then(function (r) {
			return r.json();
		}).then(function (j) {});
	} else {
		return false;
	}


}

function getSondas(usuario) {

	var url = url_api + 'sondas/?usuario=' + usuario;

	fetch(url).then(function (respuesta) {

		return respuesta.json()

	}).then(function (json) {

		//Separa las sondas, de forma que hay una lista de objetos. Dentro de cada objeto está la parcela a la que pertenece la sonda y dos listas: Una con los nombres y otra con los vértices:{lat, lng}.

		//Estructura: [{parcela, nombres:[], vertices: [{lat:, lng: }]}, ...]


		sonda = separarSondas(json.datos)

		//Transforma el texto que debería ser real a real.

		for (var i = 0; i < sonda.length; i++) {

			sonda[i].parcela = parseFloat(sonda[i].parcela)

			for (var j = 0; j < sonda[i].vertices.length; j++) {

				sonda[i].vertices[j].lat = parseFloat(sonda[i].vertices[j].lat)
				sonda[i].vertices[j].lng = parseFloat(sonda[i].vertices[j].lng)
			}

		}

		crearListaDeSondas(sonda)

	})
}

function separarSondas(json) {

	var idPos = json[0].parcela

	var TodasPosiciones = []

	var nombres = []
	var ids = []
	var vert = []

	parcela = 0

	for (var i = 0; i < json.length; i++) {

		if (json[i].parcela == idPos) {

			datosSondas = {
				id: ids,
				parcela: json[i].parcela,
				nombreSonda: nombres,
				vertices: vert,
			}

			vertice = {

				lat: json[i].latitud,
				lng: json[i].longitud,
			}
			datosSondas.id.push(json[i].id)
			datosSondas.nombreSonda.push(json[i].nombreSonda)
			datosSondas.vertices.push(vertice)
			TodasPosiciones[parcela] = datosSondas

		} else {

			idPos = json[i].parcela
			parcela++
			vertices = []
			nombres = []
			i = i - 1
		}
	}

	return TodasPosiciones
}

//Incluye los datos en el formato buscado en la lista global "sondas". Con ellos también incluye dos métodos uno en el que se pone si la marca es visible y otro que la crea.

//Estructura: [{datos: [{parcela, nombres:[], vertices: [{lat:, lng: }]}, ...], visible:, marca:}, ...]

function crearListaDeSondas(json) {

	var listadoParcelas = document.getElementById("listaSondas")

	//Incluye las parcelas a la lista desplegable

	//console.log(json);

	for (var i = 0; i < json[0].nombreSonda.length; i++) {
		// Añadimos cada opcion a la lista
		listadoParcelas.innerHTML +=
			'<a id="desplegarSondas' + i + '" onclick="flechas2(' + i + ')" class="list-group-item list-group-item-action flex-column align-items-start" data-toggle="collapse" data-target="#collapseExample' + i + '"> ' +
			'<div class="d-flex w-100 justify-content-between">' +
			' <h5 class="mb-1 text-capitalize">' + json[0].nombreSonda[i] + '</h5>' +
			'<img class="mail1 bajar" id="flechita' + i + '" src="media/Images/bajar.png">'
			//+ ' <small onclick="cambiarColor()" style="background:' + json[i].color + ';">&nbsp;&nbsp;&nbsp;&nbsp;</small>'
			+
			'</div>'
			/*+ '<p class="mb-1">Aqui iria una breve descripcion almacenada en la BBDD</p>'*/
			//+ '<small class="text-capitalize">Tipo de Cultivo: ' + json[i].cultivo + '</small>'
			+
			'</a>';

		// Desplegable
		listadoParcelas.innerHTML +=
			'<div class="collapse" id="collapseExample' + i + '">' +
			'<div class="card card-body">' +
			'<form id="formEditarSonda" onsubmit="return editarSonda(this)">' +
			'	<input type="hidden" name="id" value="' + json[0].id[i] + '">' +
			'	<div class="alLado"><p>Nombre:</p>' +
			'	<input type="text" name="nombreSonda" value="' + json[0].nombreSonda[i] + '" id="" placeholder="Nombre Parcela" class="form-control campo"></div>' +
			'	<input type="hidden" name="latitud" value="' + json[0].vertices[i].lat + '" placeholder=" Tipo de cultivo" class="form-control campo">' +
			'	<input type="hidden" name="longitud" class="form-control campo" value="' + json[0].vertices[i].lng + '">' +
			'	<div class="botones"><button onclick="recargarSondas(' + i + ')" class="volver-login" type="button">Cancelar</button><button class="boton-enviar" type="submit">Guardar</button></div>' +
			'</form>' +
			'</div>' +
			'</div>'
	}
}

function initMap() {

	map = new google.maps.Map(document.getElementById('map'), {

		center: {
			lat: -34.397,
			lng: 150.644,
		},

		zoom: 5,
		mapTypeId: google.maps.MapTypeId.HYBRID,
		disableDefaultUI: true
	});
}

function crearListaParcelas2(json, usuario) {

	var listadoParcelas = document.getElementById("listaParcelas2")

	//Incluye las parcelas a la lista desplegable

	//console.log(json);

	for (var i = 0; i < json.length; i++) {
		// Añadimos cada opcion a la lista
		listadoParcelas.innerHTML +=
			'<a class="list-group-item list-group-item-action flex-column align-items-start"> ' +
			'<div class="d-flex w-100 justify-content-between">' +
			'<h5 class="mb-1 text-capitalize">' + json[i].nombreParcela + '</h5>' +
			'<form onsubmit="return añadirParcela(this)">' +
			'	<input type="hidden" name="id" value="' + json[i].id + '">' +
			'	<input type="hidden" name="idUsuario" value="' + usuario + '">'

			+
			'<button type="submit" class="btn-primary">Añadir</button>' +
			'</form>' +
			'</div>'
			/*+ '<p class="mb-1">Aqui iria una breve descripcion almacenada en la BBDD</p>'*/
			+
			'<small class="text-capitalize">Tipo de Cultivo: ' + json[i].cultivo + '</small>' +
			'</a>';
	}
}


var usuario = 0

/*function enviar(user) {

	document.getElementById('enviar').addEventListener('click', function () {

		confirm("¿Está seguro de que quiere realizar los cambios?")

		return false;
	})

	getUsuarios(user)
}*/

function getUsuarios(user) {

	var url = url_api + 'administrador'

	fetch(url).then(function (respuesta) {

		return respuesta.json()

	}).then(function (json) {

		usuarios = json.datos

		for (var i = 0; i < usuarios.length; i++) {

			if (usuarios[i].id == user) {

				usuario = usuarios[i]
			}
		}

		rellenarLista()
	})
}

function rellenarLista() {

	elementos = document.getElementsByTagName("input")

	elementos[0].value = usuario.nombre
	elementos[1].value = usuario.apellido1
	elementos[2].value = usuario.apellido2
	elementos[3].value = usuario.email
	elementos[4].value = usuario.contrasenya
	elementos[5].value = usuario.contrasenya
	elementos[6].value = usuario.localidad
}

function editarPerfil(form) {
	var verificado = confirm("¿Está seguro de que quiere preservar los cambios de su perfil?");
	if (verificado == true) {
		var url = url_api + 'administrador'

		if (form['contrasenya'].value == form['contrasenyaCheck'].value) {
			fetch(url, {

				method: 'put',
				body: JSON.stringify({

					id: usuario.id,
					contrasenya: form['contrasenya'].value,
					localidad: form['localidad'].value,
					nombre: usuario.nombre,
					apellido1: usuario.apellido1,
					apellido2: usuario.apellido2,
					correo: usuario.email,
					tipo: usuario.tipo
				})

			}).then(function (r) {

				return r.json();

			}).then(function (j) {})
		} else {
			document.getElementById('alerta').style.display = "block";
			return false;
		}
	} else {
		return false;
	}
}

function cambiar(valor) {

	campos = document.getElementsByClassName("lapiz" + valor)
	/*esto es para el lapiz, cuando clickas se hace campo editable y si quieres cancelar vuelves ha hacer click y se reestablecen los valores*/
	imagen = document.getElementsByClassName("imagen" + valor)
	elementos = document.getElementsByTagName("input")

	for (var i = 0; i < campos.length; i++) {

		if (campos[i].readOnly == true) {

			campos[i].readOnly = false
			campos[i].style.border = '  solid rgb(44,117,88)'
			campos[i].style.backgroundColor = 'white'

			if (campos.length == 2 && campos[i].type == "password") {

				campos[i].type = "text"
			}
			imagen[i].src = "media/Images/cancel.png"
		} else {

			campos[i].readOnly = true
			campos[i].style.border = 'thin solid rgb(44,117,88)'
			campos[i].style.backgroundColor = 'rgb(220,220,220)'

			if (campos.length == 2 && campos[i].type == "text") {

				campos[i].type = "password"
			}
			imagen[i].src = "media/Images/lapiz.png"
			elementos[4].value = usuario.contrasenya
			elementos[5].value = usuario.contrasenya
			elementos[6].value = usuario.localidad
		}
	}
}
