$(inicializar);

function creaElemento(element) {
    return document.createElement(element);
}

function inicializar() {
    inicializarDialogos();
    peticionAJAXArbol();
    asignarEventos();
    $("#contenidoBuscar").tabs();
    $(".rejilla").tablesorter();
}

function asignarEventos() {
    $("#TUSalir").click(function () {
        cerrarSesion();
    });
    $("#TURefrescar").click(function () {
        peticionAJAXArbol();
    });
    $("#TUAyuda").click(function () {
        dialogoManual();
    });
}

function cerrarSesion() {
    $.confirm({
        title: "Cerrar sesión",
        content: "¿Seguro que quieres cerrar sesión?",
        type: "red",
        autoClose: "no|10000",
        buttons: {
            si: {
                text: "Si",
                action: function () {
                    window.location = "../index.php";
                }
            },
            no: {
                text: "No",
                action: function () {
                    // Nada
                }
            }
        }
    });
}

function dialogoManual() {
    $.confirm({
        title: 'Ayuda',
        theme: 'supervan',
        animationBounce: 2.5,
        content: "Bienvenido al cuadro de ayuda, ¿que deseas saber?",
        buttons: {
            informacion: {
                text: "Información de la aplicación",
                action: function () {
                    $.alert({
                        title: "Información de la aplicación",
                        content: function () {
                            var self = this;
                            return $.ajax({
                                type: "POST",
                                url: "../php/controlador.php",
                                data: {
                                    accion: "ajaxinformacionaplicacion"
                                }
                            }).done(function (response) {
                                self.setContentAppend(response);
                            }).fail(function () {
                                self.setContentAppend("<p>Algun error con la peticion AJAX</p>");
                            });
                        },
                        columnClass: "medium",
                        buttons: {
                            codigoqr: {
                                text: "Código QR",
                                action: function () {
                                    $.alert({
                                        title: "Código QR",
                                        content: "<img src='../images/qrcode.jpg' alt=''/>",
                                        type: "blue"
                                    });
                                }
                            },
                            volver: {
                                text: "Volver",
                                action: function () {
                                    dialogoManual();
                                }
                            },
                            salir: {
                                text: "Salir",
                                action: function () {
                                    // Nada
                                }
                            }
                        }
                    });
                }
            },
            manualldap: {
                text: "Manual LDAP",
                action: function () {
                    window.open("../php/manual.php", "Manual LDAP", "width=800, height=500");
                }
            },
            manualapp: {
                text: "Manual de la aplicación (falta abrir pdf)",
                action: function () {
                    //Abrir PDF
                }
            },
            verlog: {
                text: "Ver LOG",
                action: function () {
                    listarLog();
                }
            },
            salir: {
                text: "Salir",
                action: function () {
                    // Nada
                }
            }
        }
    });
}

function listarLog() {
    $.alert({
        title: "Registro de eventos (log)",
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "../php/controlador.php",
                data: {
                    accion: "obtenerlog"
                }
            }).done(function (response) {
                self.setContentAppend(response);
            }).fail(function () {
                self.setContentAppend("<p>Algun error con la peticion AJAX</p>");
            });
        },
        columnClass: "xlarge",
        buttons: {
            salir: {
                text: "Hecho!",
                action: function () {
                    //Nothing
                }
            },
            borrarlog: {
                text: "Borrar log",
                action: function () {
                    $.ajax({
                        type: "POST",
                        url: "../php/controlador.php",
                        data: {
                            accion: "borrarlog"
                        }
                    });
                    listarLog();
                }
            }
        }
    });
}

