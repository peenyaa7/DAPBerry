<?php

session_start();
include_once './utilities.php';
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
            header("Location: ./principal.php");
        } else {
            header("Location: ../index.php");
        }
    } elseif ($accion == "ajaxobtenerlistaservidores") {
        AJAX_obtenerListaServidores();
    } else {
        $link_identifier = conectar();
        if ($link_identifier) {
            switch ($accion) {
//            case "irapagina":
//                $_SESSION["nombrepagina"] = $_REQUEST["pagina"];
//                header("Location: principal.php");
//                break;
//            case "acceder":
//                    header("Location: principal.php");
//                break;
                case "ajaxformulariounidadorganizativa":
                    AJAX_formularioUnidadOrganizativa($_REQUEST["ruta"]);
                    break;
                case "ajaxagregarunidadorganizativa":
                    crearOU($link_identifier, $_REQUEST["ruta"], $_REQUEST["ouUnidadOrganizativa"]);
                    header("Location: principal.php?ruta=" . $rutaPadre);
                    break;
                case "ajaxagregarusuario":
                    crearUID($link_identifier, $_REQUEST["ruta"], $_REQUEST["uidUsuario"], $_REQUEST["uidNombreComun"], $_REQUEST["uidCarpeta"], $_REQUEST["uidIDUsuario"], $_REQUEST["uidIDGrupo"], $_REQUEST["uidPassword"]);
                    header("Location: principal.php?ruta=" . $rutaPadre);
                    break;
                case "ajaxinformacionaplicacion":
                    AJAX_informacionAplicacion();
                    break;
//                case "crearusuario":
//                    $path = $_REQUEST["ruta"];
//// Atributos obligatorios
//                    $uidUsuario = $_REQUEST["uidUsuario"];
//                    $uidNombreCompleto = $_REQUEST["uidNombreComun"];
//                    $uidCarpeta = $_REQUEST["uidCarpeta"];
//                    $uidIDUsuario = $_REQUEST["uidIDUsuario"];
//                    $uidIDGrupo = $_REQUEST["uidIDGrupo"];
//                    $uidPassword = $_REQUEST["uidPassword"];
//
//// Atributos opcionales
//                    $uidNombreCompleto = $_REQUEST["uidNombreCompleto"];
//                    $uidCiudad = $_REQUEST["uidCiudad"];
//                    $uidClaveExpiracion = $_REQUEST["uidClaveExpiracion"];
//                    $uidClaveMax = $_REQUEST["uidClaveMax"];
//                    $uidClaveMin = $_REQUEST["uidClaveMin"];
//                    $ouClaveAviso = $_REQUEST["ouClaveAviso"];
//                    $uidDescripcion = $_REQUEST["uidDescripcion"];
//
//// Hay que añadir los opcionales a la funcion
////                ciudad localityname
////                gecos nombre full
//                    crearUID($link_identifier, $path, $uidUsuario, $uidNombreCompleto, $uidCarpeta, $uidIDUsuario, $uidIDGrupo, $uidPassword);
//
//                    header("Location: principal.php?accion=buscar&ruta=" . $rutaPadre);
//                    break;
                case "ajaxagregardispositivo":
                    crearCN($link_identifier, $_REQUEST["ruta"], $_REQUEST["cnNombre"]);
                    header("Location: principal.php?accion=buscar&ruta=" . $rutaPadre);
                case "ajaxformmodificaratributo":
                    AJAX_formModificarAtributo($link_identifier, $_REQUEST["ruta"]);
                    break;
                case "ajaxmodificaratributo":
                    AJAX_modificarAtributo($link_identifier, $_REQUEST["ruta"], $_REQUEST["atributo"], $_REQUEST["contenidoAtributo"]);
                    break;
                case "ajaxformagregaratributo":
                    AJAX_formAgregarAtributo();
                    break;
                case "ajaxagregaratributo":
                    AJAX_agregarAtributo($link_identifier, $_REQUEST["ruta"], $_REQUEST["atributo"], $_REQUEST["contenidoAtributo"]);
                    break;
                case "ajaxcontenidoentrada":
                    AJAX_contenidoArbol($link_identifier);
                    break;
                case "ajaxinformacionentrada":
                    AJAX_informacionEntrada($link_identifier, $_REQUEST["ruta"]);
                    break;
                case "ajaxeliminarentrada":
                    AJAX_eliminarEntrada($link_identifier, $_REQUEST["ruta"]);
//                $rutaPadre = rutaPadre($ruta);
//                header("Location: principal.php?accion=buscar&ruta=" . $rutaPadre);
                    break;
                case "obtenerlog":
                    obtenerLOG();
                    break;
                case "borrarlog":
                    borrarLOG();
                    break;
                case "listar":
                    listar($link_identifier, $_REQUEST["ruta"]);
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