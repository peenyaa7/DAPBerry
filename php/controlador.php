<?php

session_start();
include_once './utilities.php';
include_once './funciones.php';

if (isset($_REQUEST["accion"]))
{
    $accion = $_REQUEST["accion"];
    $accion = strtolower($accion);
    $accion = str_replace(" ", "", $accion);
    switch ($accion)
    {
        case "irapagina":
            $_SESSION["nombrepagina"] = $_REQUEST["pagina"];
            header("Location: principal.php");
            break;
        case "acceder":
            $_SESSION["servidor"] = $_REQUEST["servidor"];
            $_SESSION["cn"] = extraerCN($_REQUEST["usuario"]);
            $_SESSION["basedn"] = extraerBaseDN($_REQUEST["dominio"]);
            $_SESSION["clave"] = $_REQUEST["clave"];

            if (conectar())
            {
                $_SESSION["nombrepagina"] = "home";
                escribirLog("Inicio de sesión", "Info");
                header("Location: principal.php");
            }
            else
            {
                escribirLog("No se pudo iniciar sesión", "Error");
                header("Location: ../index.php");
            }
            break;
        case "ajaxformulariounidadorganizativa":
            $ruta = $_REQUEST["ruta"];
            escribirLog("Petición AJAX al servidor (Formulario de unidad organizativa)", "Debug");
            AJAXFormularioUnidadOrganizativa($ruta);
            break;
        case "ajaxagregarunidadorganizativa":
            $conexion = conectar();
            if ($conexion)
            {
                $ouUnidadOrganizativa = $_REQUEST["ouUnidadOrganizativa"];
                $rutaPadre = $_REQUEST["ruta"];
                escribirLog("Éxito al conectar al servidor LDAP al agregar una unidad organizativa", "Debug");
                crearOU($conexion, $rutaPadre, $ouUnidadOrganizativa);

                header("Location: principal.php?ruta=" . $rutaPadre);
            }
            else
            {
                escribirLog("No se pudo conectar al servidor LDAP al agregar una unidad organizativa", "Error");
                header("Location: ./error.php");
            }
            ldap_close($conexion);
            break;
        case "ajaxagregarusuario":
            $conexion = conectar();
            if ($conexion)
            {
                $uidUsuario = $_REQUEST["uidUsuario"];
                $uidNombreComun = $_REQUEST["uidNombreComun"];
                $uidCarpeta = $_REQUEST["uidCarpeta"];
                $uidIDUsuario = $_REQUEST["uidIDUsuario"];
                $uidIDGrupo = $_REQUEST["uidIDGrupo"];
                $uidPassword = $_REQUEST["uidPassword"];
                $rutaPadre = $_REQUEST["ruta"];
                escribirLog("Éxito al conectar al servidor LDAP al agregar un nuevo usuario", "Debug");
                crearUID($conexion, $rutaPadre, $uidUsuario, $uidNombreComun, $uidCarpeta, $uidIDUsuario, $uidIDGrupo, $uidPassword);

                header("Location: principal.php?ruta=" . $rutaPadre);
            }
            else
            {
                escribirLog("No se pudo conectar al servidor LDAP al agregar un nuevo usuario", "Error");
                header("Location: ./error.php");
            }
            ldap_close($conexion);
            break;
        case "ajaxinformacionaplicacion":
            escribirLog("Petición AJAX al servidor LDAP (Información de la aplicación)", "Debug");
            AJAXInformacionAplicacion();
            break;
        case "crearusuario":
            $rutaPadre = $_REQUEST["ruta"];
            $conexion = conectar();
            if ($conexion)
            {
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
                escribirLog("Éxito al conectar al servidor LDAP para crear un nuevo usuario", "Debug");
                crearUID($conexion, $rutaPadre, $uidUsuario, $uidNombreCompleto, $uidCarpeta, $uidIDUsuario, $uidIDGrupo, $uidPassword);

                header("Location: principal.php?accion=buscar&ruta=" . $rutaPadre);
            }
            else
            {
                escribirLog("No se pudo conectar al servidor LDAP para crear un nuevo usuario", "Error");
                header("Location: ./error.php");
            }
            ldap_close($conexion);
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
            $conexion = conectar();
            if ($conexion)
            {
                escribirLog("Éxito al conectar al servidor LDAP para la petición AJAX del formulario de modificar atributo", "Debug");
                $dn = $_REQUEST["ruta"];
                AJAXFormModificarAtributo($conexion, $dn);
            }
            else
            {
                escribirLog("No se pudo conectar al servidor LDAP para la petición AJAX del formulario de modificar atributo", "Error");
                header("Location: ./error.php");
            }
            ldap_close($conexion);
            break;
        case "ajaxmodificaratributo":
            $conexion = conectar();
            if ($conexion)
            {
                $atributo = $_REQUEST["atributo"];
                $contenidoAtributo = $_REQUEST["contenidoAtributo"];
                $ruta = $_REQUEST["ruta"];
                escribirLog("Éxito al conectar al servidor LDAP para modificar un atributo", "Debug");
                AJAXModificarAtributo($conexion, $ruta, $atributo, $contenidoAtributo);
            }
            else
            {
                escribirLog("No se pudo conectar al servidor LDAP para modificar un atributo", "Error");
            }
            break;
            ldap_close($conexion);
        case "ajaxformagregaratributo":
            escribirLog("Petición AJAX para el formulario de agregar un atributo", "Debug");
            AJAXFormAgregarAtributo();
            break;
        case "ajaxagregaratributo":
            $conexion = conectar();
            if ($conexion) {
                $atributo = $_REQUEST["atributo"];
                $contenidoAtributo = $_REQUEST["contenidoAtributo"];
                $ruta = $_REQUEST["ruta"];
                escribirLog("Éxito al conectar al servidor LDAP al hacer la petición AJAX para agregar un atributo", "Debug");
                AJAXAgregarAtributo($conexion, $ruta, $atributo, $contenidoAtributo);
            }
            break;

        case "ajaxcontenidoentrada":
            escribirLog("Petición AJAX para el contenido del arbol LDAP", "Debug");
            AJAXContenidoArbol();
            break;
        case "ajaxinformacionentrada":
            // Primero me conecto
            $conexion = conectar();
            if ($conexion)
            {
                $ruta = $_REQUEST["ruta"];
                escribirLog("Éxito al conectar al servidor LDAP al hacer la petición AJAX para la información de una entrada (".$ruta.")", "Debug");
                AJAXInformacionEntrada($conexion, $ruta);
            }
            else
            {
                escribirLog("No se pudo conectar al servidor LDAP al hacer la petición AJAX para la información de una entrada", "Error");
            }
            // Cerramos la conexion
            ldap_close($conexion);
            break;
        case "ajaxeliminarentrada":
            $ruta = $_POST["ruta"];
            $conexion = conectar();
            if ($conexion)
            {
                escribirLog("Éxito al conectar al servidor LDAP al hacer una petición AJAX para eliminar una entrada (".$ruta.")", "Debug");
                eliminarEntrada($conexion, $ruta);
//                $rutaPadre = rutaPadre($ruta);
//                header("Location: principal.php?accion=buscar&ruta=" . $rutaPadre);
            }
            else
            {
                escribirLog("No se pudo conectar al servidor LDAP al hacer una petición AJAX para eliminar una entrada (".$ruta.")", "Error");
                header("Location: ./error.php");
            }
            ldap_close($conexion);
            break;
        case "obtenerlog":
            obtenerLOG();
            break;
        case "borrarlog":
            borrarLOG();
            break;
        default:
            escribirLog("El destino no está especificado en el archivo 'controlador.php' y no puede redirigir correctamente", "Error");
    }
}
else
{
    escribirLog("No está especificada la variable superglobal 'accion'", "Error");
}