function inicializarArbol() {
    // Inicializamos el tree añadiendo plugins
    $("#treeLDAP").jstree({"plugins": ["search", "html_data", "unique"]});

    // Para buscar en una entrada al ser clickeada
    $("#treeLDAP").on("changed.jstree", function (e, data) {
        if (data.selected.length) {
            $(data.selected).each(function (idx) {
                var node = data.instance.get_node(data.selected[idx]);
                seleccionarNodoArbol(node.id);
            });
        }
    });
    var to = false;
    // Para buscar en el arbol
    $('#buscarArbol').keyup(function () {
        if (to) {
            clearTimeout(to);
        }
        to = setTimeout(function () {
            var v = $('#buscarArbol').val();
            $('#treeLDAP').jstree(true).search(v);
        }, 250);
    });
}

function seleccionarNodoArbol(id) {
//    window.location = "./principal.php?accion=buscar&ruta=" + id;
    peticionAJAXContenido(id);
}

function peticionAJAXArbol() {
    $.ajax({
        type: "POST",
        url: "../php/controlador.php",
        data: {
            accion: "ajaxcontenidoentrada"
        }
    }).done(function (response) {
        $("#treeLDAPForm").empty();
        $("#treeLDAPForm").html(response);
        inicializarArbol();
    });
}

function peticionAJAXContenido(ruta) {
    $.ajax({
        type: "POST",
        url: "../php/listar.php",
        data: {
            ruta: ruta
        }
    }).done(function (response) {
        $("#contenido").empty();
        $("#contenido").html(response);
    });
}

function inicializarDialogos() {
    $("#dialogo").dialog({
        title: "Información",
        modal: true,
        autoOpen: false,
        draggable: false,
        resizable: false,
        show: {
            effect: "fade",
            duration: 500
        },
        hide: {
            effect: "fold",
            duration: 500
        },
        open: function (event, ui) {
            $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
        },
        buttons: {
            "Entendido!": function () {
                $(this).dialog("close");
            }
        }
    });
}

function nuevaEntrada(rutaPadre) {
    $.confirm({
        title: "Nueva entrada en <span class='destacarspan'>" + rutaPadre + "</span>",
        content: "Elige el tipo de entrada",
        theme: 'modern',
        buttons: {
            ou: {
                text: "Unidad Organizativa",
                action: function () {
                    nuevaEntradaUnidadOrganizativa(rutaPadre);
                }
            },
            uid: {
                text: "Usuario",
                action: function () {
                    nuevaEntradaUsuario(rutaPadre);
                }
            },
            cn: {
                text: "Otro...",
                action: function () {
                    nuevaEntradaOtro(rutaPadre);
                }
            },
            cancelar: {
                text: "Cancelar"
            }
        }
    });
}



