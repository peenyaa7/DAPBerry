function listaServidores() {
    $.confirm({
        title: "",
        content: function () {
            var self = this;
            return $.ajax({
                type: "POST",
                url: "php/controller.php",
                data: {
                    accion: "ajaxobtenerlistaservidores"
                }
            }).done(function (response) {
                self.setContentAppend(response);
            }).fail(function () {
                self.setContentAppend("<p>Algun error con la peticion AJAX</p>");
            });
        },
        columnClass: "xlarge"
    });
}

function usarServidor(button) {
    var servidor = button.getAttribute("servidor");
    var dominio = button.getAttribute("dominio");
    var usuario = button.getAttribute("usuario");
    var clave = button.getAttribute("clave");
    
    document.getElementById("servidor").value = servidor;
    document.getElementById("dominio").value = dominio;
    document.getElementById("usuario").value = usuario;
    document.getElementById("clave").value = clave;
    
}

(function ($) {
    "use strict";


    /*==================================================================
     [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit', function () {
        var check = true;

        for (var i = 0; i < input.length; i++) {
            if (validate(input[i]) == false) {
                showValidate(input[i]);
                check = false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function () {
        $(this).focus(function () {
            hideValidate(this);
        });
    });

    function validate(input) {
        if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        } else {
            if ($(input).val().trim() == '') {
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }



})(jQuery);