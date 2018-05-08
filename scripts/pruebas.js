$(pruebas);

function pruebas() {
    otro();
    var fila, celda, contenido;
    var tabla = document.getElementById("tabla");
    $.getJSON("../docs/manual.json", function (datos) {
        $.each(datos, function (indice1, valor1) {
            $.each(valor1, function (indice2, valor2) {
                fila = document.createElement("tr");
                celda = document.createElement("td");
                contenido = document.createTextNode(indice2);
                celda.appendChild(contenido);
                $.each(valor2, function (indice3, valor3) {
                    celda = document.createElement("td");
                    contenido = document.createTextNode(valor3);
                    if (valor3 === "") {
                        celda.style.backgroundColor = "lightblue";
                    }
                    celda.appendChild(contenido);
                    fila.appendChild(celda);
                });
                fila.appendChild(celda);
                tabla.appendChild(fila);
            });
        });
    });
}

function otroX() {
    var div = document.getElementById("otro");
    // Array de 4 elementos
    var array = ["x=nivel0,x=nivel1,x=nivel2,x=nivel3,x=nivel4", "x=nivel0,x=nivel1,x=nivel2", "x=nivel0,x=nivel1,x=nivel2,x=nivel3", "x=nivel0,x=nivel1"];
    for (var i = 0; i < array.length; i++) {
        var arraySeccionado = array[i].split(",");
        var numeroElementosArraySeccionado = arraySeccionado.length;
        for (var j = 0; j < numeroElementosArraySeccionado; j++) {
            if (arraySeccionado[0] != undefined) {
                document.write("<ul><li>" + arraySeccionado[0]);
                arraySeccionado.shift();
            }
        }
        for (var k = 0; k < numeroElementosArraySeccionado; k++) {
            document.write("</li></ul>");
        }
    }
}

function otroY() {
    var array = ["x=nivel0,x=nivel1,x=nivel2,x=nivel3,x=nivel4", "x=nivel0,x=nivel1,x=nivel2", "x=nivel0,x=nivel1,x=nivel2,x=nivel3", "x=nivel0,x=nivel1"];

    for (var i = 0; i < array.length; i++) {
        var arraySeccionado = array[i].split(",");
        arraySeccionado.shift();
        arraySeccionado.shift();
        for (var j = 0; j <= arraySeccionado.length; j++) {
            var olSeleccionado, liNuevo, olAnterior, liNuevo, contenidoNuevo;
            olSeleccionado = document.getElementById("level-tree-" + j);
            if (olSeleccionado) {

                olSeleccionado = document.getElementById("level-tree-" + j);
                liNuevo = document.createElement("li");
                contenidoNuevo = document.createTextNode(arraySeccionado[j]);

                liNuevo.appendChild(contenidoNuevo);
                olSeleccionado.appendChild(liNuevo);

            } else {

                olAnterior = document.getElementById("level-tree-" + eval(j - 1));
                liAnterior = document.createElement("li");
                olNuevo = document.createElement("ul");
                olNuevo.setAttribute("id", "level-tree-" + j);
                liNuevo = document.createElement("li");
                contenidoNuevo = document.createTextNode(arraySeccionado[j]);


                liNuevo.appendChild(contenidoNuevo);
                olNuevo.appendChild(liNuevo);
                liAnterior.appendChild(olNuevo);
                olAnterior.appendChild(liAnterior);

            }
        }
    }
}

function otro() {
//    var div = document.getElementById("otro");
    var array = ["x=nivel0,x=nivel1,x=nivel2,x=nivel3,x=nivel4", "x=nivel0,x=nivel1,x=nivel2", "x=nivel0,x=nivel1,x=nivel2,x=nivel3", "x=nivel0,x=nivel1"];
//    var array = 
    for (var i = 0; i < array.length; i++) {
        var arraySeccionado = array[i].split(",");
        var ulPadre = document.getElementById("listaPadre");
//        arraySeccionado.shift();
//        arraySeccionado.shift();
        crearNivelesRecursiva(ulPadre, arraySeccionado);
    }
    $("#otro").jstree();
}

function crearNivelesRecursiva(ulPadre, array) {
    var ul = document.createElement("ul");
    var li = document.createElement("li");
    var dato = array[0];
    if (typeof dato == "object") {
        
    } else {
        
    }
    
    
    
    
    
    
    
    
    
    
//    
//        var ulHijo = document.createElement("ul");
//        var liHijo = document.createElement("li");
//        var liPadre = ulPadre.firstElementChild;
//        var contenido = document.createTextNode(array[0]);
//        if (array.length > 1) {
//            array.shift();
//            crearNivelesRecursiva(ulHijo, array);
//        }
//        liHijo.appendChild(contenido);
//        ulHijo.appendChild(liHijo);
//        liPadre.appendChild(ulHijo);
//        ulPadre.appendChild(liPadre);
}

