var user = 0

var eventos_ = []
var eventosCalendario = [];
var calendar

mostrar = true

var url_api = "./../api/v1.0/"

function obtenerEventos(usuario, id) {

    user = usuario
    document.getElementById("idUsuario").value = user

    var url = url_api + 'eventos/?usuario=' + usuario;

    fetch(url).then(function (respuesta) {

        return respuesta.json()

    }).then(function (json) {

        for (var i = 0; i < json.datos.length; i++) {

            eventosCalendario.push(json.datos[i]);
        }

        crearEventosParseados();

    }).then(function () {

        var calendarEl = document.getElementById('calendar');

        if (calendarEl.hasChildNodes()) {

            calendar.getEventById(id).remove();

        } else {

            calendar = new FullCalendar.Calendar(calendarEl, {

                plugins: ['dayGrid', 'timeGrid', 'list', 'bootstrap', 'interaction', 'esLocale'],
                defaultView: 'dayGridMonth',
                themeSystem: 'bootstrap',
                editable: true,
                selectable: true,
                unselectAuto: true,
                contentHeight: 400,
                locale: 'es',
                eventLimit: true,
                views: {

                    timeGrid: {

                        eventLimit: 6,
                    }
                },

                header: {

                    left: 'title',
                    center: '',
                    right: 'prev today timeGridWeek dayGridMonth listWeek next'
                },

                buttonText: {

                    today: 'hoy',
                    month: 'mes',
                    week: 'semana',
                    day: 'dia',
                    list: 'eventos'
                },

                events: eventos_,

                /*eventResize: function (event, delta, revertFunc) {
                    var id = evento.id;
                    var fi = evento.start.format();
                    var ff = evento.end.format();
                    
                    if (!confirm ( "Esta seguro de cambiar la fecha?")) {
                        revertFunc();
                    }else{
                        
                    }
                    
                },*/

                eventClick: function (event, jsEvent, view) {

                    if (mostrar) {

                        document.getElementById("idEvento").value = event.event.id

                        for (var i = 0; i < eventosCalendario.length; i++) {

                            if (event.event.id == eventosCalendario[i].idEvento) {

                                var inicio= separarFechas(eventosCalendario[i].inicioEvento)
                                var final= separarFechas(eventosCalendario[i].finalEvento)
                                
                                document.getElementById("tituloEvento").value = eventosCalendario[i].tituloEvento
                                document.getElementById("inicioEventoDia").value = inicio.dia
                                document.getElementById("inicioEventoMes").value = inicio.mes
                                document.getElementById("inicioEventoAño").value = inicio.anyo
                                document.getElementById("inicioEventoHora").value = inicio.hora
                                document.getElementById("finalEventoDia").value = final.dia
                                document.getElementById("finalEventoMes").value = final.mes
                                document.getElementById("finalEventoAño").value = final.anyo
                                document.getElementById("finalEventoHora").value = final.hora
                            }
                        }

                        $('#modalEvento').modal()

                    }

                    mostrar = true
                },

                eventRender: function (info) {

                    info.el.innerHTML += '<i class="fas fa-trash-alt" onclick="borrarEvento(' + info.event.id + ');"</i>'
                },

                eventDrop: function (info) {

                    fetch(url_api + "eventos", {

                        method: 'put',
                        body: JSON.stringify({

                            idUsuario: user,
                            inicioEvento: convertirAFecha(info.event.start),
                            finalEvento: convertirAFecha(info.event.end),
                            tituloEvento: info.event.title,
                            id: info.event.id,
                        })

                    }).then(function (r) {

                    }).then(function (s) {

                    });

                    return false
                }
            });

            calendar.render();
        }
    })

    // Intentar que devuelva tipo events
}

function convertirAFecha(fecha) {

    t = new Date(fecha)

    hr = ("0" + t.getHours()).slice(-2);
    min = ("0" + t.getMinutes()).slice(-2);
    sec = ("0" + t.getSeconds()).slice(-2);

    mes = t.getMonth() + 1

    if (mes < 10) {

        mes = "0" + mes
    }

    dia = t.getDate()

    if (dia < 10) {

        dia = "0" + t.getDate()
    }

    return t.getFullYear() + "-" + mes + "-" + dia + " " + hr + ":" + min + ":" + sec
}

function separarFechas(fecha) {

    console.log(fecha)
    t = new Date(fecha)

    m = t.getMonth() + 1

    if (m < 10) {

        m = "0" + m
    }

    d = t.getDate()

    if (d < 10) {

        d = "0" + t.getDate()
    }

    hr = ("0" + t.getHours()).slice(-2);
    min = ("0" + t.getMinutes()).slice(-2);

    var res = {

        dia: String(d),
        mes: String(m),
        anyo: String(t.getFullYear()),
        hora: hr + ":" + min
    }
    return res
}

function crearEventosParseados() {

    eventos_ = []

    for (var i = 0; i < eventosCalendario.length; i++) {

        var evento = new Object();
        evento.title = eventosCalendario[i].tituloEvento;
        evento.start = eventosCalendario[i].inicioEvento;
        evento.end = eventosCalendario[i].finalEvento;
        evento.color = '#2C7558'
        evento.allDay = false;
        evento.id = eventosCalendario[i].idEvento

        eventos_.push(evento);
    }
}

function crearEvento(form) {

    fetch(url_api + "eventos", {

        method: 'post',
        body: new FormData(form)

    }).then(function (r) {


    }).then(function (s) {

    });
}

function editarEvento(form) {
    
    var inicio= form['inicioEventoAño'].value + "-" + form['inicioEventoMes'].value + "-" + form['inicioEventoDia'].value + " " + form['inicioEventoHora'].value +  ":00"
    var final= form['finalEventoAño'].value + "-" + form['finalEventoMes'].value + "-" + form['finalEventoDia'].value + " " + form['finalEventoHora'].value +  ":00"

    fetch(url_api + "eventos", {

        method: 'put',
        body: JSON.stringify({

            idUsuario: user,
            inicioEvento: inicio,
            finalEvento: final,
            tituloEvento: form['tituloEvento'].value,
            id: form['idEvento'].value,
        })

    }).then(function (r) {

    }).then(function (s) {

    });
}

function borrarEvento(evento) {

    mostrar = false

    if (confirm('¿Quieres borrar definitivamente el evento?')) {

        url = url_api + 'eventos/?idEvento=' + evento

        fetch(url, {

            method: 'delete'

        }).then(function (respuesta) {

            return respuesta.json()

        }).then(function (json) {

            obtenerEventos(user, evento)
        })
    }
}
