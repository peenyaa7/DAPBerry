<?php
include_once './LOG_functions.php';
/* AJAX FUNCTIONS */

// ADD
function AJAX_crearOU($link_identifier, $path, $ouName) {
    escribirLog("Creación de unidad organizativa...", "Debug");

    $data["objectClass"][0] = "top";
    $data["objectClass"][1] = "organizationalUnit";
    $data["ou"] = $ouName;

    $dn = "ou=" . $ouName . "," . $path;
    $result = ldap_add($link_identifier, $dn, $data);

    if ($result) {
        escribirLog("Se ha creado la unidad organizativa '$dn' correctamente", "Info");
    } else {
        escribirLog("Error al crear la unidad organizativa '" . $dn . "'"
                . "\nNúmero error: " . ldap_errno($link_identifier)
                . "\nError: " . ldap_error($link_identifier), "Error");
    }

    ldap_free_result($result);
}

function AJAX_crearUID($link_identifier, $path, $uidUser, $uidCommonName, $uidHomeFolder, $uidIDUser, $uidIDGroup, $uidPassword) {
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

function AJAX_crearCN($link_identifier, $path, $cn) {
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

function AJAX_agregarAtributo($link_identifier, $dn, $attribute, $attributeContent) {
    escribirLog("Petición AJAX (Agregar atributo)", "Debug");
    $data[$attribute] = $attributeContent;
    $result = ldap_mod_add($link_identifier, $dn, $data);
    if ($result) {
        escribirLog("Se ha agregado el atributo correctamente", "Info");
    } else {
        escribirLog("Ocurrió un error al agregar el atributo"
                . "\nNúmero error: " . ldap_errno($link_identifier)
                . "\nError: " . ldap_error($link_identifier), "Error");
    }
    ldap_free_result($result);
}

// MODIFY
function AJAX_modificarAtributo($link_identifier, $dn, $attribute, $attributeContent) {
    escribirLog("Petición AJAX (Modificar atributo)", "Debug");
    $data[$attribute] = $attributeContent;
    $result = ldap_mod_replace($link_identifier, $dn, $data);
    if ($result) {
        escribirLog("Se ha modificado el atributo correctamente", "Info");
    } else {
        escribirLog("Error al modificar el atributo"
                . "\nNúmero error: " . ldap_errno($link_identifier)
                . "\nError: " . ldap_error($link_identifier), "Error");
    }
    ldap_free_result($result);
}

// DELETE
function AJAX_eliminarEntrada($link_identifier, $dn) {
    escribirLog("Eliminación de la entrada '$dn'", "Debug");
    $entries = ldap_list($link_identifier, $dn, "ObjectClass=*", array(""));
    $data = ldap_get_entries($link_identifier, $entries);
    for ($i = 0; $i < $data['count']; $i++) {
        // Eliminando recursivamente sub-entradas
        $result = eliminarEntrada($link_identifier, $data[$i]['dn']);
        if (!$result) {
            //return result code, if delete fails
            return($result);
        }
    }
    $boolean = ldap_delete($link_identifier, $dn);
    if ($boolean) {
        escribirLog("Entrada '$dn' eliminada correctamente", "Info");
    } else {
        escribirLog("Error al eliminar la entrada '$dn'", "Error");
    }
    return $boolean;
}

function AJAX_eliminarAtributo($link_identifier, $dn, $attribute) {
    escribirLog("Petición AJAX (Eliminar atributo '" . before(":", $attribute) . "' con contenido '" . after(":", $attribute) . "' de la entrada '$dn')", "Debug");
    $data[before(":",$attribute)] = after(":", $attribute);
    $result = ldap_mod_del($link_identifier, $dn, $data);
    if ($result) {
        escribirLog("Se ha eliminado el atributo correctamente", "Info");
    } else {
        escribirLog("Error al eliminar el atributo"
                . "\nNúmero error: " . ldap_errno($link_identifier)
                . "\nError: " . ldap_error($link_identifier), "Error");
    }
    ldap_free_result($result);
}

function AJAX_formEliminarAtributo($link_identifier, $dn) {
    escribirLog("Petición AJAX (Formulario para modificar atributo)", "Debug");
    ?>
    <form>
        <?php
        // El filtro es el RDN del DN
        $filter = before(",", $dn);
        // La ruta padre es todo lo demas
        $path = after(",", $dn);
        // Buscamos en todo el arbol LDAP dicho objeto
        $result = ldap_search($link_identifier, $path, $filter);
        // Obtenemos la primera entrada encontrada
        $entry = ldap_first_entry($link_identifier, $result);
        // Obtenemos el primer atributo de la primera entrada encontrada
        $attribute = ldap_first_attribute($link_identifier, $entry);
        echo "<select id='selector'>";
        // Por cada atributo obtengo el valor y lo escribo
        while ($attribute) {
            $values = ldap_get_values($link_identifier, $entry, $attribute);
//            $contador = 0;
            for ($i = 0; $i < $values["count"]; $i++) {
                if ($attribute != "objectClass") {
                    echo "<option value='$attribute:$values[$i]'>" . $attribute . " --> " . $values[$i] . "</option>";
                }
            }
            $attribute = ldap_next_attribute($link_identifier, $entry);
        }
        echo "</select>";
//        echo "<br><input type='text' placeholder='Nuevo contenido' id='contenidoAtributo'>";
        // Liberamos los resultados para recuperar memoria
        ldap_free_result($result);
        ?>
    </form>
    <?php
}

// OTHERS
function AJAX_informacionEntrada($link_identifier, $dn) {
    escribirLog("Petición AJAX (Información de entrada)", "Debug");
    // El filtro es el RDN del DN
    $filter = before(",", $dn);
    // La ruta padre es todo lo demas
    $path = after(",", $dn);
    // Buscamos en todo el arbol LDAP dicho objeto
    $result = ldap_search($link_identifier, $path, $filter);
    // Obtenemos la primera entrada encontrada
    $entry = ldap_first_entry($link_identifier, $result);
    // Obtenemos el primer atributo de la primera entrada encontrada
    $attribute = ldap_first_attribute($link_identifier, $entry);
    echo "<table class='rejilla'>";
    // Por cada atributo obtengo el valor y lo escribo
    while ($attribute) {
        $values = ldap_get_values($link_identifier, $entry, $attribute);
        for ($i = 0; $i < $values["count"]; $i++) {
            echo "<tr><td>" . $attribute . "</td><td>" . $values[$i] . "</td></tr>";
        }
        $attribute = ldap_next_attribute($link_identifier, $entry);
    }
    echo "</table>";

    // Liberamos los resultados para recuperar memoria
    ldap_free_result($result);
}



function AJAX_contenidoArbol($link_identifier) {
    escribirLog("Petición AJAX (Contenido árbol LDAP)", "Debug");
    escribirLog("Contenido del árbol LDAP agregado correctamente", "Info");
    ?>
    <div id="treeLDAP" class="treeLDAP">
        <ul>
            <li id="<?php echo $_SESSION["basedn"]; ?>" data-jstree='{ "opened" : true }'>
                <?php crearArbol($link_identifier, $_SESSION["basedn"]) ?>
            </li>
        </ul>
    </div>
    <?php
}

function AJAX_informacionAplicacion() {
    escribirLog("Petición AJAX (Información de la aplicación)", "Debug");
    escribirLog("Información de la aplicación agregada correctamente", "Info");
    ?>
    <table>
        <tr>
            <td><img src="../images/Logo.png" alt="DAPBerry" style="width: 105px; height: 150px; margin-left: 50%;"/></td>
            <td><h3>DAPBerry</h3></td>
        </tr>
        <tr>
            <td colspan="2"><p>Este gestor de LDAP llamado 'DAPBerry' está diseñado con el objetivo de que el usuario pueda
                    utilizarlo de forma intuitiva y dinámica gracias a su integracion con AJAX y la interfaz user-friendly que tiene.</p></td>
        </tr>
        <tr>
            <th>Actualizada</th>
            <td>16 de Abril de 2018</td>
        </tr>
        <tr>
            <th>Tamaño</th>
            <td>16MB</td>
        </tr>
        <tr>
            <th>Version Actual</th>
            <td>1.0.0</td>
        </tr>
        <tr>
            <th>Requerimientos</th>
            <td>Servidor LDAP y Navegador</td>
        </tr>
        <tr>
            <th>Clasificación de contenido</th>
            <td>PEGI 3</td>
        </tr>
        <tr>
            <th>Ofrecida por</th>
            <td>Peña Tecnologies</td>
        </tr>
        <tr>
            <th>Desarrollador</th>
            <td>Francisco Javier Peña Vela</td>
        </tr>
        <tr>
            <th>Contacto</th>
            <td>peenyaa7@gmail.com</td>
        </tr>
    </table>
    <?php
}

function AJAX_obtenerListaServidores() {
    escribirLog("Petición AJAX (Obtener lista de servidores)", "Debug");
    $path = "../json/servers.json";
    if (file_exists($path)) {
        escribirLog("Archivo con la lista de servidores encontrado correctamente", "Info");
        ?>
        <table class="rejilla">
            <thead>
                <tr>
                    <th></th>
                    <th>Servidor</th>
                    <th>Dominio</th>
                    <th>Usuario</th>
                    <th>Clave</th>
                </tr>
            </thead>
            <tbody id="servidores">
                <?php
                $contenido = file_get_contents("../json/servers.json");
                $json = json_decode($contenido, true);
                foreach ($json as $key => $value) {
                    ?>
                    <tr>
                        <td><button class='btn btn-success'
                                    style='width: 100%;'
                                    onclick='usarServidor(this);'
                                    servidor="<?php echo $value["servidor"]; ?>"
                                    dominio="<?php echo $value["dominio"]; ?>"
                                    usuario="<?php echo $value["usuario"]; ?>"
                                    clave="<?php echo $value["clave"]; ?>"
                                    >Usar!</button></td>
                        <td><?php echo $value["servidor"]; ?></td>
                        <td><?php echo $value["dominio"]; ?></td>
                        <td><?php echo $value["usuario"]; ?></td>
                        <td><?php echo $value["clave"]; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    } else {
        escribirLog("No se puede encontrar el archivo con la lista de servidores", "Error");
        ?>
        <p>No se pudo encontrar el archivo con la lista de servidores :(</p>
        <?php
    }
}



function crearArbol($link_identifier, $path) {
    echo $path . "</br>";
    agregarEntradasUnNivel($link_identifier, $path);
}

function AJAX_listar($link_identifier, $path) {
    ?>
    <h1><?php echo $path ?></h1>
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
                    <tr>
                        <td><?php echo $entries[$i]["dn"] ?></td>
                        <td>
                            <i class="material-icons button info" id="infoEntrada" onclick="informacionEntrada(this)" dn="<?php echo $entries[$i]["dn"] ?>">info</i>
                            <i class="material-icons button edit" id="editarEntrada" onclick="modificarEntrada(this)" dn="<?php echo $entries[$i]["dn"] ?>">edit</i>
                            <i class="material-icons button delete" id="eliminarEntrada" onclick="eliminarEntrada(this)" dn="<?php echo $entries[$i]["dn"] ?>">delete</i>
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

// FORMS
function AJAX_formModificarAtributo($link_identifier, $dn) {
    escribirLog("Petición AJAX (Formulario para modificar atributo)", "Debug");
    ?>
    <form>
        <?php
        // El filtro es el RDN del DN
        $filter = before(",", $dn);
        // La ruta padre es todo lo demas
        $path = after(",", $dn);
        // Buscamos en todo el arbol LDAP dicho objeto
        $result = ldap_search($link_identifier, $path, $filter);
        // Obtenemos la primera entrada encontrada
        $entry = ldap_first_entry($link_identifier, $result);
        // Obtenemos el primer atributo de la primera entrada encontrada
        $attribute = ldap_first_attribute($link_identifier, $entry);
        echo "<select id='selector'>";
        // Por cada atributo obtengo el valor y lo escribo
        while ($attribute) {
            $values = ldap_get_values($link_identifier, $entry, $attribute);
//            $contador = 0;
            for ($i = 0; $i < $values["count"]; $i++) {
                if ($attribute != "objectClass") {
                    echo "<option value='$attribute'>" . $attribute . " --> " . $values[$i] . "</option>";
                }
            }
            $attribute = ldap_next_attribute($link_identifier, $entry);
        }
        echo "</select>";
        echo "<br><input type='text' placeholder='Nuevo contenido' id='contenidoAtributo'>";
        // Liberamos los resultados para recuperar memoria
        ldap_free_result($result);
        ?>
    </form>
    <?php
}

function AJAX_formAgregarAtributo() {
    escribirLog("Petición AJAX (Formulario para agregar atributo)", "Debug");
    escribirLog("Se ha agregado el formulario correctamente", "Info");
    ?>
    <form>
        <input type='text' placeholder='Atributo' id='atributo'>
        <input type='text' placeholder='Contenido atributo' id='contenidoAtributo'>
    </form>
    <?php
}
