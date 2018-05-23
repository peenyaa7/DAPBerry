<?php
session_start();
include_once './utilities.php';
$ruta = $_REQUEST["ruta"];
?>
<!--<div id="crearUsuario" class="tab-pane fade">-->
    <!--<h3>Menu 2</h3>-->
    <p>Un usuario es aquella persona que utiliza un dispositivo o un ordenador y realiza 
        múltiples operaciones con distintos propósitos. A menudo es un usuario aquel que
        adquiere una computadora o dispositivo electrónico y que lo emplea para comunicarse
        con otros usuarios, generar contenido y documentos, utilizar software de diverso
        tipo y muchas otras acciones posibles.</p>
    <form action="controlador.php" method="GET">
        <table class="formAgregar">
            <tr>
                <td><label class="obligatorio">Nombre de usuario (uid):</label></td>
                <td><input type="text" name="uidUsuario" id="uidUsuario" placeholder="Obligatorio"/></td>
            </tr>
            <tr>
                <td><label class="obligatorio">Nombre comun (cn):</label></td>
                <td><input type="text" name="uidNombreComun" id="uidNombreComun" placeholder="Obligatorio"/></td>
            </tr>
            <tr>
                <td><label class="obligatorio">Nombre de la carpeta personal:</label></td>
                <td><input type="text" name="uidCarpeta" id="uidCarpeta" value="/home/" placeholder="Obligatorio"/></td>
            </tr>
            <tr>
                <td><label class="obligatorio">ID Usuario:</label></td>
                <td><input type="text" name="uidIDUsuario" id="uidIDUsuario" placeholder="Obligatorio"/></td>
            </tr>
            <tr>
                <td><label class="obligatorio">ID grupo:</label></td>
                <td><input type="text" name="uidIDGrupo" id="uidIDGrupo" placeholder="Obligatorio"/></td>
            </tr>
            <tr>
                <td><label class="obligatorio">Contraseña:</label></td>
                <td><input type="text" name="uidPassword" id="uidPassword" placeholder="Obligatorio"/></td>
            </tr>
            <!--                </table>
                            <button data-toggle="collapse" data-target="#uidOpciones">Abrir</button>
                            <div class="collapse" id="uidOpciones">
                            <table class="formAgregar">-->
            <tr>
                <td><label>Nombre completo:</label></td>
                <td><input type="text" name="uidNombreCompleto" id="uidNombreCompleto" placeholder="Opcional"/></td>
            </tr>
            <tr>
                <td><label>Nombre ciudad:</label></td>
                <td><input type="text" name="uidCiudad" id="uidCiudad" placeholder="Opcional"/></td>
            </tr>
            <tr>
                <td><label>Expiración contraseña:</label></td>
                <td><input type="text" name="uidClaveExpiracion" id="uidClaveExpiracion" placeholder="Opcional"/></td>
            </tr>
            <tr>
                <td><label>Dias maximos de validez de la contraseña:</label></td>
                <td><input type="text" name="uidClaveMax" id="uidClaveMax" placeholder="Opcional"/></td>
            </tr>
            <tr>
                <td><label>Dias minimos de validez de la contraseña:</label></td>
                <td><input type="text" name="uidClaveMin" id="uidClaveMin" placeholder="Opcional"/></td>
            </tr>
            <tr>
                <td><label>Dias para el aviso de expiracion de contraseña:</label></td>
                <td><input type="text" name="ouClaveAviso" id="ouClaveAviso" placeholder="Opcional"/></td>
            </tr>
            <tr>
                <td><label>Descipcion:</label></td>
                <td><input type="text" name="uidDescripcion" id="uidDescripcion" placeholder="Opcional"/></td>
            </tr>
        </table>
        <!--</div>-->
        <input type="hidden" name="ruta" value="<?php echo $ruta ?>"/>
        <input type="submit" class="btn btn-success" name="accion" value="Crear usuario"/>
    </form>
<!--</div>-->