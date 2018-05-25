<?php
include_once './UTILS_functions.php';

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
    $server = $_SESSION["servidor"];
    $link_identifier = ldap_connect($server) or die("No se puede conectar al servidor LDAP.");
    ldap_set_option($link_identifier, LDAP_OPT_PROTOCOL_VERSION, 3); // Esto soluciona el error del protocolo
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

