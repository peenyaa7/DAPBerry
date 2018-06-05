$(inicializar);

function creaElemento(element) {
    return document.createElement(element);
}

function inicializar() {
    inicializarDialogos();
    peticionAJAXArbol();
    asignarEventos();
//    $("#contenidoBuscar").tabs();
    $(".rejilla").tablesorter();
    inicializarTerminal();
}

function inicializarTerminal() {
    $("#terminal").append("<div id='terminalResizable'><iframe src='https://" + window.location.host + ":3001' id='iframeTerminal'>Cargando terminal...</iframe></div>");
}

//function mostrarTerminal() {
//    var buttonTerminal = $("#switchTerminal").on
//}

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
    $("#switchTerminal").click(function () {
        $("#iframeTerminal").toggle();
        $("#refreshTerminal").toggle();
    });
    $("#refreshTerminal").click(function () {
        document.getElementById("iframeTerminal").src += '';
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
                                url: "../php/controller.php",
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
                text: "Guía de referencia LDAP",
                action: function () {
                    window.open("../php/LDAP_reference.php", "Guía de referencia LDAP", "width=800, height=500");
                }
            },
            manualapp: {
                text: "Manual DAPBerry",
                action: function () {
                    window.open("../trash/documentodeprueba.pdf");
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
                url: "../php/controller.php",
                data: {
                    accion: "obtenerlog"
                }
            }).done(function (response) {
                self.setContentAppend(response);
                $(".rejilla").tablesorter();
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
                        url: "../php/controller.php",
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
    peticionAJAXContenido(id);
}

function peticionAJAXArbol() {
    $("#treeSpinnerLoading").css("display", "block");
    $("#treeLDAPForm").empty();
    $.ajax({
        type: "POST",
        url: "../php/controller.php",
        data: {
            accion: "ajaxcontenidoentrada"
        }
    }).done(function (response) {
        $("#treeSpinnerLoading").css("display", "none");
        $("#treeLDAPForm").html(response);
        inicializarArbol();
    });
}

function peticionAJAXContenido(ruta) {
    $("#contenido").empty();
    $("#contentSpinnerLoading").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../php/controller.php",
        data: {
            ruta: ruta,
            accion: "listar"
        }
    }).done(function (response) {
        $("#contentSpinnerLoading").css("display", "none");
        $("#contenido").html(response);
        $(".rejilla").tablesorter();
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
                    nuevaEntradaDispositivo(rutaPadre);
                }
            },
            cancelar: {
                text: "Cancelar"
            }
        }
    });
}



