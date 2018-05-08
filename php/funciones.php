<?php


/* FUNCIONES AJAX */

function AJAXInformacionEntrada($conexion, $ruta) {
    // El filtro es el RDN del DN
    $filtro = before(",", $ruta);
    // La ruta padre es todo lo demas
    $rutaPadre = after(",", $ruta);
    // Buscamos en todo el arbol LDAP dicho objeto
    $resultados = ldap_search($conexion, $rutaPadre, $filtro);
    // Obtenemos la primera entrada encontrada
    $entrada = ldap_first_entry($conexion, $resultados);
    // Obtenemos el primer atributo de la primera entrada encontrada
    $atributo = ldap_first_attribute($conexion, $entrada);
    echo "<table class='rejilla'>";
    // Por cada atributo obtengo el valor y lo escribo
    while ($atributo) {
        $valor = ldap_get_values($conexion, $entrada, $atributo);
        for ($i = 0; $i < $valor["count"]; $i++) {
            echo "<tr><td>" . $atributo . "</td><td>" . $valor[$i] . "</td></tr>";
        }
        $atributo = ldap_next_attribute($conexion, $entrada);
    }
    echo "</table>";

    // Liberamos los resultados para recuperar memoria
    ldap_free_result($resultados);
}

function AJAXFormModificarAtributo($conexion, $dn) {
    ?>
    <form>
        <?php
        // El filtro es el RDN del DN
        $filtro = before(",", $dn);
        // La ruta padre es todo lo demas
        $rutaPadre = after(",", $dn);
        // Buscamos en todo el arbol LDAP dicho objeto
        $resultados = ldap_search($conexion, $rutaPadre, $filtro);
        // Obtenemos la primera entrada encontrada
        $entrada = ldap_first_entry($conexion, $resultados);
        // Obtenemos el primer atributo de la primera entrada encontrada
        $atributo = ldap_first_attribute($conexion, $entrada);
        echo "<select id='selector'>";
        // Por cada atributo obtengo el valor y lo escribo
        while ($atributo) {
            $valor = ldap_get_values($conexion, $entrada, $atributo);
//            $contador = 0;
            for ($i = 0; $i < $valor["count"]; $i++) {
                if ($atributo != "objectClass") {
                    echo "<option value='$atributo'>" . $atributo . " --> " . $valor[$i] . "</option>";
                }
            }
            $atributo = ldap_next_attribute($conexion, $entrada);
        }
        echo "</select>";
        echo "<br><input type='text' placeholder='Nuevo contenido' id='contenidoAtributo'>";
        // Liberamos los resultados para recuperar memoria
        ldap_free_result($resultados);
        ?>
    </form>
    <?php
}

function AJAXModificarAtributo($conexion, $ruta, $atributo, $contenidoAtributo) {
    $datos[$atributo] = $contenidoAtributo;
    $resultados = ldap_mod_replace($conexion, $ruta, $datos);
    if ($resultados) {
        // Nothing
    } else {
        alert("Algun error en la funcion 'AJAXModificarAtributo'");
    }
    ldap_free_result($resultados);
}

function AJAXFormAgregarAtributo() {
    ?>
    <form>
        <input type='text' placeholder='Atributo' id='atributo'>
        <input type='text' placeholder='Contenido atributo' id='contenidoAtributo'>
    </form>
    <?php
}

function AJAXAgregarAtributo($conexion, $ruta, $atributo, $contenidoAtributo) {
    $datos[$atributo] = $contenidoAtributo;
    $resultados = ldap_mod_add($conexion, $ruta, $datos);
    if ($resultados) {
        // Nothing
    } else {
        alert("Algun error en la funcion 'AJAXAgregarAtributo'");
    }
    ldap_free_result($resultados);
}

function AJAXContenidoArbol() {
    ?>
    <div id="treeLDAP" class="treeLDAP">
        <ul>
            <li id="<?php echo $_SESSION["basedn"]; ?>" data-jstree='{ "opened" : true }'>
                <?php crearArbol($_SESSION["basedn"]) ?>
            </li>
        </ul>
    </div>
    <?php
}

function AJAXInformacionAplicacion() {
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
