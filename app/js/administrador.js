var url_api = './../api/v1.0/'
var expanded = false

function getUsuarios() {

    var url = url_api + 'administrador'

    fetch(url).then(function (respuesta) {

        return respuesta.json()

    }).then(function (json) {

        usuarios = json.datos
        rellenar(crearLista, usuarios)
    })
}

function rellenar(callback, usuarios) {

    var contador = 0

    if (usuarios.length == 0) {

        callback(usuarios)
    }

    for (var i = 0; i < usuarios.length; i++) {

        rellenaUna(usuarios, i, function (usuarios) {

            contador++

            if (contador == usuarios.length) {

                callback(usuarios)
            }
        })
    }
}

function rellenaUna(usuarios, indice, callback) {

    getSondas(usuarios[indice].id, function (sondas) {

        if (usuarios[indice].apellido1 == null) {

            usuarios[indice].apellido1 = ""
        }

        if (usuarios[indice].apellido2 == null) {

            usuarios[indice].apellido2 = ""
        }

        cadaUsuario = {

            id: usuarios[indice].id,
            nombre: usuarios[indice].nombre,
            apellidos: usuarios[indice].apellido1 + " " + usuarios[indice].apellido2,
            email: usuarios[indice].email,
            localidad: usuarios[indice].localidad,
            nSensores: sondas.length,
        }

        usuarios[indice] = cadaUsuario
        callback(usuarios)
    })
}

function getSondas(usuario, callback) {

    var url = url_api + 'sondas/?usuario=' + usuario

    fetch(url).then(function (respuesta) {

        return respuesta.json()

    }).then(function (json) {

        sondas = json.datos
        callback(sondas)
    })
}

function crearLista(usuarios) {

    var listadoClientes = document.getElementById("selector")

    //Limpia la lista

    while (listadoClientes.children[0]) {

        listadoClientes.removeChild(listadoClientes.children[0])
    }

    //Incluye las parcelas a la lista desplegable

    for (var i = 0; i < usuarios.length; i++) {

        listadoClientes.innerHTML += '<li><div class="container"><div class="row"><div class="col-2"><img src="media/Images/user.svg"></div><div class="col-5"><ul><li class="elementos" data-filtro="Nombre" data-value="' + usuarios[i].nombre + '">Nombre: ' + usuarios[i].nombre + '</li><li class="elementos" data-filtro="Apellidos" data-value="' + usuarios[i].apellidos + '">Apellidos: ' + usuarios[i].apellidos + '</li><li class="elementos" data-filtro="Correo" data-value="' + usuarios[i].email + '">Correo: ' + usuarios[i].email + '</li></ul></div><div class="col-3"><ul><li class="elementos" data-filtro="Localidad" data-value="' + usuarios[i].localidad + '">Localidad: ' + usuarios[i].localidad + '</li><li class="elementos" data-filtro="ID Cliente" data-value="' + usuarios[i].id + '">ID Cliente: ' + usuarios[i].id + '</li><li class="elementos" data-filtro="Nº de sondas" data-value="' + usuarios[i].nSensores + '">Nº de sondas: ' + usuarios[i].nSensores + '</li></ul></div><div class="col-2"><a href="mapas_admin.php?idUsuario=' + usuarios[i].id + '"><i class="fas fa-chart-line"></i></a><a href="ajustes.php?id=' + usuarios[i].id + '"><i class="fas fa-user-cog"></i></a><i class="fas fa-trash-alt" onclick="borrarUsuario(' + usuarios[i].id + ')"></i></div></div></div></li>'
    }
}

function borrarUsuario(usuario) {

    if (confirm('¿Quieres borrar definitivamente el usuario?')) {

        url = url_api + 'administrador/?usuario=' + usuario

        fetch(url, {

            method: 'delete'

        }).then(function (respuesta) {

            return respuesta.json()

        }).then(function (json) {

            getUsuarios()
        })
    }
}

function checkear(variable) {

    var valores = document.getElementById(variable)

    if (valores.checked) {

        valores.checked = false
    } else {

        valores.checked = true
    }
}

function showCheckboxes() {

    var checkboxes = document.getElementById("checkboxes")

    if (!expanded) {

        checkboxes.style.display = "block"
        expanded = true

    } else {

        checkboxes.style.display = "none"
        expanded = false
    }
}

function buscar() {

    var valor = document.getElementById("buscar").value
    var selector = document.getElementById("selector")
    var elementos = document.getElementsByClassName("elementos")
    var checklist = document.getElementsByTagName("input")

    var res = []

    for (var i = 0; i < selector.children.length; i++) {

        res.push(false)
    }
    
    for (var i = 1; i < checklist.length; i++) {

        if (checklist[i].checked) {

            for (var j = 0; j < selector.children.length; j++) {

                var buscado = 0

                for (var k = 6 * j; k < 6 + 6 * j; k++) {

                    var filtro = elementos[k].getAttribute('data-filtro')

                    if (filtro == checklist[i].id) {

                        var palabra = elementos[k].getAttribute('data-value')

                        for (var l = 0; l < valor.length; l++) {

                            if (palabra[l] != undefined) {

                                if (valor[l].toUpperCase() == palabra[l].toUpperCase()) {

                                    buscado++
                                }
                            }
                        }

                        if (valor.length <= buscado) {

                            buscado = valor.length

                        } else {

                            buscado = 0
                        }
                    }

                    if (buscado == valor.length) {

                        res[j] = true
                    }
                }
            }
        }
    }

    for (var i = 0; i < selector.children.length; i++) {

        if (res[i]) {

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