function nuevaEntradaUnidadOrganizativa(path) {
    $.confirm({
        title: "Crear Unidad Organizativa dentro de <span class='destacarspan'>" + path + "</span>",
        theme: 'supervan',
        columClass: "medium",
        content: "" +
                '<p>Una Unidad Organizativa es un contenedor de objetos que permite organizarlos en subconjuntos,' +
                'dentro del dominio, siguiendo una jerarquía. De este modo, podremos establecer una estructura' +
                'lógica que represente de forma adecuada nuestra organización y simplifique la administración.<p>' +
                '<form action="controller.php" method="POST">' +
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
                        url: "../php/controller.php",
                        data: {
                            accion: "ajaxagregarunidadorganizativa",
                            ouUnidadOrganizativa: ouUnidadOrganizativa,
                            path: path
                        }
                    }).done(function () {
                        peticionAJAXContenido(path);
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


function nuevaEntradaUsuario(path) {
    $.confirm({
        title: "Usuario dentro de <span class='destacarspan'>" + path + "</span>",
        theme: 'supervan',
        columnClass: 'medium',
        content: "" +
                '<p>Un usuario es aquella persona que utiliza un dispositivo o un ordenador y realiza ' +
                'múltiples operaciones con distintos propósitos. A menudo es un usuario aquel que' +
                'adquiere una computadora o dispositivo electrónico y que lo emplea para comunicarse' +
                'con otros usuarios, generar contenido y documentos, utilizar software de diverso' +
                'tipo y muchas otras acciones posibles.<p>' +
                '<form action="controller.php" method="POST">' +
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
                        url: "../php/controller.php",
                        data: {
                            accion: "ajaxagregarusuario",
                            uidUsuario: uidUsuario,
                            uidNombreComun: uidNombreComun,
                            uidCarpeta: uidCarpeta,
                            uidIDUsuario: uidIDUsuario,
                            uidIDGrupo: uidIDGrupo,
                            uidPassword: uidPassword,
                            path: path
                        }
                    }).done(function () {
                        peticionAJAXContenido(path);
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

function nuevaEntradaDispositivo(path) {
    $.confirm({
        title: "Crear dispositivo dentro de <span class='destacarspan'>" + path + "</span>",
        theme: 'supervan',
        columClass: "medium",
        content: "" +
                '<p>Una Unidad Organizativa es un contenedor de objetos que permite organizarlos en subconjuntos,' +
                'dentro del dominio, siguiendo una jerarquía. De este modo, podremos establecer una estructura' +
                'lógica que represente de forma adecuada nuestra organización y simplifique la administración.<p>' +
                '<form action="controller.php" method="POST">' +
                '<table class="formAgregar">' +
                '<tr>' +
                '<td><label class="obligatorio">Nombre:</label></td>' +
                '<td><input type="text" name="cnNombre" id="cnNombre" placeholder="Obligatorio"/></td>' +
                '</tr>' +
                '</table>' +
                '</form> ',
        buttons: {
            formSubmit: {
                text: 'Crear dispositivo!',
                btnClass: 'btn-blue',
                action: function () {
                    var cnNombre = this.$content.find('#cnNombre').val();
                    if (!cnNombre) {
                        $.alert('Establece un nombre');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: "../php/controller.php",
                        data: {
                            accion: "ajaxagregardispositivo",
                            cnNombre: cnNombre,
                            path: path
                        }
                    }).done(function () {
                        peticionAJAXContenido(path);
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

//function nuevaEntradaOtro(rutaPadre) {
//    $.dialog({
//        title: "Dispositivo dentro de <span class='destacarspan'>" + rutaPadre + "</span>",
//        boxWidth: '40%',
//        theme: 'supervan',
//        content: function () {
//            var self = this;
//            return $.ajax({
//                type: "POST",
//                url: "../php/controller.php",
//                data: {
//                    accion: "ajaxagregardispositivo",
//                    ruta: rutaPadre
//                }
//            }).done(function (response) {
//                self.setContentAppend(response);
//            }).fail(function () {
//                self.setContentAppend("<p>Algun error con la peticion AJAX en la funcion nuevaEntrada</p>");
//            });
//        }
//    });
//}

function informacionEntrada(button) {
    var dn = button.getAttribute("dn");
    $.dialog({
        title: 'Información de la entrada',
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "../php/controller.php",
                data: {
                    accion: "ajaxinformacionentrada",
                    dn: dn
                }
            }).done(function (response) {
                self.setContentAppend(response);
                $(".rejilla").tablesorter();
            }).fail(function () {
                self.setContentAppend("<p>Algun error con la peticion AJAX</p>");
            });
        }
    });
}

function modificarEntrada(boton) {
    var dn = boton.getAttribute("dn");
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
                    // nothing
                }
            }
        }
    });
}

function modificarEntradaNuevoAtributo(dn) {
    $.confirm({
        title: "Agregar un atributo en <span class='destacarspan'>" + dn + "</span>",
        theme: 'supervan',
        columnClass: "xlarge",
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "../php/controller.php",
                data: {
                    accion: "ajaxformagregaratributo"
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
                        url: "../php/controller.php",
                        data: {
                            accion: "ajaxagregaratributo",
                            atributo: atributo,
                            contenidoAtributo: contenidoAtributo,
                            dn: dn
                        }
                    }).done(function (response) {
                        peticionAJAXContenido(path(dn));
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
        columnClass: "xlarge",
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "../php/controller.php",
                data: {
                    accion: "ajaxformmodificaratributo",
                    dn: dn
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
                    var attributeContent = this.$content.find('#contenidoAtributo').val();
                    var attribute = this.$content.find("#selector").val();
                    if (!attributeContent) {
                        $.alert('Establece un contenido');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: "../php/controller.php",
                        data: {
                            accion: "ajaxmodificaratributo",
                            attribute: attribute,
                            attributeContent: attributeContent,
                            dn: dn
                        }
                    }).done(function (response) {
                        peticionAJAXContenido(path(dn));
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
    $.confirm({
        title: "Eliminar un atributo de <span class='destacarspan'>" + dn + "</span>",
        theme: 'supervan',
        columnClass: "xlarge",
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "../php/controller.php",
                data: {
                    accion: "ajaxformeliminaratributo",
                    dn: dn
                }
            }).done(function (response) {
                self.setContentAppend(response);
            }).fail(function () {
                self.setContentAppend("<p>Algun error con la peticion AJAX</p>");
            });
        },
        buttons: {
            formSubmit: {
                text: 'Eliminar atributo!',
                btnClass: 'btn-blue',
                action: function () {
                    var attribute = this.$content.find("#selector").val();
                    if (!attribute) {
                        $.alert('Elige un atributo');
                        return false;
                    }
                    $.ajax({
                        type: "POST",
                        url: "../php/controller.php",
                        data: {
                            accion: "ajaxeliminaratributo",
                            attribute: attribute,
                            dn: dn
                        }
                    }).done(function (response) {
                        peticionAJAXContenido(path(dn));
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

function path(dn) {
    return dn.substr(dn.indexOf(",") + 1);
}

function eliminarEntrada(button) {
    var dn = button.getAttribute("dn");
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
                        url: "../php/controller.php",
                        data: {
                            accion: "ajaxeliminarentrada",
                            dn: dn
                        }
                    }).done(function () {
                        peticionAJAXContenido(path(dn));
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
