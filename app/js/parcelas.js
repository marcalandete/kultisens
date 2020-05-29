var url_api = './../api/v1.0/'

var sondas = []

var nombres = []

var parcelas = []

//Obtiene las sondas de la consulta a la base de datos y llama a crearListaDeSondas.

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
	var vert = []

	parcela = 0

	for (var i = 0; i < json.length; i++) {

		if (json[i].parcela == idPos) {

			datosSondas = {

				parcela: json[i].parcela,
				nombreSonda: nombres,
				vertices: vert,
			}

			vertice = {

				lat: json[i].latitud,
				lng: json[i].longitud,
			}

			datosSondas.nombreSonda.push(json[i].nombreSonda)
			datosSondas.vertices.push(vertice)
			TodasPosiciones[parcela] = datosSondas

		} else {

			idPos = json[i].parcela
			parcela++
			vertices = []
			nombres = []
			i=i-1
		}
	}

	return TodasPosiciones
}

//Incluye los datos en el formato buscado en la lista global "sondas". Con ellos también incluye dos métodos uno en el que se pone si la marca es visible y otro que la crea.

//Estructura: [{datos: [{parcela, nombres:[], vertices: [{lat:, lng: }]}, ...], visible:, marca:}, ...]

function crearListaDeSondas(json) {

	for (var i = 0; i < json.length; i++) {

		for (var j = 0; j < json[i].vertices.length; j++) {

			var sonda = {

				datos: json[i],
				visible: true,
				marca: ponerPuntos([json[i].vertices[j], json[i].nombreSonda[j]]),
			}

			sondas.push(sonda)

			//Como queremos que no aparezca la marca nada más entrar, la establecemos a null.

			//sondas[j].marca.setMap(null) //Si quisiesemos que no se vieran las marcas al comenzar
		}
	}
}

//Crea la marca

function ponerPuntos(sonda) {

	var marca = new google.maps.Marker({

		position: sonda[0],
		map: map,
		icon: 'media/Images/flecha2.png',
	})

	var url = url_api + 'ultimaMedicion/?sonda=' + sonda[1]

	fetch(url).then(function (r) {

		return r.json()

	}).then(function (j) {
		var humedadInfo={
			valor:"",
			clase:""
		};
		var luzInfo={
			valor:"",
			clase:""
		};
		var presionInfo={
			valor:"",
			clase:""
		};
		var temperaturaInfo={
			valor:"",
			clase:""
		};
		var salinidadInfo={
			valor:"",
			clase:""
		};
		/*obtenemos la hora a la que estamos para saber si el valor de la luz es normal o no*/
		var hoy=new Date()
		var hora=hoy.getHours()
		
		/*comprobamos el valor de la humedad*/
		if(j.datos[0].humedad<=35){
			humedadInfo.valor="Bajo"
			humedadInfo.clase="alertaMaxima"
		}else if(j.datos[0].humedad<=75){
			humedadInfo.valor="Medio"
			humedadInfo.clase="ok"
		}else{
			humedadInfo.valor="Alto"
			humedadInfo.clase="alertaMaxima"
		}
		
		/*comprobamos el valor de la temperatura*/
		if(j.datos[0].temperatura<=10){
			temperaturaInfo.valor="Bajo"
			temperaturaInfo.clase="alertaMaxima"
		}else if(j.datos[0].temperatura<=30){
			temperaturaInfo.valor="Medio"
			temperaturaInfo.clase="ok"
		}else{
			temperaturaInfo.valor="Alto"
			temperaturaInfo.clase="alertaMaxima"
		}
		
		
		/*comprobamos el valor de la temperatura*/
		if(j.datos[0].iluminacion<=20){
			if(hora>=22 & hora<=6){
				luzInfo.valor="Bajo"
				luzInfo.clase="ok"
			}else if((hora>=7 & hora<=10) || (hora>=20 & hora<=21)){
				luzInfo.valor="Bajo"
				luzInfo.clase="alertaMedia"
			}else{
				luzInfo.valor="Bajo"
				luzInfo.clase="alertaMaxima"
			}	
		}else if(j.datos[0].iluminacion<=60){
			if(hora>=22 & hora<=6){
				luzInfo.valor="Medio"
				luzInfo.clase="alertaMaxima"
			}else{
				luzInfo.valor="Medio"
				luzInfo.clase="ok"
			}
		}else{
			if(hora>=22 & hora<=6){
				luzInfo.valor="Alto"
				luzInfo.clase="alertaMaxima"
			}else if((hora>=7 & hora<=10) || (hora>=20 & hora<=21)){
				luzInfo.valor="Alto"
				luzInfo.clase="alertaMedia"
			}else{
				luzInfo.valor="Alto"
				luzInfo.clase="ok"
			}
		}
		
		/*comprobamos el valor de la presión*/
		if(j.datos[0].presion<=760){
			presionInfo.valor="Bajo"
			presionInfo.clase="alertaMaxima"
		}else if(j.datos[0].presion<=1013){
			presionInfo.valor="Medio"
			presionInfo.clase="ok"
		}else{
			presionInfo.valor="Alto"
			presionInfo.clase="alertaMaxima"
		}
		
		/*comprobamos el valor de la salinidad, son estos valores porque la conductividad eléctica del agua de riego es de entre el 0.8 y el 2.5 dS/m*/
		if(j.datos[0].salinidad<=32){
			salinidadInfo.valor="Bajo"
			salinidadInfo.clase="alertaMedia"
		}else if(j.datos[0].salinidad<=68){
			salinidadInfo.valor="Medio"
			salinidadInfo.clase="ok"
		}else{
			salinidadInfo.valor="Alto"
			salinidadInfo.clase="alertaMaxima"
		}

		var infowindow = new google.maps.InfoWindow({

			content: '<div id="contenido"><h2 id="titulo">Valores actuales:</h2><div id="resultado"><div><img src=media/Images/agua.png><h3 class="'+humedadInfo.clase+'">' + humedadInfo.valor+ '</h3></div><div><img src=media/Images/creative.png><h3 class="'+luzInfo.clase+'">' + luzInfo.valor + '</h3></div><div><img src=media/Images/pressure.png><h3 class="'+presionInfo.clase+'">' + presionInfo.valor + '</h3></div><div><img src=media/Images/thermometer.png><h3 class="'+temperaturaInfo.clase+'">' + temperaturaInfo.valor + '</h3></div><div><img src=media/Images/icon.png><h3 class="'+salinidadInfo.clase+'">' + salinidadInfo.valor + '</h3></div></div><div class="boton-enviar" style="text-align:center"><a href="datos_de_sensores.php?idSonda=' + j.datos[0].id + '">Mostrar más datos</a></div></div>'
		})

		marca.addListener('click', function () {

			infowindow.open(map, marca);
		});
	})

	return marca
}

