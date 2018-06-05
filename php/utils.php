<?php

/*
 * ldap_connect()      --> Establish the conection with the server
 *   |
 * ldap_bind()         --> Anonymous login or authenticated login
 *   |
 * Searchs, updates and others operations
 *   |
 * ldap_close()        --> Close the conection
 * 
 */

// Función que realizar la conexión y la autenticación con el servidor
function conectar() {
    escribirLog("Petición para conexión al servidor LDAP", "Debug");
    $server = $_SESSION["servidor"];
    $link_identifier = ldap_connect($server) or die("No se puede conectar al servidor LDAP.");
    ldap_set_option($link_identifier, LDAP_OPT_PROTOCOL_VERSION, 3); // Esta línea soluciona el error del protocolo
    if ($link_identifier) {
        escribirLog("Conexión con el servidor LDAP realizada correctamente", "Info");
        $dn = $_SESSION["cn"] . "," . $_SESSION["basedn"];
        $pass = $_SESSION["clave"];
        $ldap_bind = ldap_bind($link_identifier, $dn, $pass);
        if ($ldap_bind) {
            escribirLog("Identificación con el servidor LDAP realizada correctamente", "Info");
            return $link_identifier;
        } else {
            escribirLog("Hubo un error con la identificación al servidor LDAP"
                    . "\nNúmero error: " . ldap_errno($link_identifier)
                    . "\nError: " . ldap_error($link_identifier), "Critical");
            return false;
        }
    } else {
        escribirLog("No se pudo realizar la conexión al servidor LDAP"
                . "\nNúmero error: " . ldap_errno($link_identifier)
                . "\nError: " . ldap_error($link_identifier), "Critical");
        return false;
    }
}


// Función que lista las entradas de un DN a un solo nivel
function agregarEntradasUnNivel($link_identifier, $path) {
    $filter = "(|(uid=*)(cn=*)(ou=*)(objectClass=*)(uniquemember=*)(o=*))";
    $result = ldap_list($link_identifier, $path, $filter); //, [], 0, 1000);
    $data = ldap_get_entries($link_identifier, $result);
    if ($data["count"] > 0) {
        echo "<ul>";
        for ($i = 0; $i < count($data) - 1; $i++) {
            $entry = $data[$i]["dn"];
            if ($entry != $path) {
                ?><li id="<?php echo $entry ?>"
                    data-jstree='{"opened":true,"icon":"../images/icons/<?php
                    switch (before("=", $entry)) {
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
                        echo before(",", $entry);
                        agregarEntradasUnNivel($link_identifier, $entry);
                        ?></li><?php
            }
        }
        ?></ul><?php
    }
}

// Función que retorna lo posterior al parámetro pasado
function after($substr, $str) {
    if (!is_bool(strpos($str, $substr))) {
        return substr($str, strpos($str, $substr) + strlen($substr));
    }
}

// Función que retorna lo anterior al parámetro pasado
function before($substr, $str) {
    return substr($str, 0, strpos($str, $substr));
}

// Función que retorna lo comprendido entre ambos parámetros
function between($firstsubstr, $secondsubstr, $str) {
    return before($secondsubstr, after($firstsubstr, $str));
}

// Función que transforma "admin.group" en "cn=admin,ou=group" (transforma todo lo anterior a '@')
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

// Función que transforma 'example.com' en 'dc=example,dc=com' (transforma todo lo posterio a '@')
function extraerBaseDN($dominioCompleto) {
    $todosLosDominios = explode(".", $dominioCompleto);
    $baseDN = "";
    for ($i = 0; $i < count($todosLosDominios); $i++) {
        $baseDN = $baseDN . ",dc=" . $todosLosDominios[$i];
    }
    return substr($baseDN, 1); // Me elimina el "," del principio
}