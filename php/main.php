<!DOCTYPE html>
<?php
session_start();
include_once './utils.php';
?>
<html>
    <head>
        <!-- Principal -->
        <meta charset="UTF-8">
        <!--<meta charset="ISO-8859-1">-->
        <title>Gestión de LDAP</title>
        <link rel="icon" type="image/png" href="../images/Logo.png"/>
        <!-- Styles -->
        <link href="../scripts/jquery/jqueryui/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <link href="../scripts/jquery/jqueryui/jquery-ui.structure.css" rel="stylesheet" type="text/css"/>
        <link href="../scripts/jquery/jqueryui/jquery-ui.theme.css" rel="stylesheet" type="text/css"/>
        <link href="../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../scripts/jstree/dist/themes/default/style.css" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"/>
        <link href="../scripts/jquery-confirm-v3/dist/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
        <link href="../styles/spinner-loading.css" rel="stylesheet" type="text/css"/>
        <link href="../styles/utilities.css" rel="stylesheet" type="text/css"/>
        <link href="../styles/principal.css" rel="stylesheet" type="text/css"/>
        <!-- Scripts -->
        <script src="../scripts/jquery/jquery-3.3.1.js" type="text/javascript"></script>
        <script src="../scripts/jquery/jqueryui/jquery-ui.js" type="text/javascript"></script>
        <script src="../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <script src="../scripts/jstree/dist/jstree.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js" type="text/javascript"></script>
        <script src="../scripts/jquery-confirm-v3/dist/jquery-confirm.min.js" type="text/javascript"></script>
        <script src="../scripts/main.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="horizontalHole"></div>
        <div id="main" class="row">
            <div class="col-lg-3">
                <?php require_once 'column.php'; ?>
            </div>
            <div class="col-lg-9">
                <div id="contentSpinnerLoading" class="spinnerLoading"></div>
                <div id="contenido">
                    <?php
                    if (isset($_REQUEST["ruta"])) {
                        $ruta = $_REQUEST["ruta"];
                        ?>
                        <script>
                            peticionAJAXContenido('<?php echo $ruta ?>');
                        </script>
                        <?php
                    } else {
                        ?>
                        <div id="titulo">
                            ¡Bienvenido!
                        </div>
                        <div id="contenido">
                            <p>Hola <span class="destacarspan"><?php echo after("=", $_SESSION["cn"]) ?></span>, bienvenido a DAPBerry, una aplicación web sencilla para la gestión de cualquier servidor OpenLDAP</p>
                            <p>A la izquierda puedes ver tu tarjeta de usuario, donde te da información sobre que usuario eres, en que dominio estás y a que servidor estas conectado, y
                                más abajo, un árbol donde se muestra el árbol LDAP asociado a esta cuenta.</p>
                            <p>Si pinchas en la ayuda, puedes ver la información de la aplicación, una guía de referencia rápida de LDAP (muy útil para cuando no te acuerdas de algo), un manual de usuario en formato PDF (para que sepas dar
                                tus primeros pasos dentro de DAPBerry) y un cuadro de diálogo donde se muestra el LOG a tiempo real (por si la aplicación falla en algún momento, puedas ir al LOG y detectarlo facilmente).</p>
                            <p>Disfrute de DAPBerry mientras está en fase de desarrollo y en caso de querer aportar algun tipo de donación o ayuda, contacte con nosotros (la información la tienes en la ayuda)</p>
                        </div>
                        <div class="clear"></div>
                        <?php
                    }
                    ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <hr class="linea">
        <div class="footer" id="terminal">
            <button id="switchTerminal">Terminal</button>
            <button id="refreshTerminal">Refrescar terminal</button>
        </div>
    </body>
</html>
