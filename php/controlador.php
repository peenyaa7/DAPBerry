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
    }

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
                $ruta = $_REQUEST["ruta"];
                AJAXFormularioUnidadOrganizativa($ruta);
                break;
            case "ajaxagregarunidadorganizativa":
                $ouUnidadOrganizativa = $_REQUEST["ouUnidadOrganizativa"];
                $rutaPadre = $_REQUEST["ruta"];
                crearOU($link_identifier, $rutaPadre, $ouUnidadOrganizativa);

                header("Location: principal.php?ruta=" . $rutaPadre);
                break;
            case "ajaxagregarusuario":
                $uidUsuario = $_REQUEST["uidUsuario"];
                $uidNombreComun = $_REQUEST["uidNombreComun"];
                $uidCarpeta = $_REQUEST["uidCarpeta"];
                $uidIDUsuario = $_REQUEST["uidIDUsuario"];
                $uidIDGrupo = $_REQUEST["uidIDGrupo"];
                $uidPassword = $_REQUEST["uidPassword"];
                $rutaPadre = $_REQUEST["ruta"];
                crearUID($link_identifier, $rutaPadre, $uidUsuario, $uidNombreComun, $uidCarpeta, $uidIDUsuario, $uidIDGrupo, $uidPassword);
                header("Location: principal.php?ruta=" . $rutaPadre);
                break;
            case "ajaxinformacionaplicacion":
                AJAXInformacionAplicacion();
                break;
            case "crearusuario":
                $rutaPadre = $_REQUEST["ruta"];
// Atributos obligatorios
                $uidUsuario = $_REQUEST["uidUsuario"];
                $uidNombreCompleto = $_REQUEST["uidNombreComun"];
                $uidCarpeta = $_REQUEST["uidCarpeta"];
                $uidIDUsuario = $_REQUEST["uidIDUsuario"];
                $uidIDGrupo = $_REQUEST["uidIDGrupo"];
                $uidPassword = $_REQUEST["uidPassword"];

// Atributos opcionales
                $uidNombreCompleto = $_REQUEST["uidNombreCompleto"];
                $uidCiudad = $_REQUEST["uidCiudad"];
                $uidClaveExpiracion = $_REQUEST["uidClaveExpiracion"];
                $uidClaveMax = $_REQUEST["uidClaveMax"];
                $uidClaveMin = $_REQUEST["uidClaveMin"];
                $ouClaveAviso = $_REQUEST["ouClaveAviso"];
                $uidDescripcion = $_REQUEST["uidDescripcion"];

// Hay que añadir los opcionales a la funcion
//                ciudad localityname
//                gecos nombre full
                crearUID($link_identifier, $rutaPadre, $uidUsuario, $uidNombreCompleto, $uidCarpeta, $uidIDUsuario, $uidIDGrupo, $uidPassword);

                header("Location: principal.php?accion=buscar&ruta=" . $rutaPadre);
                break;
            case "creardispositivo":
//            $rutaPadre = $_REQUEST["ruta"];
//            $conexion = conectar();
//            if ($conexion)
//            {
//                $uidUsuario = $_REQUEST["uidUsuario"];
//                $uidNombreCompleto = $_REQUEST["uidNombreCompleto"];
//                $uidCarpeta = $_REQUEST["uidCarpeta"];
//                $uidIDUsuario = $_REQUEST["uidIDUsuario"];
//                $uidIDGrupo = $_REQUEST["uidIDGrupo"];
//                $uidPassword = $_REQUEST["uidPassword"];
//                
//                crearUID($conexion, $rutaPadre, $uidUsuario, $uidNombreCompleto, $uidCarpeta, $uidIDUsuario, $uidIDGrupo, $uidPassword);
//                
//                header("Location: principal.php?accion=buscar&ruta=" . $rutaPadre);
//            }
//            else
//            {
//                header("Location: ./error.php");
//            }
//            ldap_close($conexion);
                break;
            case "ajaxformmodificaratributo":
                $dn = $_REQUEST["ruta"];
                AJAXFormModificarAtributo($link_identifier, $dn);
                break;
            case "ajaxmodificaratributo":
                $atributo = $_REQUEST["atributo"];
                $contenidoAtributo = $_REQUEST["contenidoAtributo"];
                $ruta = $_REQUEST["ruta"];
                AJAXModificarAtributo($link_identifier, $ruta, $atributo, $contenidoAtributo);
                break;
            case "ajaxformagregaratributo":
                AJAXFormAgregarAtributo();
                break;
            case "ajaxagregaratributo":
                $atributo = $_REQUEST["atributo"];
                $contenidoAtributo = $_REQUEST["contenidoAtributo"];
                $ruta = $_REQUEST["ruta"];
                AJAXAgregarAtributo($link_identifier, $ruta, $atributo, $contenidoAtributo);
                break;
            case "ajaxcontenidoentrada":
                AJAXContenidoArbol($link_identifier);
                break;
            case "ajaxinformacionentrada":
                $ruta = $_REQUEST["ruta"];
                AJAXInformacionEntrada($link_identifier, $ruta);
                break;
            case "ajaxeliminarentrada":
                $ruta = $_POST["ruta"];
                AJAXEliminarEntrada($link_identifier, $ruta);
//                $rutaPadre = rutaPadre($ruta);
//                header("Location: principal.php?accion=buscar&ruta=" . $rutaPadre);
                break;
            case "ajaxobtenerlistaservidores":
                AJAXObtenerListaServidores();
                break;
            case "obtenerlog":
                obtenerLOG();
                break;
            case "borrarlog":
                borrarLOG();
                break;
            case "listar":
                $ruta = $_REQUEST["ruta"];
                listar($link_identifier, $ruta);
                break;
            default:
                escribirLog("El destino no está especificado en el archivo 'controlador.php' y no puede redirigir correctamente", "Error");
        }
    }
    ldap_close($link_identifier);
} else {
    escribirLog("No está especificada la variable superglobal 'accion'", "Error");
    header("Location: ./error.php");
}