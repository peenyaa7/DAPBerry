<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--    <div class="panel panel-warning">
        <div class="panel-heading">Panel with panel-warning class</div>
        <div class="panel-body">Panel Content</div>
    </div>-->


<div id="titulo">
    ¡Bienvenido!
</div>
<div id="contenido">
    <p>Hola <span class="destacarspan"><?php echo after("=",$_SESSION["cn"]) ?></span>, estás en la aplicacion web de Gestion de LDAP</p>
    <p>A la izquierda puedes ver tu tarjeta de usuario donde puedes ver quien eres (por si lo olvidas), y
        un arbol donde se muestra el arbol LDAP asociado a esta cuenta.</p>
    <p>Arriba puedes disfrutar de las diferentes funcionalidades que la pagina ofrece.</p>
    <p>Disfruta y en caso de donacion o querer mas informacion, pinche en 'Info'.</p>
</div>
<div class="clear"></div>