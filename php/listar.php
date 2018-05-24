<!--<div id="titulo">
    Búsqueda de objetos en árbol LDAP
</div>-->
<?php
session_start();
include_once 'utilities.php';
$ruta = $_REQUEST["ruta"];
?>
<!--<div id="contenido">-->
    <h1><?php echo $_REQUEST["ruta"] ?></h1>
    <?php
    $conexion = conectar();
    $filtro = "(|(uid=*)(cn=*)(ou=*)(objectClass=*)(uniquemember=*)(o=*))";
    $resultados = ldap_list($conexion, $ruta, $filtro);
    $entries = ldap_get_entries($conexion, $resultados);
    if (ldap_count_entries($conexion, $resultados) > 0)
    {
        ?>
        <table class="rejilla">
            <thead>
                <tr>
                    <th><?php echo "El numero de entradas encontradas es: " . ldap_count_entries($conexion, $resultados); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody><?php for ($i = 0; $i < $entries["count"]; $i++)
        { ?>
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
    }
    else
    {
//        echo "<p>El numero de entradas encontradas es: " . ldap_count_entries($conexion, $resultados) . "</p>";
        echo "<p>No se han encontrado entradas :(</p>";
        echo "<p>¿Crear una?</p>";
    }
    ldap_free_result($resultados);
    ldap_close($conexion);
    ?>
        <button class="btn btn-success" id="nuevaEntrada" onclick="nuevaEntrada('<?php echo $ruta ?>')"><i class="material-icons">add_box</i> Nueva entrada</button>
<!--</div>-->
<!--<div class="clear"></div>-->