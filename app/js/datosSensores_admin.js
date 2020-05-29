var url_api = './../api/v1.0/'

function conexion(usuario, idSonda) {

    getSensores(usuario);
    var chLine = document.getElementById('myChart').getContext('2d');

    var grafica = new Chart(chLine, {
        type: 'line',
        data: {
            datasets: []
        },
        options: {
            title: "",
            responsive: true,
            maintainAspectRatio: false
        }
    });
    setTimeout(function () {

        if (idSonda != undefined) {

            document.getElementById(idSonda).checked = true
            seleccionarParcela()
        }
    }, 200)
    return grafica;
}

// Extraemos el nombre de la parcela, de la sonda y su id

function getSensores(usuario) {

    var url = url_api + 'grafica/?usuario=' + usuario;
    if (usuario == 0) return;

    fetch(url).then(function (r) {

        return r.json();

    }).then(function (json) {

        json = json.datos
        //Obtenemos el numero de sensores
        numeroSensores = json.length

        //Creamos una opcion por cada sensor

        for (let i = 0; i < numeroSensores; i++) {

            var listadoParcelas = document.getElementById("ul-parcelas")


            listadoParcelas.innerHTML += '<li class="list-group-item" data-value1="' + json[i].nombreParcela + '" data-value2= "' + json[i].nombreSonda + '" onclick="seleccionarParcela2(' + json[i].id + ')"><div class="custom-control custom-switch listaInputs"><input type="checkbox" class="custom-control-input listaInputs" id="' + json[i].id + '" onchange="seleccionarParcela()"><label class="custom-control-label">' + json[i].nombreParcela + ' - ' + json[i].nombreSonda + '</label></div></li>';
        }
    })
}

function seleccionarParcela2(idParcela) {

    var selector = document.getElementsByClassName("listaInputs")

    for (var i = 0; i < selector.length; i++) {

        if (selector[i].id == idParcela) {

            var seleccionado = selector[i]
        }
    }
    if (seleccionado.checked == true) {

        seleccionado.checked = false
        seleccionarParcela()

    } else {

        seleccionado.checked = true
        seleccionarParcela()
    }
}

function seleccionarParcela() {

    //Busca del selector las parcelas seleccionadas.

    var selector = document.getElementsByClassName("listaInputs")
    var listaParcelas = []
    var resultado = []
    listaParcelas.length = 0
    resultado.length = 0

    for (var i = 0; i < selector.length; i++) {

        if (selector[i].checked || selector[i].selected == true) {

            console.log(selector[i])

            if (Number.parseInt(selector[i].id)) {

                listaParcelas.push(selector[i].id)

            } else {

                resultado.push(selector[i].id)
            }
        }
    }
    //return listaParcelas

    if (listaParcelas.length != 0) {

        resultado.push(listaParcelas)
        dibujarGrafica(resultado, grafica)
		document.getElementById('alerta').style.display="none";

    } else {
        console.log(grafica);


        grafica.data.datasets = []
        grafica.update();
		document.getElementById('alerta').style.display="block";
    }
}

function dibujarGrafica(resultado) {

    var listaParcelas = resultado[2]
    var periodo = resultado[0]
    var tipoMedicion = resultado[1]

    var json = JSON.stringify({

        id: listaParcelas,
        nombre: periodo,
        tipoMedicion: tipoMedicion
    })

    var url = url_api + 'dibujarGrafica/?json=' + json;

    fetch(url).then(function (r) {

        return r.json();

    }).then(function (j) {
        // Extraemos las mediciones
        var mediciones = j.datos
        //Extraemos el numero de sensores
        var numeroSensores = j.numeroSensores
        // Formateamos y extraemos los datos en el formato correcto
        var datos = extraerDatos(mediciones, numeroSensores)

        pintarGrafica(datos, grafica)

    });
    return false;
}

function seleccionaPeriodo(form) {

}

function seleccionaTipoMedicion(form) {

}

