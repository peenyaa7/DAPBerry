<!DOCTYPE html>
<?php
session_start();
$_SESSION["servidor"] = "";
$_SESSION["cn"] = "";
$_SESSION["basedn"] = "";
$_SESSION["clave"] = "";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Identificacion</title>
        <link rel="icon" type="image/png" href="images/favicon.png"/>
        <!-- Scripts -->
        <script src="scripts/jquery/jquery-3.3.1.js" type="text/javascript"></script>
        <script src="scripts/jquery/jqueryui/jquery-ui.js" type="text/javascript"></script>
        <script src="scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <script src="scripts/particles/particles.js" type="text/javascript"></script>
        <script src="scripts/particles/app.js" type="text/javascript"></script>
        <script src="scripts/login.js" type="text/javascript"></script>
        <!-- Styles -->
        <link href="scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="styles/particles.css" rel="stylesheet" type="text/css"/>
        <link href="styles/login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <!--<div class="row">-->
        <div id="particles-js">
            <!--<div class="col-lg-6">-->
                <div id="identificacion" class="fondoLogin">
                    <h1>Identificación</h1>
                    <form action="php/controlador.php">
                        <div class="form-group">
                            <label for="servidor">Servidor: </label>
                            <input type="text" class="form-control" id="servidor" name="servidor" placeholder="192.168.5.40/ldap.forumsys.com"/>
                        </div>
                        <hr>
                        <label for="usuario">Usuario: <span id="leyendaUsuario"></span><span id="leyendaDominio"></span></label>
                        <div class="form-inline">
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Admin user"/>
                            <span> @ </span>
                            <input type="text" class="form-control" id="dominio" name="dominio" placeholder="Domain.com"/>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="clave">Contraseña: </label>
                            <input type="password" class="form-control" id="clave" name="clave" placeholder="password">
                        </div>
                        <hr>
                        <div class="checkbox">
                            <label><input type="checkbox"> Recordar</label>
                        </div>
                        <input type="submit" name="accion" value="Acceder" class="btn btn-success"/>
                        <input type="submit" name="accion" value="Registrarse (implementar)" class="btn btn-danger"/>
                        <button class="btn btn-info">?</button>
                    </form>
                </div>
            
            <!--</div>-->
            <!--<div class="col-lg-6">-->
                <div class="fondoLogin">
                    <h1>Lista de Servidores</h1>
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Servidor</th>
                                <th>Dominio</th>
                                <th>Usuario</th>
                                <th>Contraseña</th>
                            </tr>
                        </thead>
                        <tbody id="servidores"></tbody>
                    </table>
                </div>
            <!--</div>-->
        <!--</div>-->
        
<!--        <script src="scripts/particles/demo/js/app.js" type="text/javascript"></script>
        <script src="scripts/particles/particles.js" type="text/javascript"></script>-->
        </div>
    </body>
</html>
