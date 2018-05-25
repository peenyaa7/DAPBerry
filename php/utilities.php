<?php

//session_start();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
  ldap_connect()    // establecer la conexión con el servidor
  |
  ldap_bind()       // login anónimo o autentificado
  |
  Hacer búsquedas o actualizaciones en el directorio
  y mostrar los resultados
  |
  ldap_close()      // Cerrar la conexión
 */

function conectar() {
    escribirLog("Petición para conexión al servidor LDAP", "Debug");
    $ldap_server = $_SESSION["servidor"];
    $link_identifier = ldap_connect($ldap_server) or die("No se puede conectar al servidor LDAP.");
    ldap_set_option($link_identifier, LDAP_OPT_PROTOCOL_VERSION, 3); // Esto soluciona el error del protocolo
    if ($link_identifier) {
        escribirLog("Conexión con el servidor LDAP realizada correctamente", "Info");
        $RDN = $_SESSION["cn"] . "," . $_SESSION["basedn"];
        $ldap_pass = $_SESSION["clave"];
        $ldap_bind = ldap_bind($link_identifier, $RDN, $ldap_pass);
        if ($ldap_bind) {
            escribirLog("Identificación con el servidor LDAP realizada correctamente", "Info");
            return $link_identifier;
        } else {
            escribirLog("Hubo un error con la identificación al servidor LDAP"
                    . "\nNúmero error: " . ldap_errno($link_identifier)
                    . "\nError: " . ldap_error($link_identifier), "Critical");
            checkeo($link_identifier);
            return false;
        }
    } else {
        escribirLog("No se pudo realizar la conexión al servidor LDAP"
                . "\nNúmero error: " . ldap_errno($link_identifier)
                . "\nError: " . ldap_error($link_identifier), "Critical");
        checkeo($link_identifier);
        return false;
    }
}

function error() {
    header("Location: error.php");
}

function checkeo($link_identifier) {
    if (ldap_errno($link_identifier) > 0) {
        echo "<hr>";
        echo "Se ha producido un error.<br>";
        echo "ERROR --> " . ldap_error($link_identifier);
        echo "<hr>";
    }
}

function extraerCN($usuario) {
    $array = explode(".", $usuario);
    if (count($array) > 1) {
        $usuarioFinal = "cn=" . $array[0];
        for ($i = 1; $i < count($array); $i++) {
            $usuarioFinal = $usuarioFinal . ",ou=" . $array[$i];
        }
    } else {
        $usuarioFinal = "cn=" . $usuario;
    }
    return $usuarioFinal;
}

function extraerBaseDN($dominioCompleto) {
//        $numeroDominios = substr_count($dominioCompleto, ".");
//        echo "Nombre del usuario: " . $usuario . "<br>";
//        echo "Base DN: " . $dominioCompleto . "<br>";
//        echo "El numero de dominios es: " . $numeroDominios . "<br>";
    $todosLosDominios = explode(".", $dominioCompleto);
    $baseDN = "";
    for ($i = 0; $i < count($todosLosDominios); $i++) {
        $baseDN = $baseDN . ",dc=" . $todosLosDominios[$i];
    }
    return substr($baseDN, 1); // Me elimina el "," del principio
}

function after($substr, $str) {
    if (!is_bool(strpos($str, $substr))) {
        return substr($str, strpos($str, $substr) + strlen($substr));
    }
}

function before($substr, $str) {
    return substr($str, 0, strpos($str, $substr));
}

function between($firstsubstr, $secondsubstr, $str) {
    return before($secondsubstr, after($firstsubstr, $str));
}

function rutaPadre($ruta) {
    return after(",", $ruta);
}

function crearOU($link_identifier, $rutaPadre, $ou) {
    escribirLog("Creación de unidad organizativa...", "Debug");
    $datos["objectClass"][0] = "top";
    $datos["objectClass"][1] = "organizationalUnit";
    $datos["ou"] = $ou;

    $dn = "ou=" . $ou . "," . $rutaPadre;

    $resultados = ldap_add($link_identifier, $dn, $datos);
    ldap_free_result($resultados);
}

