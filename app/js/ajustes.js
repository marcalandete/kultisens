var url_api = './../api/v1.0/'

var idUsuario = 0
var idParcelas = []
var datos_parcelas
var borrar_parcelas = []
var sondas = []
var poligono_actualizado = []

function enviar(user) {
	getUsuarios(user)
	getParcelas(user)
	getParcelas2(user)
	getSondas(user)

	//Le añadimos un eventListener al input con el numero de vertices que cree el numero de vertices que le inserten

	document.getElementById('vertices').addEventListener('input', function () {

		var contenedor = document.getElementById('contenedorNuevosVertices')
		var nVertices = document.getElementById('vertices').value
		var error = document.getElementById('error-vertices')

		if (nVertices == 1 || nVertices == 2) {

			error.style.display = 'block'
		}

		if (nVertices != 0 & nVertices != 1 & nVertices != 2) {

			error.style.display = 'none'
		}

		if (nVertices < 3) {

			nVertices = 3
		}

		if (nVertices < 0) {

			document.getElementById('vertices').value = 3
		}

		if (nVertices > 10) {

			nVertices = 10
			document.getElementById('vertices').value = 10
		}

		tamanyo = contenedor.children.length

		for (var i = 0; i < tamanyo; i++) {

			contenedor.removeChild(contenedor.children[0])
		}

		for (var i = 0; i < nVertices; i++) {
			n=i+2

			contenedor.innerHTML += '<div class="col-12"><h4 class="fondoVerde">Vértice '+i+'</h4><div class="col-12 col-xl-6 serie"><div class="col-6"><h4 class="fondoVerde2">Latitud:</h4><input class="campo separadosVertices" type="text" placeholder="Latitud" name="latitud' + i + '" required></div><div class="col-6"><h4 class="fondoVerde2">Longitud:</h4><input class="campo separadosVertices" type="text" placeholder="Longitud" name="longitud' + i + '" required></div>'
		}
	})

	//Le añadimos un eventListener a cada uno de los elementos de tipo submit del form.     

	/*var enviar = document.getElementsByClassName('boton-enviar')

	for (var i = 0; i < enviar.length; i++) {

		enviar[i].addEventListener('click', function () {

			confirm("¿Está seguro de que quiere realizar los cambios?")

			return false;
		})
	}*/
}

//Obtenemos las parcelas del usuario

function getParcelas(usuario) {

	idUsuario = usuario

	if (usuario == 0) return;

	var url = url_api + 'parcelas/?usuario=' + usuario

	fetch(url)

		.then(function (respuesta) {

			return respuesta.json()

		})
		.then(function (json) {

			//Separa las parcelas, de forma que hay una lista de objetos. Dentro de cada objeto están la id de la parcela, su color, nombre y cultivo, y una lista con los vértices:{lat, lng}.

			//Estructura: [{id, nombreParcela:, color:, cultivo:, vertices: [{lat:, lng: }]}, ...]

			idParcelas = []

			if (json.datos.length != 0) {

				var parcela = separarParcelas(json.datos)

				//Transforma el texto que debería ser real a real.

				for (var i = 0; i < parcela.length; i++) {

					for (var j = 0; j < parcela[i].vertices.length; j++) {

						parcela[i].id = parseFloat(parcela[i].id)
						parcela[i].vertices[j].lat = parseFloat(parcela[i].vertices[j].lat)
						parcela[i].vertices[j].lng = parseFloat(parcela[i].vertices[j].lng)
					}

					//Guardamos en un array global todas las ids de las parcelas

					idParcelas.push(parcela[i].id)
				}

			} else {

				parcela = json.datos
			}

			console.log(idParcelas)

			crearListaParcelas(parcela)
		})
}

