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
    $ldap_server = $_SESSION["servidor"];
    $ldap_conn = ldap_connect($ldap_server) or die("No se puede conectar al servidor LDAP.");
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3); // Esto soluciona el error del protocolo
    if ($ldap_conn) {
        $RDN = $_SESSION["cn"] . "," . $_SESSION["basedn"];
        $ldap_pass = $_SESSION["clave"];
        $ldap_bind = ldap_bind($ldap_conn, $RDN, $ldap_pass);
        if ($ldap_bind) {
            return $ldap_conn;
        } else {
            checkeo($ldap_conn);
            return false;
        }
    } else {
        checkeo($ldap_conn);
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

// function sacarNAME($cadena) {
//     if (strpos($cadena, "NAME '")) {
//         $despuesNAME = after("NAME '", $cadena);
//         $antesSegundaComa = before("'", $despuesNAME);
//         $NAME = $antesSegundaComa;
//     } elseif (strpos($cadena, "NAME (")) {
//         $despuesNAME = after("NAME (", $cadena);
//         $antesSegundoParentesis = before(")", $despuesNAME);
//         $NAME = $antesSegundoParentesis;
//     } else {
//         $NAME = "";
//     }
//     return $NAME;
// }
//
// function sacarDESC($cadena) {
//     if (strpos($cadena, "DESC")) {
//         $despuesDESC = after("DESC", $cadena);
//         $despuesPrimeraComa = after("'", $despuesDESC);
//         $antesSegundaComa = before("'", $despuesPrimeraComa);
//         $DESC = $antesSegundaComa;
//     } else {
//         $DESC = "";
//     }
//     return $DESC;
// }
//
// function sacarSUP($cadena) {
//     if (strpos($cadena, "SUP")) {
//         $despuesSUP = after("SUP ", $cadena);
//         $antesSegundaComa = before(" ", $despuesSUP);
//         $SUP = $antesSegundaComa;
//     } else {
//         $SUP = "";
//     }
//     return $SUP;
// }
//
// function sacarTYPE($cadena) {
//     if (strpos($cadena, "STRUCTURAL")) {
//         $TYPE = "STRUCTURAL";
//     } else if (strpos($cadena, "AUXILIARY")) {
//         $TYPE = "AUXILIARY";
//     } else if (strpos($cadena, "ABSTRACT")) {
//         $TYPE = "ABSTRACT";
//     } else {
//         $TYPE = "";
//     }
//     return $TYPE;
// }
//
// function sacarMUST($cadena) {
//     if (strpos($cadena, "MUST '")) {
//         $despuesMUST = after("MUST '", $cadena);
//         $antesSegundaComa = before("'", $despuesMUST);
//         $MUST = $antesSegundaComa;
//     } else if (strpos($cadena, "MUST (")) {
//         $despuesMUST = after("MUST (", $cadena);
//         $antesSegundoParentesis = before(")", $despuesMUST);
//         $MUST = $antesSegundoParentesis;
//     } else {
//         $MUST = "";
//     }
//     return $MUST;
// }
//
// function sacarMAY($cadena) {
//     if (strpos($cadena, "MAY '")) {
//         $despuesMAY = after("MAY '", $cadena);
//         $despuesPrimerParentesis = after("'", $despuesMAY);
//         $antesSegundoParentesis = before("'", $despuesPrimerParentesis);
//         $MAY = $antesSegundoParentesis;
//     } else if (strpos($cadena, "MAY (")) {
//         $despuesMAY = after("MAY (", $cadena);
//         $antesSegundoParentesis = before(")", $despuesMAY);
//         $MAY = $antesSegundoParentesis;
//     } else {
//         $MAY = "";
//     }
//     return $MAY;
// }

function crearOU($conexion, $rutaPadre, $ou) {
    $datos["objectClass"][0] = "top";
    $datos["objectClass"][1] = "organizationalUnit";
    $datos["ou"] = $ou;

    $dn = "ou=" . $ou . "," . $rutaPadre;

    $resultados = ldap_add($conexion, $dn, $datos);
    ldap_free_result($resultados);
}

function crearUID($conexion, $rutaPadre, $uidUsuario, $uidNombreComun, $uidCarpeta, $uidIDUsuario, $uidIDGrupo, $uidPassword) {
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
    $resultados = ldap_add($conexion, $dn, $datos);
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

function crearDispositivo($cn) {
    $conexion = conectar();
    if ($conexion) {
        $datos["objectClass"][0] = "top";
        $datos["objectClass"][1] = "device";
        $datos["cn"][0] = $cn;
        $rutaPadre = "uid = evilla, dc = francisco, dc = com";
        $result = ldap_add($conexion, $rutaPadre, $datos);
        ldap_free_result($result);
        ldap_close($conexion);
    }
}

function crearArbol($rutaPadre) {
    $conexion = conectar();
    echo $rutaPadre . "</br>";
    agregarEntradasUnNivel($conexion, $rutaPadre);
    ldap_close($conexion);
}

function agregarEntradasUnNivel($conexion, $rutaPadre) {
    $filtro = "(|(uid=*)(cn=*)(ou=*)(objectClass=*)(uniquemember=*)(o=*))";
    $resultados = ldap_list($conexion, $rutaPadre, $filtro); //, [], 0, 1000);
    $datos = ldap_get_entries($conexion, $resultados);
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
                        agregarEntradasUnNivel($conexion, $entrada);
                        ?></li><?php
            }
        }
        ?></ul><?php
    }
}