//Obtiene las parcelas de la consulta a la base de datos y llama a crearListaParcelas.

function getParcelas(usuario) {

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
			i=i-1
		}
	}

	return TodasPosiciones
}

function crearListaParcelas(json) {

	var listadoParcelas = document.getElementById("selector")

	//Incluye las parcelas a la lista desplegable

	for (var i = 0; i < json.length; i++) {

		listadoParcelas.innerHTML += '<li class="list-group-item" data-value="' + json[i].nombreParcela + '" onclick="seleccionarParcela2(' + json[i].id + ')"><div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="' + json[i].id + '" onchange="seleccionarParcela()" checked><label class="custom-control-label">' + json[i].nombreParcela + '</label>' + '<small class="colorDesplegable" style=" float: right; background:' + json[i].color + ';">&nbsp;&nbsp;&nbsp;&nbsp;</small>' +'</div></li>'
	}

	//Incluye los datos en el formato buscado en la lista global "parcelas". Con ellos también incluye dos métodos uno en el que se pone si el poligono es visible y otro que lo crea.

	//Estructura: [{datos: [{id, nombreParcela:, color:, cultivo:, vertices: [{lat:, lng: }]}, ...], visible:, poligono:}, ...]

	for (var i = 0; i < json.length; i++) {

		var parcela = {

			datos: json[i],
			visible: true,
			poligono: dibujarParcelaEnMapa(json[i], map)
		}

		parcelas.push(parcela)
	}

	encuadrarMapa(parcelas)
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
	})
	escribirTitulo(parcela.vertices, parcela.nombreParcela, parcela.color)

	return poligono
}



//Crear una marca.

function escribirTitulo(parcela, nombreParcela, color) {

	var lat = 0
	var lng = 0
	for (var i = 0; i < parcela.length; i++) {
		lat = parcela[i].lat + lat
		lng = parcela[i].lng + lng
	}
	lat = lat / parcela.length
	lng = lng / parcela.length

	var titulo = new google.maps.Marker({
		position: new google.maps.LatLng(lat, lng),
		map: map,
		label: {
			text: nombreParcela,
			color: "white",
			fontSize: '25px',
			fontWeight: 'bold'
		},
		icon: 'media/Images/flechaT.png',
		zIndex: 100,
		visible: true
	});

	nombres.push(titulo)

}