function separarParcelas(json) {

	var idPos = json[0].idPos

	var TodasPosiciones = []

	var vertices = []

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

//Crea la lista de parcelas que puedes editar

function crearListaParcelas(json) {

	var listadoParcelas = document.getElementById("listaParcelas1")
	var selector = document.getElementById("Sondas")
	datos_parcelas = json;
	//Vaciamos la lista
	selector.innerHTML=""

	while (listadoParcelas.children[0]) {

		listadoParcelas.removeChild(listadoParcelas.children[0])
	}

	//Incluye las parcelas a la lista desplegable

	for (var i = 0; i < json.length; i++) {

		// Añadimos cada opcion a la lista

		listadoParcelas.innerHTML +=
			'<a onclick="flechas(' + i + ')" aria-expanded="false" id="desplegarParcelas' + i + '" class="list-group-item list-group-item-action flex-column align-items-start" data-toggle="collapse" data-target="#collapseParcelas' + i + '"> ' +
			'<div class="d-flex w-100 justify-content-between">' +
			' <h5 class="mb-1 text-capitalize"><small class="colores" style="background:' + json[i].color + ';">&nbsp;&nbsp;&nbsp;&nbsp;</small>' + json[i].nombreParcela + '</h5>' +
			'<div class="opciones"><i class="fas fa-trash-alt" onclick="borrarParcela(' + json[i].id + ')"></i></div>' +
			'</div>' +
			'<small class="text-capitalize">Tipo de Cultivo: ' + json[i].cultivo + '</small>' +
			'<img class="mail1 bajar" id="flecha' + i + '" src="media/Images/bajar.png">' +
			'</a>';

		//Búsqueda del color en formato hex

		var color = document.getElementsByClassName("colores")

		var elegido = window.getComputedStyle(color[i]).getPropertyValue("background-color")

		if (elegido.substr(0, 1) !== '#') {

			var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(elegido);

			var red = parseInt(digits[2]);
			var green = parseInt(digits[3]);
			var blue = parseInt(digits[4]);

			var rgb = blue | (green << 8) | (red << 16);
			var colorDefinitivo = digits[1] + '#' + rgb.toString(16).padStart(6, '0')

		} else {

			colorDefinitivo = json[i].color
		}

		// Desplegable

		listadoParcelas.innerHTML +=

			'<div class="collapse" id="collapseParcelas' + i + '">' +
			'<div class="card card-body">' +
			'<form id="formEditarParcela" onsubmit="return editarParcela(this)">' +
			' <div class="container">' +
			' <div class="row">' +
			'	<input type="hidden" name="id" value="' + idUsuario + '">' +
			'	<input type="hidden" name="idP" value="' + json[i].id + '">' +
			'	<div class="col-12 col-md-5 alLado">' +
			'	<p>Nombre: </p>' +
			'	<input type="text" name="nombreParcela" value="' + json[i].nombreParcela + '" placeholder="Nombre Parcela" class="form-control campo">' + ' </div>' +
			'	<div class="col-8 col-md-5 alLado">' +
			'	<p>Cultivo: </p>' +
			'	<input type="text" name="cultivo" value="' + json[i].cultivo + '" placeholder=" Tipo de cultivo" class="form-control campo">' + ' </div>' + '	<div class="col-4 col-md-2 alLado">' +
			'	<p>Color:</p>' +
			'	<input type="color" name="color" class="form-control campo" value="' + colorDefinitivo + '">' + '</div>' +
			'	<div class="col-12">' +
			'  <div class="serie"><p>Vertices</p>' +'<img onclick="flechas3('+i+')" class="mail1 bajar" id="flechaVerticesP' + i + '" src="media/Images/bajar.png"></div>'+
			'    <div class="scrollbar" id="style-1"><div id="contenedor'+i+'" class="container oculto"><div class="row" id= "contenedor-vertice' + i + '"></div>'+' <button type="button" class="btn boton-cancelar" data-toggle="modal" data-target="#mapaParcela" onclick="mostrarParcela(' + i + ')">Editar vértices en mapa</button>' +'</div>' +
			'</div>' +
			'	<div class="botones"><button onclick="recargarParcelas(' + i + ')" class="volver-login" type="button">Cancelar</button><button class="boton-enviar2" type="submit">Guardar</button></div>' +
			'</div>' +
			'</form>' +
			'</div>' +
			'</div>';

		//Inclue los vertices de la parcela al desplegable

		for (var j = 0; j < json[i].vertices.length; j++) {

			document.getElementById("contenedor-vertice" + i).innerHTML += '<div class="col-12"><h4 class="fondoVerde">Vértice '+j+'</h4></div><div class="col-12 col-xl-6 serie"><div class="col-6"><h4 class="fondoVerde2">Latitud:</h4><input class="col-4 campo separadosVertices" type="number" placeholder="Latitud" name="latitud' + j + '" step="any" value="' + json[i].vertices[j].lat + '" required></div><div class="col-6"><h4 class="fondoVerde2">Longitud:</h4><input class="col-4 campo separadosVertices" type="number" placeholder="Longitud" name="longitud' + j + '" step="any"  value="' + json[i].vertices[j].lng + '" required></div></div>'
		}

		//Incluye al selector de la parcela que quieres incluir la sonda las parcelas que posee ese usuario
		
		selector.innerHTML += '<option value="' + json[i].id + '">' + json[i].nombreParcela + '</option>'
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

function flechas3(valor) {
	imagen1 = document.getElementById("flechaVerticesP" + valor)
	vertices=document.getElementById("contenedor"+valor)
	console.log(vertices)
	if (imagen1.className == "mail1 bajar") {
		imagen1.src = "media/Images/subir.png"
		imagen1.className = "mail1 subir"
		vertices.style.display = "block"
	} else {
		imagen1.src = "media/Images/bajar.png"
		imagen1.className = "mail1 bajar"
		vertices.style.display = "none"
	}
}
/*--------------------------------------------------------------*/
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

//onclick="mostrarParcela('+ json[i] +')"
function mostrarParcela(i) {
	limpiarMapa();
	var parcelas = datos_parcelas[i];
	var parcela = {
		datos: parcelas,
		visible: true,
		poligono: dibujarParcelaEnMapa(parcelas, map)
	}
	borrar_parcelas.push(parcela)
	encuadrarMapa(parcela)
}
//Dibuja el poligono.

function dibujarParcelaEnMapa(parcela, mapa) {

	var poligono = new google.maps.Polygon({

		paths: parcela.vertices,
		strokeColor: parcela.color,
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: parcela.color,
		fillOpacity: 0.35,
		map: mapa,
		editable: true
	})

	poligono_actualizado = poligono;
}
//Actualizar vertices
function actualizarVertices() {
	console.log(JSON.stringify(poligono_actualizado.getPath().getArray()));
	var vertice = JSON.stringify(poligono_actualizado.getPath().getArray());
	var url = url_api + 'editarVertices'
	fetch(url, {
		method: 'put',
		body: JSON.stringify({
			vertices: vertice
		})

	}).then(function (r) {
		return r.json();
	});
	return false;

}
//encuadrar Mapa
function encuadrarMapa(listaParcelas) {

	var norte, sur, este, oeste

	for (var i = 0; i < listaParcelas.length; i++) {

		var p = listaParcelas[i].datos.vertices

		for (var j = 0; j < p.length; j++) {

			if (norte == undefined) {

				norte = p[j].lat
			} else if (p[j].lat > norte) {

				norte = p[j].lat
			}

			if (sur == undefined) {

				sur = p[j].lat
			} else if (p[j].lat < sur) {

				sur = p[j].lat
			}

			if (este == undefined) {

				este = p[j].lng
			} else if (p[j].lng > este) {

				este = p[j].lng
			}

			if (oeste == undefined) {

				oeste = p[j].lng
			} else if (p[j].lng < oeste) {

				oeste = p[j].lng
			}
		}
	}

	map.fitBounds({
		east: este,
		north: norte,
		south: sur,
		west: oeste
	})
}

function getParcelas2(usuario) {

	if (usuario == 0) return;

	var url = url_api + 'parcelasAsignables/?usuario=' + usuario

	fetch(url)

		.then(function (respuesta) {

			return respuesta.json()

		})
		.then(function (json) {

			//Separa las parcelas, de forma que hay una lista de objetos. Dentro de cada objeto están la id de laparcela, su color, nombre y cultivo, y una lista con los vértices:{lat, lng}.

			//Estructura: [{id, nombreParcela:, color:, cultivo:, vertices: [{lat:, lng: }]}, ...]
			console.log(json.datos);
			var listadoParcelas = document.getElementById("listaParcelas2")
			if (json.datos.length == 0) {
				listadoParcelas.innerHTML =
					'<a class="list-group-item list-group-item-action flex-column align-items-start"> ' +
					'<div class="d-flex w-100 justify-content-between">' +
					'<p class="text-center"> No hay ninguna parcela creada por asignar</p>' +
					'</div>'

			} else {

				for (var i = 0; i < json.datos.length; i++) {
					if (i == 0) {
						listadoParcelas.innerHTML =
							'<a class="list-group-item list-group-item-action flex-column align-items-start"> ' +
							'<div class="d-flex w-100 justify-content-between">' +
							'<h5 class="mb-1 text-capitalize">' + json.datos[i].nombreParcela + '</h5>' +
							'<form onsubmit="return añadirParcela(this)">' +
							'	<input type="hidden" name="id" value="' + usuario + '">' +
							'	<input type="hidden" name="idP" value="' + json.datos[i].idParcelas + '">'

							+
							'<button type="submit" class="btn-primary">Añadir</button>' +
							'</form>' +
							'</div>'
							/*+ '<p class="mb-1">Aqui iria una breve descripcion almacenada en la BBDD</p>'*/
							+
							'<small class="text-capitalize">Tipo de Cultivo: ' + json.datos[i].cultivo + '</small>' +
							'</a>';
					} else {
						// Añadimos cada opcion a la lista
						listadoParcelas.innerHTML +=
							'<a class="list-group-item list-group-item-action flex-column align-items-start"> ' +
							'<div class="d-flex w-100 justify-content-between">' +
							'<h5 class="mb-1 text-capitalize">' + json.datos[i].nombreParcela + '</h5>' +
							'<form onsubmit="return añadirParcela(this)">' +
							'	<input type="hidden" name="id" value="' + usuario + '">' +
							'	<input type="hidden" name="idP" value="' + json.datos[i].idParcelas + '">'

							+
							'<button type="submit" class="btn-primary">Añadir</button>' +
							'</form>' +
							'</div>'
							/*+ '<p class="mb-1">Aqui iria una breve descripcion almacenada en la BBDD</p>'*/
							+
							'<small class="text-capitalize">Tipo de Cultivo: ' + json.datos[i].cultivo + '</small>' +
							'</a>';
					}

				}
			}

		})
}


function crearListaParcelas2(json, usuario) {

	var listadoParcelas = document.getElementById("listaParcelas2")

	//Vaciamos el listado de parcelas

	while (listadoParcelas.children[0]) {

		listadoParcelas.removeChild(listadoParcelas.children[0])
	}

	//Incluye las parcelas a la lista desplegable

	for (var i = 0; i < json.length; i++) {

		// Añadimos cada opcion a la lista
		listadoParcelas.innerHTML +=
			'<a class="list-group-item list-group-item-action flex-column align-items-start"> ' +
			'<div class="d-flex w-100 justify-content-between">' +
			'<h5 class="mb-1 text-capitalize">' + json[i].nombreParcela + '</h5>' +
			'<form onsubmit="return añadirParcela(this)">' +
			'	<input type="hidden" name="id" value="' + usuario + '">' +
			'	<input type="hidden" name="idP" value="' + json[i].id + '">'

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

//Obtenemos las sondas del usuario

function getSondas(usuario) {

	var url = url_api + 'sondas/?usuario=' + usuario;

	fetch(url).then(function (respuesta) {

		return respuesta.json()

	}).then(function (json) {

		//Separa las sondas, de forma que hay una lista de objetos. Dentro de cada objeto está la parcela a la que pertenece la sonda y dos listas: Una con los nombres y otra con los vértices:{lat, lng}.

		//Estructura: [{parcela, nombres:[], vertices: [{lat:, lng: }]}, ...]

		if (json.datos.length != 0) {

			sonda = separarSondas(json.datos)

			//Transforma el texto que debería ser real a real.

			for (var i = 0; i < sonda.length; i++) {

				sonda[i].parcela = parseFloat(sonda[i].parcela)

				for (var j = 0; j < sonda[i].vertices.length; j++) {

					sonda[i].vertices[j].lat = parseFloat(sonda[i].vertices[j].lat)
					sonda[i].vertices[j].lng = parseFloat(sonda[i].vertices[j].lng)
				}

			}

			for (var i = 0; i < sonda.length; i++) {

				for (var j = 0; j < sonda[i].id.length; j++) {

					sonda[i].id[j] = parseFloat(sonda[i].id[j])
				}
			}

		} else {

			sonda = json.datos
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
			vert = []
			nombres = []
			ids = []
			i = i - 1
		}
	}

	return TodasPosiciones
}

//Estructura: [{datos: [{parcela, nombres:[], vertices: [{lat:, lng: }]}, ...], visible:, marca:}, ...]

function crearListaDeSondas(json) {
	var listadoParcelas = document.getElementById("listaSondas")

	//Vacia la lista de sondas

	while (listadoParcelas.children[0]) {

		listadoParcelas.removeChild(listadoParcelas.children[0])
	}

	console.log(json)

	for (var i = 0; i < json.length; i++) {

		//Incluye las sondas a la lista desplegable

		for (var j = 0; j < json[i].nombreSonda.length; j++) {
			// Añadimos cada opcion a la lista
			listadoParcelas.innerHTML +=
				'<a id="desplegarSondas'+j+'" onclick="flechas2('+i+')" class="list-group-item list-group-item-action flex-column align-items-start" data-toggle="collapse" data-target="#collapseExample' + j + '"> ' +
				'<div class="d-flex w-100 justify-content-between">' +
				' <h5 class="mb-1 text-capitalize">' + json[i].nombreSonda[j] + '</h5>' + '<div class="paralelos">' +
				' <i class="fas fa-trash-alt adicional" onclick="borrarSonda(' + json[i].id[j] + ')"></i>' +
				'<img class="mail1 bajar" id="flechita' + i + '" src="media/Images/bajar.png">' + '</div>' +
				'</div>' +
				'</a>';

			// Desplegable

			listadoParcelas.innerHTML +=
				'<div class="collapse" id="collapseExample' + j + '">' +
				'<div class="card card-body">' +
				'<form id="formEditarSonda" onsubmit="return editarSonda(this)">' +
				'	<input type="hidden" name="id" value="' + idUsuario + '">' +
				'	<input type="hidden" name="idS" value="' + json[i].id[j] + '">' +
				'<div class="contanier">' +
				'<div class="row">' +
				'<div class="col-12 col-md-4 alLado">' +
				'	<p>Nombre: </p>' +
				'	<input type="text" name="nombreSonda" value="' + json[i].nombreSonda[j] + '" placeholder="Nombre de la sonda" class="form-control campo">' +
				'</div>' +
				'<div class="col-6 col-md-4 alLado">' +
				'	<p>Latitud: </p>' +
				'	<input type="text" name="latitud" value="' + json[i].vertices[j].lat + '" placeholder=" Latitud" class="form-control campo">' +
				'</div>' +
				'<div class="col-6 col-md-4 alLado">' +
				'	<p>Longitud:</p>' +
				'	<input type="text" name="longitud" placeholder=" Longitud" class="form-control campo" value="' + json[i].vertices[j].lng + '">' +
				'</div>' +
				'</div>' +
				'</div>' +
				'<div class="botones"><button onclick="recargarSondas(' + j + ')" class="volver-login" type="button">Cancelar</button>	<button class="boton-enviar2" type="submit">Guardar</button></div>' +
				'</form>' +
				'</div>' +
				'</div>';
		}
	}
}

function editarPerfil(form) {
	var verificado = confirm("¿Está seguro de que quiere preservar los cambios realizados en el perfil?");
	if (verificado == true) {
		if (form['contrasenya'].value == form['contrasenyaRepetida'].value) {

			var url = url_api + 'administrador'

			fetch(url, {

				method: 'put',
				body: JSON.stringify({

					id: form['id'].value,
					contrasenya: form['contrasenya'].value,
					localidad: form['localidad'].value,
					nombre: form['nombre'].value,
					apellido1: form['apellido1'].value,
					apellido2: form['apellido2'].value,
					correo: form['correo'].value,
					tipo: form['tipo'].value
				})

			}).then(function (r) {

				return r.json();

			}).then(function (j) {
			});


		} else {

			document.getElementById('alerta').style.display = 'block';
			return false;
		}
	} else {
		return false;
	}
}

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
	elementos[1].value = usuario.nombre 
	elementos[2].value = usuario.apellido1 
	elementos[3].value = usuario.apellido2 
	elementos[4].value = usuario.email 
	elementos[5].value = usuario.contrasenya 
	elementos[6].value = usuario.contrasenya
	elementos[7].value = usuario.localidad 
}

function mostrarClave1() {

	var x = document.getElementById("psw1"); //coges la variable con id="psw" y lo guardas en la variable x
	if (x.type == "password") //si estÃ¡ en tipo contraseÃ±a se la cambias a tipo texto para que la muestre y cambias la imagen a la del ojo abierto
	{
		document.getElementById("eye1").src = "/././media/Images/iconfinder_icon-22-eye_314859.svg";
		x.type = "text";
		document.getElementById("psw1").focus();
	} else //haces lo contrario de lo anterior, lo pones en tipo contraseÃ±a y pones la foto del ojo cerrado
	{
		document.getElementById("eye1").src = "/././media/Images/iconfinder_icon-21-eye-hidden_314858.svg";
		x.type = "password";
		document.getElementById("psw1").focus();
	}
}

function mostrarClave2() {
	var x = document.getElementById("psw2"); //coges la variable con id="psw" y lo guardas en la variable x
	if (x.type == "password") //si estÃ¡ en tipo contraseÃ±a se la cambias a tipo texto para que la muestre y cambias la imagen a la del ojo abierto
	{
		document.getElementById("eye2").src = "/././media/Images/iconfinder_icon-22-eye_314859.svg";
		x.type = "text";
		document.getElementById("psw2").focus();
	} else //haces lo contrario de lo anterior, lo pones en tipo contraseÃ±a y pones la foto del ojo cerrado
	{
		document.getElementById("eye2").src = "/././media/Images/iconfinder_icon-21-eye-hidden_314858.svg";
		x.type = "password";
		document.getElementById("psw2").focus();
	}
}

//Borra la parcela de la bbdd y, por tanto, de la lista de parcelas.

function borrarParcela(parcela) {

	json = JSON.stringify({

		parcela: parcela,
		usuario: idUsuario
	})

	if (confirm('¿Quieres borrar definitivamente la parcela?')) {

		url = url_api + 'parcelas/?json=' + json

		fetch(url, {

			method: 'delete'

		}).then(function (respuesta) {

			return respuesta.json()

		}).then(function (json) {

			getParcelas(idUsuario)
			getParcelas2(idUsuario)
			getSondas(idUsuario)
		})
	}
}

//Modifica la parcela en la bbdd y, por tanto, en la lista de parcelas.

function editarParcela(form) {
	vert = []
	var verificado = confirm("¿Está seguro de que quiere preservar los cambios realizados en la parcela?");
	if(verificado==true){
	for (var i = 0; i <= (form.length - 10) / 2; i++) {

		vert.push(form['latitud'+i].value)
		vert.push(form['longitud'+i].value)
	}
	var url = url_api + 'parcelas'
	fetch(url, {

		method: 'put',
		body: JSON.stringify({

			id: form['id'].value,
			idP: form['idP'].value,
			nombreParcela: form['nombreParcela'].value,
			color: form['color'].value,
			cultivo: form['cultivo'].value,
			vertices: vert
		})

	}).then(function (r) {

		return r.json();

	}).then(function (j) {

	});
	}else{
		return false;
	}
}

//Añade la parcela con sus sondas a ese usuario en la bbdd y, por tanto, a la lista de parcelas.

function añadirParcela(form) {

	fetch('../api/v1.0/parcelas', {

		method: 'post',
		body: new FormData(form)

	}).then(function (r) {

		return r.json();

	}).then(function (s) {

	});
}

//Crea una nueva parcela a ese usuario en la bbdd y, por tanto, en la lista de parcelas.

function crearParcela(form) {

	var url = url_api + 'parcelas'

	fetch(url, {

		method: 'post',
		body: new FormData(form)

	}).then(function (r) {

		return r.json();

	}).then(function (s) {


	});
}

//Borra la sonda de la bbdd y, por tanto, de la lista de sondas.

function borrarSonda(sonda) {

	if (confirm('¿Quieres borrar definitivamente la sonda?')) {

		url = url_api + 'sondas/?sonda=' + sonda

		fetch(url, {

			method: 'delete'

		}).then(function (respuesta) {

			return respuesta.json()

		}).then(function (json) {

			getSondas(idUsuario)
		})
	}
}

//Modifica la sonda en la bbdd y, por tanto, en la lista de sondas.

function editarSonda(form) {
	var verificado = confirm("¿Está seguro de que quiere guardar los cambios realizados en las sondas?");
	if (verificado == true) {
	var url = url_api + 'sondas'

	fetch(url, {

		method: 'put',
		body: JSON.stringify({

			id: form['id'].value,
			idS: form['idS'].value,
			nombreSonda: form['nombreSonda'].value,
			latitud: form['latitud'].value,
			longitud: form['longitud'].value
		})

	}).then(function (r) {

		return r.json();

	}).then(function (j) {

	})
	}else{
		return false;
	}
}

//Crea una nueva sonda a esa parcela en la bbdd y, por tanto, en la lista de sondas.

function crearSonda(form) {

	var url = url_api + 'sondas'

	fetch(url, {

		method: 'post',
		body: new FormData(form)

	}).then(function (r) {

		return r.json();

	}).then(function (s) {


	});
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
//Limpia tanto los poligonos como las marcas del mapa

function limpiarMapa() {
	var parcelas = borrar_parcelas;
	for (var i = 0; i < parcelas.length; i++) {

		parcelas[i].visible = false
		parcelas[i].poligono.setMap(null)
	}

	for (var i = 0; i < sondas.length; i++) {

		sondas[i].marca.setMap(null)
		sondas[i].visible = false
	}
}