function crearUID($link_identifier, $rutaPadre, $uidUsuario, $uidNombreComun, $uidCarpeta, $uidIDUsuario, $uidIDGrupo, $uidPassword) {
    $datos["objectClass"][0] = "posixAccount";
    $datos["objectClass"][1] = "shadowAccount";
    $datos["objectClass"][2] = "account";
    $datos["objectClass"][3] = "top";
    $datos["uid"] = $uidUsuario;
    $datos["cn"] = $uidNombreComun;
    $datos["userPassword"] = $uidPassword;
    $datos["gecos"] = $uidNombreComun;
    $datos["homeDirectory"] = $uidCarpeta;
    $datos["uidNumber"] = $uidIDUsuario;
    $datos["gidNumber"] = $uidIDGrupo;
    $datos["loginShell"] = "/bin/bash";
    $datos["shadowExpire"] = -1;
    $datos["shadowLastChange"] = 16431;
    $datos["shadowMax"] = 999999;
    $datos["shadowMin"] = 0;
    $datos["shadowWarning"] = 7;

    $dn = "uid=" . $uidUsuario . "," . $rutaPadre;
    $resultados = ldap_add($link_identifier, $dn, $datos);
    ldap_free_result($resultados);
}

//function crearUIDantiguo($uidUsuario, $uidNombreCompleto, $uidCarpeta, $uidIDUsuario, $uidIDGrupo, $uidPassword)
//{
//    $ldap_server = $_SESSION["servidor"];
//    $ldap_conexion = ldap_connect($ldap_server) or die("No se puede conectar al servidor LDAP.");
//    ldap_set_option($ldap_conexion, LDAP_OPT_PROTOCOL_VERSION, 3); // Esto soluciona el error del protocolo
//    if ($ldap_conexion)
//    {
//        $RDN = $_SESSION["cn"] . "," . $_SESSION["basedn"];
//        $ldap_pass = $_SESSION["clave"];
//        $ldap_bind = ldap_bind($ldap_conexion, $RDN, $ldap_pass);
//        if ($ldap_bind)
//        {
//            $datos["objectClass"][0] = "posixAccount";
//            $datos["objectClass"][1] = "shadowAccount";
//            $datos["objectClass"][2] = "account";
//            $datos["objectClass"][3] = "top";
//            $datos["uid"][0] = $uidUsuario;
////            $datos["givenName"][0] = "Eva";
////            $datos["sn"][0] = "Henares";
//            $datos["cn"][0] = $uidNombreCompleto;
//            $datos["userPassword"][0] = $uidPassword;
//            $datos["gecos"][0] = $uidNombreCompleto;
//            $datos["homeDirectory"][0] = $uidCarpeta;
//            $datos["uidNumber"][0] = $uidIDUsuario;
//            $datos["gidNumber"][0] = $uidIDGrupo;
//            $datos["loginShell"][0] = "/bin/bash";
//            $datos["shadowExpire"][0] = -1;
//            $datos["shadowLastChange"][0] = 16431;
//            $datos["shadowMax"][0] = 999999;
//            $datos["shadowMin"][0] = 0;
//            $datos["shadowWarning"][0] = 7;
////            $datos["mail"][0] = "eva@francisco.com";
//            // - LA RUTA ES LA RUTA PADRE
//            // - EL DN NO SE PONE
//
//            $RDN = "uid=evilla,dc=francisco,dc=com";
//            ldap_add($ldap_conexion, $RDN, $datos);
//        }
//        checkeo($ldap_conexion);
//    }
//    checkeo($ldap_conexion);
//    ldap_unbind($ldap_conexion);
//}
//function crearDispositivo($cn) {
//    $conexion = conectar();
//    if ($conexion) {
//        $datos["objectClass"][0] = "top";
//        $datos["objectClass"][1] = "device";
//        $datos["cn"][0] = $cn;
//        $rutaPadre = "uid = evilla, dc = francisco, dc = com";
//        $result = ldap_add($conexion, $rutaPadre, $datos);
//        ldap_free_result($result);
//        ldap_close($conexion);
//    }
//}