//Centra el mapa.

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


function seleccionarParcela() {

	//Limpia el mapa.

	limpiarMapa()

	//Busca del selector las parcelas seleccionadas.

	var selector = document.getElementsByTagName("input")
	var listaParcelas = []

	for (var i = 1; i < selector.length; i++) {

		if (selector[i].checked) {

			listaParcelas.push(selector[i])
		}
	}

	parcelasAmandar = []

	//Convierte en visible el/los poligonos seleccionados.

	for (var i = 0; i < listaParcelas.length; i++) {

		for (var j = 0; j < parcelas.length; j++) {

			if (parcelas[j].datos.id == listaParcelas[i].id) {

				parcelas[j].visible = true
				nombres[j].visible = true
				parcelas[j].poligono.setMap(map)
				parcelasAmandar.push(parcelas[j])
			}
		}
	}

	//Convierte en visible la/s marcas de el/los poligonos seleccionados.

	for (var i = 0; i < listaParcelas.length; i++) {

		for (var j = 0; j < sondas.length; j++) {

			if (sondas[j].datos.parcela == listaParcelas[i].id) {

				sondas[j].visible = true
				sondas[j].marca.setMap(map)
			}
		}
	}

	if (parcelasAmandar.length == parcelas.length) {

		document.getElementsByTagName("input")[1].checked = true
	} else {

		document.getElementsByTagName("input")[1].checked = false
	}

	encuadrarMapa(parcelasAmandar)
}

function seleccionarParcela2(id) {

	var selector = document.getElementsByTagName("input")

	for (var i = 1; i < selector.length; i++) {

		if (selector[i].id == id) {

			var seleccionado = selector[i]
		}
	}

	if (seleccionado.checked == true) {

		seleccionado.checked = false
		seleccionarParcela()
	} else {

		selector[0].checked = false
		seleccionado.checked = true
		seleccionarParcela()
	}
}

//Limpia tanto los poligonos como las marcas del mapa

function limpiarMapa() {

	for (var i = 0; i < parcelas.length; i++) {

		parcelas[i].visible = false
		parcelas[i].poligono.setMap(null)
	}

	for (var i = 0; i < sondas.length; i++) {

		sondas[i].marca.setMap(null)
		sondas[i].visible = false
	}

	for (var i = 0; i < nombres.length; i++) {

		nombres[i].visible = false
	}
}

function seleccionar() {

	var selector = document.getElementsByTagName("input")

	for (var i = 0; i < selector.length; i++) {

		selector[i].checked = true
	}

	seleccionarParcela()
}

function seleccionar2() {

	var selector = document.getElementsByTagName("input")
	var seleccionado = selector[0]

	if (seleccionado.checked == true) {

		seleccionado.checked = false

	} else {

		seleccionado.checked = true
		seleccionar()
	}
}

function centrarMapa() {

	var selector = document.getElementsByTagName("input")
	var listaParcelas = []

	for (var i = 0; i < selector.length; i++) {

		if (selector[i].checked) {

			listaParcelas.push(selector[i])
		}
	}

	parcelasAmandar = []

	for (var i = 0; i < listaParcelas.length; i++) {

		for (var j = 0; j < parcelas.length; j++) {

			if (parcelas[j].datos.id == listaParcelas[i].id) {

				parcelasAmandar.push(parcelas[j])
			}
		}
	}

	encuadrarMapa(parcelasAmandar)
}

function buscar() {

	var valor = document.getElementById("buscar").value
	var selector = document.getElementById("selector")
	var elementos = document.getElementsByClassName("list-group-item")

	for (var i = 1; i < selector.children.length; i++) {

		var buscado = 0

		var palabra = elementos[i].getAttribute('data-value')

		for (var j = 0; j < valor.length; j++) {

			if (valor[j].toUpperCase() == palabra[j].toUpperCase()) {

				buscado++
			}
		}

		if (valor.length <= buscado) {

			buscado = valor.length

		} else {

			buscado = 0
		}

		if (buscado == valor.length) {

			selector.children[i].style.display = "block"

		} else {

			selector.children[i].style.display = "none"
		}
	}
}

function activar() {

	var buscar = document.getElementById("buscar")

	buscar.focus()
}