function eliminarEntrada($conexion, $ruta) {

    $entradas = ldap_list($conexion, $ruta, "ObjectClass=*", array(""));
    $datos = ldap_get_entries($conexion, $entradas);
    for ($i = 0; $i < $datos['count']; $i++) {
        // Eliminando recursivamente sub-entradas
        $result = eliminarEntrada($conexion, $datos[$i]['dn']);
        if (!$result) {
            //return result code, if delete fails
            return($result);
        }
    }
    return(ldap_delete($conexion, $ruta));
}

function listar($rutaPadre) {
    $ruta = $rutaPadre;
    $conexion = conectar();
    $filtro = "(|(uid=*)(cn=*)(ou=*)(objectClass=*)(uniquemember=*)(o=*))";
    $resultados = ldap_list($conexion, $ruta, $filtro);
    $entries = ldap_get_entries($conexion, $resultados);
    if (ldap_count_entries($conexion, $resultados) > 0) {
        ?>
        <table class="rejilla">
            <thead>
                <tr>
                    <th><?php echo "El numero de entradas encontradas es: " . ldap_count_entries($conexion, $resultados); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody><?php
                for ($i = 0; $i < $entries["count"]; $i++) {
                    ?>
                    <tr dn="<?php echo $entries[$i]["dn"] ?>">
                        <td><?php echo $entries[$i]["dn"] ?></td>
                        <td>
                            <i class="material-icons button info" id="infoEntrada" onclick="informacionEntrada(this)">info</i>
                            <i class="material-icons button edit" id="editarEntrada" onclick="">edit</i>
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
    ldap_close($conexion);
}

function escribirLog($cadena, $type) {
    /*
     * Types of errors
     * - Info
     * - Error
     * - Warn
     * - Debug
     * - Critical
     */

    if (isset($_SESSION["cn"]) && isset($_SESSION["basedn"])) {
        $user = $_SESSION["cn"] . "," . $_SESSION["basedn"];
    } else {
        $user = "Usuario no especificado";
    }

    if (isset($_SESSION["servidor"])) {
        $server = $_SESSION["servidor"];
    } else {
        $server = "Servidor no especificado";
    }
    $path = "../log/log.txt";
    if (file_exists($path)) {
//        echo "el fichero existe";
        if (is_writable($path)) {
//            echo "el fichero es writable";
            $fechaLog = "[" . date("Y-m-d H:i:s") . "]";
            $serverLog = "[" . $server . "]";
            $userLog = "[" . $user . "]";
            $typeLog = "[" . $type . "]";
            $file = fopen($path, "a+"); // El modo 'a+' es para apertura para escritura y lectura, tambien coloca el puntero al final del fichero.
            fwrite($file, $cadena . " < " . $typeLog . $userLog . $serverLog . $fechaLog);
            fwrite($file, "\n");
            fclose($file);
        } else {
            echo "<p>El log no tiene permisos de escritura.</p>";
        }
    } else {
        echo "<p>El fichero LOG no existe</p>";
    }
}

function obtenerLOG() {
    $path = "../log/log.txt";
    $file = fopen($path, "r") or exit("Imposible abrir el fichero!!");

    $file_lines = count(file($path)); //Count the lines of a file
    if ($file_lines > 0) {
        ?>
        <table class="rejilla">
            <?php
            $contador = 0;
            while (!feof($file)) {
                $contador++;
                echo "<tr><td>" . $contador . "</td><td>" . fgets($file) . "</td></tr>";
            }
            ?>
        </table>
        <?php
    } else {
        echo "<p>No hay registros en el log :(</p>";
    }
}

function borrarLOG() {
    $path = "../log/log.txt";
    $file = fopen($path, "w+") or exit("Imposible abrir el fichero!!");
    fwrite($file, "");
    fclose($file);
}
