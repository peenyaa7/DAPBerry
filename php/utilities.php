<?php
include_once './utils_functions.php';

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

function crearOU($link_identifier, $path, $ouName) {
    escribirLog("Creación de unidad organizativa...", "Debug");

    $data["objectClass"][0] = "top";
    $data["objectClass"][1] = "organizationalUnit";
    $data["ou"] = $ouName;

    $dn = "ou=" . $ouName . "," . $path;
    $result = ldap_add($link_identifier, $dn, $data);

    if ($result) {
        escribirLog("Se ha creado la unidad organizativa '" . $dn . "' correctamente", "Info");
    } else {
        escribirLog("Error al crear la unidad organizativa '" . $dn . "'"
                . "\nNúmero error: " . ldap_errno($link_identifier)
                . "\nError: " . ldap_error($link_identifier), "Error");
    }

    ldap_free_result($result);
}

function crearUID($link_identifier, $path, $uidUser, $uidCommonName, $uidHomeFolder, $uidIDUser, $uidIDGroup, $uidPassword) {
    escribirLog("Creación de usuario...", "Debug");

    $data["objectClass"][0] = "posixAccount";
    $data["objectClass"][1] = "shadowAccount";
    $data["objectClass"][2] = "account";
    $data["objectClass"][3] = "top";
    $data["uid"] = $uidUser;
    $data["cn"] = $uidCommonName;
    $data["userPassword"] = $uidPassword;
    $data["gecos"] = $uidCommonName;
    $data["homeDirectory"] = $uidHomeFolder;
    $data["uidNumber"] = $uidIDUser;
    $data["gidNumber"] = $uidIDGroup;
    $data["loginShell"] = "/bin/bash";
    $data["shadowExpire"] = -1;
    $data["shadowLastChange"] = 16431;
    $data["shadowMax"] = 999999;
    $data["shadowMin"] = 0;
    $data["shadowWarning"] = 7;

    $dn = "uid=" . $uidUser . "," . $path;
    $result = ldap_add($link_identifier, $dn, $data);

    if ($result) {
        escribirLog("Se ha creado el usuario '$dn' correctamente", "Info");
    } else {
        escribirLog("Error al crear el usuario '$dn'"
                . "\nNúmero error: " . ldap_errno($link_identifier)
                . "\nError: " . ldap_error($link_identifier), "Error");
    }

    ldap_free_result($result);
}

function crearCN($link_identifier, $path, $cn) {
    escribirLog("Creación de un dispositivo...", "Debug");
    
    $data["objectClass"][0] = "top";
    $data["objectClass"][1] = "device";
    $data["cn"][0] = $cn;
    
    $dn = "cn=" . $cn . "," . $path;
    $result = ldap_add($link_identifier, $dn, $data);
    if ($result) {
        escribirLog("Se ha agregado el dispositivo '$dn' correctamente", "Info");
    } else {
        escribirLog("Error al agregar el dispositivo '$dn'"
                . "\nNúmero error: " . ldap_errno($link_identifier)
                . "\nError: " . ldap_error($link_identifier), "Error");
    }
    ldap_free_result($result);
}

function crearArbol($link_identifier, $path) {
    echo $path . "</br>";
    agregarEntradasUnNivel($link_identifier, $path);
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

function listar($link_identifier, $path) {
    ?>
    <h1><?php echo $_REQUEST["ruta"] ?></h1>
    <?php
    $filter = "(|(uid=*)(cn=*)(ou=*)(objectClass=*)(uniquemember=*)(o=*))";
    $result = ldap_list($link_identifier, $path, $filter);
    $entries = ldap_get_entries($link_identifier, $result);
    if (ldap_count_entries($link_identifier, $result) > 0) {
        ?>
        <table class="rejilla">
            <thead>
                <tr>
                    <th><?php echo "El numero de entradas encontradas es: " . ldap_count_entries($link_identifier, $result); ?></th>
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
        <?php
    } else {
        echo "<p>No se han encontrado entradas :(</p>";
        echo "<p>¿Crear una?</p>";
    }
    ldap_free_result($result);
    ?>
    <button class="btn btn-success" id="nuevaEntrada" onclick="nuevaEntrada('<?php echo $path ?>')"><i class="material-icons">add_box</i> Nueva entrada</button>
    <?php
}
