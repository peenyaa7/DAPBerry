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
        <!-- Scripts -->
        <script src="../scripts/jquery/jquery-3.3.1.js" type="text/javascript"></script>
        <script src="../scripts/jquery/jqueryui/jquery-ui.js" type="text/javascript"></script>
        <script src="../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <script src="../scripts/jstree/dist/jstree.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js" type="text/javascript"></script>
        <script src="../scripts/jquery-confirm-v3/dist/jquery-confirm.min.js" type="text/javascript"></script>
        <script src="../scripts/main.js" type="text/javascript"></script>
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
                                <p>Hola <span class="destacarspan"><?php echo after("=",$_SESSION["cn"]) ?></span>, estás en la aplicacion web de Gestion de LDAP</p>
                                <p>A la izquierda puedes ver tu tarjeta de usuario donde puedes ver quien eres (por si lo olvidas), y
                                    un arbol donde se muestra el arbol LDAP asociado a esta cuenta.</p>
                                <p>Arriba puedes disfrutar de las diferentes funcionalidades que la pagina ofrece.</p>
                                <p>Disfruta y en caso de donacion o querer mas informacion, pinche en 'Info'.</p>
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
	<div class="footer" id="terminal" style="
	    	position: fixed;
	    	width: 100%;
	    	bottom: 0;
	   	background: white;
	    	text-align: center;
	">
		<button id="switchTerminal">Terminal</button>
		<button id="refreshTerminal">Refrescar terminal</button>
	</div>
    </body>
</html>