function crearArbol($link_identifier, $rutaPadre) {
    echo $rutaPadre . "</br>";
    agregarEntradasUnNivel($link_identifier, $rutaPadre);
}

function agregarEntradasUnNivel($link_identifier, $rutaPadre) {
    $filtro = "(|(uid=*)(cn=*)(ou=*)(objectClass=*)(uniquemember=*)(o=*))";
    $resultados = ldap_list($link_identifier, $rutaPadre, $filtro); //, [], 0, 1000);
    $datos = ldap_get_entries($link_identifier, $resultados);
    if ($datos["count"] > 0) {
        echo "<ul>";
        for ($i = 0; $i < count($datos) - 1; $i++) {
            $entrada = $datos[$i]["dn"];
            if ($entrada != $rutaPadre) {
                ?><li id="<?php echo $entrada ?>"
                    data-jstree='{"opened":true,"icon":"../images/icons/<?php
                    switch (before("=", $entrada)) {
                        case "ou":
                            echo "icons8-user-groups-filled-25.png";
                            break;
                        case "uid":
                            echo "icons8-user-25.png";
                            break;
                        case "cn":
                            echo "icons8-multiple-devices-25.png";
                            break;
                    }
                    ?>"}'><?php
                        echo before(",", $entrada);
                        agregarEntradasUnNivel($link_identifier, $entrada);
                        ?></li><?php
            }
        }
        ?></ul><?php
    }
}

function listar($link_identifier, $rutaPadre) {


    $ruta = $_REQUEST["ruta"];
    ?>
    <h1><?php echo $_REQUEST["ruta"] ?></h1>
    <?php
    $filtro = "(|(uid=*)(cn=*)(ou=*)(objectClass=*)(uniquemember=*)(o=*))";
    $resultados = ldap_list($link_identifier, $ruta, $filtro);
    $entries = ldap_get_entries($link_identifier, $resultados);
    if (ldap_count_entries($link_identifier, $resultados) > 0) {
        ?>
        <table class="rejilla">
            <thead>
                <tr>
                    <th><?php echo "El numero de entradas encontradas es: " . ldap_count_entries($link_identifier, $resultados); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody><?php for ($i = 0; $i < $entries["count"]; $i++) {
            ?>
                    <tr dn="<?php echo $entries[$i]["dn"] ?>">
                        <td><?php echo $entries[$i]["dn"] ?></td>
                        <td>
                            <i class="material-icons button info" id="infoEntrada" onclick="informacionEntrada(this)">info</i>
                            <i class="material-icons button edit" id="editarEntrada" onclick="modificarEntrada(this)">edit</i>
                            <i class="material-icons button delete" id="eliminarEntrada" onclick="eliminarEntrada(this)">delete</i>
                        </td>
                    </tr><?php } ?>
            </tbody>
        </table>
        <!--<form action="./controlador.php" method="GET">-->
            <!--<input type="submit" id="nuevaEntrada" class="btn btn-success" name="accion" value="+ Nueva entrada"/>-->
        <!--</form>-->
        <?php
    } else {
//        echo "<p>El numero de entradas encontradas es: " . ldap_count_entries($conexion, $resultados) . "</p>";
        echo "<p>No se han encontrado entradas :(</p>";
        echo "<p>¿Crear una?</p>";
    }
    ldap_free_result($resultados);
    ?>
    <button class="btn btn-success" id="nuevaEntrada" onclick="nuevaEntrada('<?php echo $ruta ?>')"><i class="material-icons">add_box</i> Nueva entrada</button>
    <!--</div>-->
    <!--<div class="clear"></div>-->




<?php








}