function nuevaEntradaUnidadOrganizativa(rutaPadre) {
    $.confirm({
        title: "Crear Unidad Organizativa dentro de <span class='destacarspan'>" + rutaPadre + "</span>",
        theme: 'supervan',
        columClass: "medium",
        content: "" +
                '<p>Una Unidad Organizativa es un contenedor de objetos que permite organizarlos en subconjuntos,' +
                'dentro del dominio, siguiendo una jerarquía. De este modo, podremos establecer una estructura' +
                'lógica que represente de forma adecuada nuestra organización y simplifique la administración.<p>' +
                '<form action="controlador.php" method="GET">' +
                '<table class="formAgregar">' +
                '<tr>' +
                '<td><label class="obligatorio">Nombre:</label></td>' +
                '<td><input type="text" name="ouUnidadOrganizativa" id="ouUnidadOrganizativa" placeholder="Obligatorio"/></td>' +
                '</tr>' +
                '</table>' +
                '</form> ',
        buttons: {
            formSubmit: {
                text: 'Crear unidad organizativa!',
                btnClass: 'btn-blue',
                action: function () {
                    var ouUnidadOrganizativa = this.$content.find('#ouUnidadOrganizativa').val();
                    if (!ouUnidadOrganizativa) {
                        $.alert('Establece un nombre');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: "../php/controlador.php",
                        data: {
                            accion: "ajaxagregarunidadorganizativa",
                            ouUnidadOrganizativa: ouUnidadOrganizativa,
                            ruta: rutaPadre
                        }
                    }).done(function () {
                        peticionAJAXContenido(rutaPadre);
                        peticionAJAXArbol();
                    }).fail(function () {
                        window.location = "../php/error.php";
                    });


                }
            },
            cancel: function () {
                //close
            }
        },
        onContentReady: function () {
            // bind to events
            var self = this;
            this.$content.find('form').on('submit', function (event) {
                // if the user submits the form by pressing enter in the field.
                event.preventDefault();
                self.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
}


function nuevaEntradaUsuario(rutaPadre) {
    $.dialog({
        title: "Usuario dentro de <span class='destacarspan'>" + rutaPadre + "</span>",
        theme: 'supervan',
        columnClass: 'medium',
        content: "" +
                '<p>Un usuario es aquella persona que utiliza un dispositivo o un ordenador y realiza ' +
                'múltiples operaciones con distintos propósitos. A menudo es un usuario aquel que' +
                'adquiere una computadora o dispositivo electrónico y que lo emplea para comunicarse' +
                'con otros usuarios, generar contenido y documentos, utilizar software de diverso' +
                'tipo y muchas otras acciones posibles.<p>' +
                '<form action="controlador.php" method="GET">' +
                '<table class="formAgregar">' +
                '<tr>' +
                '<td><label class="obligatorio">Nombre de usuario (uid):</label></td>' +
                '<td><input type="text" name="uidUsuario" id="uidUsuario" placeholder="Obligatorio"/></td>' +
                '</tr>' +
                '<tr>' +
                '<td><label class="obligatorio">Nombre comun (cn):</label></td>' +
                '<td><input type="text" name="uidNombreComun" id="uidNombreComun" placeholder="Obligatorio"/></td>' +
                '</tr>' +
                '<tr>' +
                '<td><label class="obligatorio">Nombre de la carpeta personal:</label></td>' +
                '<td><input type="text" name="uidCarpeta" id="uidCarpeta" value="/home/" placeholder="Obligatorio"/></td>' +
                '</tr>' +
                '<tr>' +
                '<td><label class="obligatorio">ID Usuario (1000-65536):</label></td>' +
                '<td><input type="text" name="uidIDUsuario" id="uidIDUsuario" placeholder="Obligatorio"/></td>' +
                '</tr>' +
                '<tr>' +
                '<td><label class="obligatorio">ID grupo (0-32767):</label></td>' +
                '<td><input type="text" name="uidIDGrupo" id="uidIDGrupo" placeholder="Obligatorio"/></td>' +
                '</tr>' +
                '<tr>' +
                '<td><label class="obligatorio">Contraseña:</label></td>' +
                '<td><input type="password" name="uidPassword" id="uidPassword" placeholder="Obligatorio"/></td>' +
                '</tr>' +
//                '<tr>' +
//                '<td><label>Nombre completo:</label></td>' +
//                '<td><input type="text" name="uidNombreCompleto" id="uidNombreCompleto" placeholder="Opcional"/></td>' +
//                '</tr>' +
//                '<tr>' +
//                '<td><label>Nombre ciudad:</label></td>' +
//                '<td><input type="text" name="uidCiudad" id="uidCiudad" placeholder="Opcional"/></td>' +
//                '</tr>' +
//                '<tr>' +
//                '<td><label>Descripcion:</label></td>' +
//                '<td><input type="text" name="uidDescripcion" id="uidDescripcion" placeholder="Opcional"/></td>' +
//                '</tr>' +
                '</table>' +
                '</form> ',
        buttons: {
            formSubmit: {
                text: 'Crear usuario!',
                keys: ["enter", "shift"],
                btnClass: 'btn-blue',
                action: function () {
                    var uidUsuario = this.$content.find('#uidUsuario').val();
                    var uidNombreComun = this.$content.find('#uidNombreComun').val();
                    var uidCarpeta = this.$content.find('#uidCarpeta').val();
                    var uidIDUsuario = this.$content.find('#uidIDUsuario').val();
                    var uidIDGrupo = this.$content.find('#uidIDGrupo').val();
                    var uidPassword = this.$content.find('#uidPassword').val();
                    if (!uidUsuario) {
                        $.alert('Establece un nombre de usuario (uid)');
                        return false;
                    }
                    if (!uidNombreComun) {
                        $.alert('Establece un nombre comun (cn)');
                        return false;
                    }
                    if (!uidCarpeta) {
                        $.alert('Establece un nombre de carpeta');
                        return false;
                    }
                    if (!uidIDUsuario) {
                        $.alert('Establece un ID de usuario');
                        return false;
                    }
                    if (!uidIDGrupo) {
                        $.alert('Establece un ID de grupo');
                        return false;
                    }
                    if (!uidPassword) {
                        $.alert('Establece una contraseña');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: "../php/controlador.php",
                        data: {
                            accion: "ajaxagregarusuario",
                            uidUsuario: uidUsuario,
                            uidNombreComun: uidNombreComun,
                            uidCarpeta: uidCarpeta,
                            uidIDUsuario: uidIDUsuario,
                            uidIDGrupo: uidIDGrupo,
                            uidPassword: uidPassword,
                            ruta: rutaPadre
                        }
                    }).done(function () {
                        peticionAJAXContenido(rutaPadre);
                        peticionAJAXArbol();
                    }).fail(function () {
                        window.location = "../php/error.php";
                    });


                }
            },
            cancel: function () {
                // Nada
            }
        },
        onContentReady: function () {
            // bind to events
            var self = this;
            this.$content.find('form').on('submit', function (event) {
                // if the user submits the form by pressing enter in the field.
                event.preventDefault();
                self.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
}

function nuevaEntradaOtro(rutaPadre) {
    $.dialog({
        title: "Otra cosa dentro de <span class='destacarspan'>" + rutaPadre + "</span>",
        boxWidth: '40%',
        theme: 'supervan',
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "../php/nuevootro.php",
                data: {
                    ruta: rutaPadre
                }
            }).done(function (response) {
                self.setContentAppend(response);
            }).fail(function () {
                self.setContentAppend("<p>Algun error con la peticion AJAX en la funcion nuevaEntrada</p>");
            });
        }
    });
}

function informacionEntrada(button) {
    var dn = button.parentNode.parentNode.getAttribute("dn");
    $.dialog({
        title: 'Información de la entrada',
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "../php/controlador.php",
                data: {
                    accion: "ajaxinformacionentrada",
                    ruta: dn
                }
            }).done(function (response) {
                self.setContentAppend(response);
            }).fail(function () {
                self.setContentAppend("<p>Algun error con la peticion AJAX</p>");
            });
        }
    });
}

function modificarEntrada(boton) {
    var dn = boton.parentNode.parentNode.getAttribute("dn");
    $.confirm({
        title: "Modificar la entrada",
        content: "¿Cómo modificaremos esta entrada?<br><span class='destacarspan'>" + dn + "</span>",
        theme: 'modern',
        buttons: {
            button1: {
                text: "<i class='material-icons'>add_box</i> Añadir un atributo",
                btnClass: "btn-green",
                action: function () {
                    modificarEntradaNuevoAtributo(dn);
                }
            },
            button2: {
                text: "<i class='material-icons'>edit</i> Modificar un atributo",
                btnClass: "btn-orange",
                action: function () {
                    modificarEntradaModificarAtributo(dn);
                }
            },
            button3: {
                text: "<i class='material-icons'>delete</i> Eliminar un atributo",
                btnClass: "btn-red",
                action: function () {
                    modificarEntradaEliminarAtributo(dn);
                }
            },
            cancel: {
                text: "Cancelar",
                action: function () {
                    // Nada
                }
            }
        }
    });
}

function modificarEntradaNuevoAtributo(dn) {
    $.confirm({
        title: "Agregar un atributo en <span class='destacarspan'>" + dn + "</span>",
        theme: 'supervan',
//        columClass: "xlarge",
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "../php/controlador.php",
                data: {
                    accion: "ajaxformagregaratributo",
//                    ruta: dn
                }
            }).done(function (response) {
                self.setContentAppend(response);
            }).fail(function () {
                self.setContentAppend("<p>Algun error con la peticion AJAX</p>");
            });
        },
        buttons: {
            formSubmit: {
                text: 'Agregar atributo!',
                btnClass: 'btn-blue',
                action: function () {
                    var contenidoAtributo = this.$content.find('#contenidoAtributo').val();
                    var atributo = this.$content.find("#atributo").val();
                    if (!contenidoAtributo) {
                        $.alert('Establece un contenido');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: "../php/controlador.php",
                        data: {
                            accion: "ajaxagregaratributo",
                            atributo: atributo,
                            contenidoAtributo: contenidoAtributo,
                            ruta: dn
                        }
                    }).done(function (response) {
                        alert(response);
                        // Habria que poner ruta padre en vez de dn
                        peticionAJAXContenido(dn);
                        peticionAJAXArbol();
                    }).fail(function () {
                        window.location = "../php/error.php";
                    });


                }
            },
            cancel: function () {
                //close
            }
        },
        onContentReady: function () {
            // bind to events
            var self = this;
            this.$content.find('form').on('submit', function (event) {
                // if the user submits the form by pressing enter in the field.
                event.preventDefault();
                self.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
}

function modificarEntradaModificarAtributo(dn) {
    $.confirm({
        title: "Modificar un atributo de <span class='destacarspan'>" + dn + "</span>",
        theme: 'supervan',
//        columClass: "xlarge",
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "../php/controlador.php",
                data: {
                    accion: "ajaxformmodificaratributo",
                    ruta: dn
                }
            }).done(function (response) {
                self.setContentAppend(response);
            }).fail(function () {
                self.setContentAppend("<p>Algun error con la peticion AJAX</p>");
            });
        },
        buttons: {
            formSubmit: {
                text: 'Modificar atributo!',
                btnClass: 'btn-blue',
                action: function () {
                    var contenidoAtributo = this.$content.find('#contenidoAtributo').val();
                    var atributo = this.$content.find("#selector").val();
                    if (!contenidoAtributo) {
                        $.alert('Establece un contenido');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: "../php/controlador.php",
                        data: {
                            accion: "ajaxmodificaratributo",
                            atributo: atributo,
                            contenidoAtributo: contenidoAtributo,
                            ruta: dn
                        }
                    }).done(function (response) {
                        alert(response);
                        // Habria que poner ruta padre en vez de dn
                        peticionAJAXContenido(dn);
                        peticionAJAXArbol();
                    }).fail(function () {
                        window.location = "../php/error.php";
                    });


                }
            },
            cancel: function () {
                //close
            }
        },
        onContentReady: function () {
            // bind to events
            var self = this;
            this.$content.find('form').on('submit', function (event) {
                // if the user submits the form by pressing enter in the field.
                event.preventDefault();
                self.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
}

function modificarEntradaEliminarAtributo(dn) {

}

function eliminarEntrada(button) {
    var dn = button.parentNode.parentNode.getAttribute("dn");
    $.confirm({
        title: dn,
        content: '¿Estás seguro de eliminar la entrada y todo su contenido?',
        boxWidth: '50%',
        useBootstrap: false,
        autoClose: "no|10000",
        closeAnimation: 'RotateYR',
        buttons: {
            si: {
                text: 'Si!',
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function () {
                    $.ajax({
                        type: "POST",
                        url: "../php/controlador.php",
                        data: {
                            accion: "ajaxeliminarentrada",
                            ruta: dn
                        }
                    }).done(function () {
                        var dnPadre = dn.substr(dn.indexOf(",") + 1);
                        peticionAJAXContenido(dnPadre);
                        peticionAJAXArbol();
                    }).fail(function () {
                        alert("no lo he conseguido");
                    });
                }
            },
            no: {
                text: 'No'
            }
        }
    });
}