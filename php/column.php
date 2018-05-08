<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- En CSS la TarjetaUsuario sera TU -->
<div id="TU">
    <div id="TUAvatar" class="normalElement">
        <img src="../images/avatars/man.png" alt="Avatar"/>
    </div>
    <div id="TUSalir" class="normalElement">
        <button class="btn btn-dark"><i class="material-icons">exit_to_app</i><p>Salir</p></button>
    </div>
    <div id="TUAyuda" class="rigthElement">
        <button class="btn btn-secondary">
        <!--<img src="../images/icons/help.png" class="icon" alt="Información"/>-->
            <i class="material-icons">help_outline</i>
        </button>
    </div>
    <div id="TURefrescar" class="rigthElement">
        <button class="btn btn-danger">
        <!--<img src="../images/icons/refresh.png" class="icon" alt="Refrescar"/>-->
            <i class="material-icons">refresh</i>
        </button>
    </div>
    <div id="TUInformacion" class="downElement">
        <table>
            <tr>
                <th><i class="material-icons">person_outline</i> Usuario: </th>
                <td>
                    <?php
                    if ($_SESSION["cn"] !== "")
                    {
                        echo $_SESSION["cn"];
                    }
                    else
                    {
                        echo "- Usuario -";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th><i class="material-icons">public</i> Dominio: </th>
                <td>
                    <?php
                    if ($_SESSION["basedn"] !== "")
                    {
                        echo $_SESSION["basedn"];
                    }
                    else
                    {
                        echo "- Dominio -";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th><i class="material-icons">desktop_windows</i> Servidor: </th>
                <td>
                    <?php
                    if ($_SESSION["servidor"] !== "")
                    {
                        echo $_SESSION["servidor"];
                    }
                    else
                    {
                        echo "- Servidor -";
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="clear"></div>
</div>
<div class="horizontalHole"></div>
<!-- B de Buscar -->
<div id="B">
    <input type="text" id="buscarArbol" placeholder=" Busca aqui"/>
</div>
<div class="horizontalHole"></div>
<form id="treeLDAPForm">
</form>