function extraerDatos(mediciones, numeroSensores) {

    var todasMediciones = []
    var datasetProvisional = []
    //console.log(mediciones);
    if (numeroSensores == 1) {
        var medicionSeparada = []
        for (let j = 0; j < mediciones.length; j++) {
            var celdas = []
            var horaSinFecha = mediciones[j].dateTime.split(' ')
            var horaSinSegundos = horaSinFecha[1].split(':')
            var horaDefinitiva = horaSinSegundos[0] + ":" + horaSinSegundos[1]
            celdas.push("Sonda 1")
            var colors = []
            if (mediciones[j].humedad) {
                colors = ['#007bff', '#28a745', '#333333', '#c3e6cb', '#dc3545', '#6c757d'];
                grafica.options.title = {
                    display: true,
                    text: "Humedad (%)"
                }
            } else if (mediciones[j].iluminacion) {
                colors = ['#F4D03F', '#DC7633', '#B03A2E', '#c3e6cb', '#dc3545', '#6c757d'];
                grafica.options.title = {
                    display: true,
                    text: "Iluminacion (%)"
                }

            } else if (mediciones[j].presion) {
                colors = ['#909497', '#28a745', '#333333', '#c3e6cb', '#dc3545', '#6c757d'];
                grafica.options.title = {
                    display: true,
                    text: "Presion (mmPa)"
                }

            } else if (mediciones[j].temperatura) {
                colors = ['#CB4335', '#F4D03F', '#7F8C8D', '#c3e6cb', '#dc3545', '#6c757d'];
                grafica.options.title = {
                    display: true,
                    text: "Temperatura (ºC)"
                }

            } else if (mediciones[j].salinidad) {
                colors = ['#239B56', '#1B4F72', '#333333', '#c3e6cb', '#dc3545', '#6c757d'];
                grafica.options.title = {
                    display: true,
                    text: "Salinidad (%)"
                }

            }

            datos = {
                hora: horaDefinitiva,
                value: mediciones[j][2]
            }
            medicionSeparada.push(datos)
        }
        todasMediciones.push(medicionSeparada)
    } else {

        var celdas = []
        for (let i = 0; i < numeroSensores; i++) {
            var medicionSeparada = []
            celdas.push("Sonda " + i)
            for (let j = 0; j < mediciones.length; j += numeroSensores) {
                var horaSinFecha = mediciones[j].dateTime.split(' ')
                var horaSinSegundos = horaSinFecha[1].split(':')
                var horaDefinitiva = horaSinSegundos[0] + ":" + horaSinSegundos[1]
                var horaSinFecha = mediciones[j].dateTime.split(' ')
                var horaSinSegundos = horaSinFecha[1].split(':')
                var horaDefinitiva = horaSinSegundos[0] + ":" + horaSinSegundos[1]
                var colors = []
                if (mediciones[j].humedad) {
                    colors = ['#007bff', '#28a745', '#333333', '#c3e6cb', '#dc3545', '#6c757d'];
                    grafica.options.title = {
                        display: true,
                        text: "Humedad (%)"
                    }
                } else if (mediciones[j].iluminacion) {
                    colors = ['#F4D03F', '#DC7633', '#B03A2E', '#c3e6cb', '#dc3545', '#6c757d'];
                    grafica.options.title = {
                        display: true,
                        text: "Iluminacion (%)"
                    }

                } else if (mediciones[j].presion) {
                    colors = ['#909497', '#28a745', '#333333', '#c3e6cb', '#dc3545', '#6c757d'];
                    grafica.options.title = {
                        display: true,
                        text: "Presion (mmPa)"
                    }
                    /*grafica.options.scales.yAxes[0].ticks = {
                        max: 
                    }*/
                } else if (mediciones[j].temperatura) {
                    colors = ['#CB4335', '#F4D03F', '#7F8C8D', '#c3e6cb', '#dc3545', '#6c757d'];
                    grafica.options.title = {
                        display: true,
                        text: "Temperatura (ºC)"
                    }

                } else if (mediciones[j].salinidad) {
                    colors = ['#239B56', '#1B4F72', '#333333', '#c3e6cb', '#dc3545', '#6c757d'];
                    grafica.options.title = {
                        display: true,
                        text: "Salinidad (%)"
                    }

                }
                datos = {

                    hora: horaDefinitiva,
                    value: mediciones[i + j][2]
                }
                medicionSeparada.push(datos)
            }
            todasMediciones.push(medicionSeparada)

        }
    }
    for (let i = 0; i < todasMediciones.length; i++) {
        datasetProvisional.push({
            data: [],
            backgroundColor: 'transparent',
            borderColor: colors[i],
            borderWidth: 4,
            pointBackgroundColor: colors[i],
            label: celdas[i]
        })
        var horas = []

        for (let j = 0; j < todasMediciones[i].length; j++) {

            datasetProvisional[i].data.push(todasMediciones[i][j].value)
            horas.push(todasMediciones[i][j].hora)
        }
    }
    var chartData = {
        labels: horas,
        datasets: datasetProvisional
    };
    return chartData
}

function pintarGrafica(datos) {
    //var chLine = document.getElementById('myChart').getContext('2d');

    var chartData = datos

    grafica.data = chartData

    grafica.update()
}

function buscar() {
    
    var valor = document.getElementById("buscar").value
    var selector = document.getElementById("ul-parcelas")
    var elementos = document.getElementsByClassName("list-group-item")

    for (var i = 0; i < selector.children.length; i++) {

        var buscado = 0

        var parcela= elementos[i].getAttribute('data-value1')
        var sonda= elementos[i].getAttribute('data-value2')
        
        for (var j = 0; j < valor.length; j++) {
            
            if (valor[j].toUpperCase() == parcela[j].toUpperCase()) {

                buscado++
            }
            
            if(valor[j].toUpperCase() != parcela[j].toUpperCase() && valor[j].toUpperCase() == sonda[j].toUpperCase()){
                
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

function activar(){
    
    var buscar = document.getElementById("buscar")
    
    buscar.focus()
}