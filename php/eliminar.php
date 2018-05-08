<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="titulo">
    Eliminar entrada LDAP
</div>
<div id="contenido">
    <!--    <form action="#" method="GET">
            <input type="text"
        </form>-->
    <?php
    $ldap_server = $_SESSION["servidor"];
    $ldap_conexion = ldap_connect($ldap_server) or die("No se puede conectar al servidor LDAP.");
    ldap_set_option($ldap_conexion, LDAP_OPT_PROTOCOL_VERSION, 3); // Esto soluciona el error del protocolo
    if ($ldap_conexion) {
        $RDN = $_SESSION["cn"] . "," . $_SESSION["basedn"];
        $ldap_pass = $_SESSION["clave"];
        $ldap_bind = ldap_bind($ldap_conexion, $RDN, $ldap_pass);
        if ($ldap_bind) {
            $RDN = "dc=francisco,dc=com";
            $filter = "uid=*";
            $result = ldap_list($ldap_conexion, $RDN, $filter);
            $entries = ldap_get_entries($ldap_conexion, $result);
//            print_r($entries);
            ?>
            <table class="rejilla">
                <thead>
                    <tr>
                        <th>DN</th>
                        <th>Primera entrada CN</th>
                        <th>Mail</th>
                        <th>Tipo de objeto</th>
                        <!--<th><?php // print_r($entries)  ?></th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($entries); $i++) {
                        ?>
                        <tr style="
                        <?php
                        if ($i % 2 == 0) {
                            echo "background-color: #DCDCDC;";
                        } else {
                            echo "background-color: #BBBBBB;";
                        }
                        ?>
                            ">
                            <td><?php
                                echo $entries[$i]["dn"]
//                                echo ldap_get_dn($ldap_conn, $entries[$i]);
                                ?></td>
                            <td><?php echo $entries[$i]["cn"][0] ?></td>
                            <td>
                                <?php
                                if (isset($entries[$i]["mail"][0])) {
                                    echo $entries[$i]["mail"][0];
                                } else {
                                    echo "Sin correo";
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo $entries[$i]["objectclass"][0] ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                checkeo($ldap_conexion);
            }
            checkeo($ldap_conexion);
            ldap_unbind($ldap_conexion);
            ?>
        </tbody>
    </table>
</div>
<!--<div class="clear"></div>-->