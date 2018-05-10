$(login);

function login() {
    asignarEventos();
    cargarServidores();
    /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
    particlesJS.load('particles-js', 'scripts/particles/particles.json', function () {
        console.log('callback - particles.js config loaded');
    });
}

function asignarEventos() {
    $("#servidores > tr > td > button").click(function () {
        seleccionarServidor(this);
    });
    $("#usuario").change(function () {
        rellenarUsuario(this);
    });
    $("#dominio").change(function () {
        rellenarDominio(this);
    });
}

function rellenarUsuario(input) {
    var span = document.getElementById("leyendaUsuario");
    var usuario = "";
    if (input.value !== "") {
        usuario = procesarUsuario(input.value);
    }
    span.innerHTML = usuario;
}

function procesarUsuario(usuario) {
    var baseOU = "";
    if (usuario !== "") {
        var todasLasOU = usuario.split(".");
        if (todasLasOU.length > 1) {
            baseOU = "cn = " + usuario.substr(0, usuario.indexOf("."));
            for (var i = 1; i < todasLasOU.length; i++) {
                baseOU = baseOU + ", ou = " + todasLasOU[i];
            }
        } else {
            baseOU = "cn = " + usuario;
        }
    }
    return baseOU;
}

function rellenarDominio(input) {
    var span = document.getElementById("leyendaDominio");
    var dominio = "";
    if (input.value !== "") {
        dominio = procesarDominio(input.value);
    }
    span.innerHTML = dominio;
}

function procesarDominio(dominio) {
    var baseDN = "";
    if (dominio !== "") {
        var todosLosDominios = dominio.split(".");
        for (var i = 0; i < todosLosDominios.length; i++) {
            baseDN = baseDN + ", dc = " + todosLosDominios[i];
        }
    }
    return baseDN;
}

function cargarServidores() {
    var tbody = document.getElementById("servidores");
    $.getJSON("./json/servers.json", function (servidores) {
        $.each(servidores, function (indiceServidor, servidor) {
            var fila = document.createElement("tr");
            var contenidoBoton = document.createTextNode("Usar!");
            var boton = document.createElement("button");
            boton.setAttribute("onclick", "seleccionarServidor(this)");
            boton.appendChild(contenidoBoton);
            fila.appendChild(boton);
            $.each(servidor, function (atributo, valor) {
                var celda = document.createElement("td");
                var contenido = document.createTextNode(valor);
                boton.setAttribute(atributo, valor);
                celda.appendChild(contenido);
                fila.appendChild(celda);
            });
            tbody.appendChild(fila);
        });
    });
}

function seleccionarServidor(boton) {
    document.getElementById("servidor").value = boton.getAttribute("servidor");
    document.getElementById("dominio").value = boton.getAttribute("dominio");
    document.getElementById("usuario").value = boton.getAttribute("usuario");
    document.getElementById("clave").value = boton.getAttribute("clave");
}