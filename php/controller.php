<?php

session_start();
include_once './utils.php';
include_once './AJAX_functions.php';

if (isset($_REQUEST["accion"])) {
    $accion = $_REQUEST["accion"];
    $accion = strtolower($accion);
    $accion = str_replace(" ", "", $accion);

    if ($accion == "acceder") {
        escribirLog("Intentando iniciar sesión con las credenciales especificadas", "Debug");
        $_SESSION["servidor"] = $_REQUEST["servidor"];
        $_SESSION["cn"] = extraerCN($_REQUEST["usuario"]);
        $_SESSION["basedn"] = extraerBaseDN($_REQUEST["dominio"]);
        $_SESSION["clave"] = $_REQUEST["clave"];
        if (conectar()) {
            header("Location: ./main.php");
        } else {
            header("Location: ../index.php");
        }
    } elseif ($accion == "ajaxobtenerlistaservidores") {
        AJAX_obtenerListaServidores();
    } else {
        $link_identifier = conectar();
        if ($link_identifier) {
            switch ($accion) {
                // Cases organizational unit
//                case "ajaxformulariounidadorganizativa":
//                    AJAX_formularioUnidadOrganizativa($_REQUEST["ruta"]);
//                    break;
                case "ajaxagregarunidadorganizativa":
                    // add organizational unit
                    AJAX_crearOU($link_identifier, $_REQUEST["ruta"], $_REQUEST["ouUnidadOrganizativa"]);
//                    header("Location: main.php?ruta=" . $rutaPadre);
                    break;
                case "ajaxagregarusuario":
                    // add user
                    AJAX_crearUID($link_identifier, $_REQUEST["ruta"], $_REQUEST["uidUsuario"], $_REQUEST["uidNombreComun"], $_REQUEST["uidCarpeta"], $_REQUEST["uidIDUsuario"], $_REQUEST["uidIDGrupo"], $_REQUEST["uidPassword"]);
//                    header("Location: main.php?ruta=" . $rutaPadre);
                    break;
                case "ajaxinformacionaplicacion":
                    // information of application
                    AJAX_informacionAplicacion();
                    break;
                case "ajaxagregardispositivo":
                    // add device
                    AJAX_crearCN($link_identifier, $_REQUEST["ruta"], $_REQUEST["cnNombre"]);
//                    header("Location: main.php?accion=buscar&ruta=" . $rutaPadre);
                    break;
                case "ajaxformmodificaratributo":
                    // form to modify attribute
                    AJAX_formModificarAtributo($link_identifier, $_REQUEST["ruta"]);
                    break;
                case "ajaxmodificaratributo":
                    // modify attribute
                    AJAX_modificarAtributo($link_identifier, $_REQUEST["ruta"], $_REQUEST["atributo"], $_REQUEST["contenidoAtributo"]);
                    break;
                case "ajaxformagregaratributo":
                    // form to add attribute
                    AJAX_formAgregarAtributo();
                    break;
                case "ajaxagregaratributo":
                    // add attribute
                    AJAX_agregarAtributo($link_identifier, $_REQUEST["ruta"], $_REQUEST["atributo"], $_REQUEST["contenidoAtributo"]);
                    break;
                case "ajaxcontenidoentrada":
                    // tree content
                    AJAX_contenidoArbol($link_identifier);
                    break;
                case "ajaxinformacionentrada":
                    // entry information 
                    AJAX_informacionEntrada($link_identifier, $_REQUEST["dn"]);
                    break;
                case "ajaxeliminarentrada":
                    // delete entry
                    AJAX_eliminarEntrada($link_identifier, $_REQUEST["ruta"]);
                    break;
                case "obtenerlog":
                    // get LOG
                    obtenerLOG();
                    break;
                case "borrarlog":
                    // delete LOG
                    borrarLOG();
                    break;
                case "listar":
                    // list content
                    AJAX_listar($link_identifier, $_REQUEST["ruta"]);
                    break;
                default:
                    escribirLog("El destino no está especificado en el archivo 'controlador.php' y no puede redirigir correctamente", "Error");
            }
        }
        ldap_close($link_identifier);
    }
} else {
    escribirLog("No está especificada la variable superglobal 'accion'", "Error");
    header("Location: ./error.php");
}