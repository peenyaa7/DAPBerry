<?php
// Inicio la sesion
session_start();

// Incluimos una vez el archivo de utilidades de PHP
include_once './utilities.php';

// Recogemos la ruta de la URL
$ruta = $_REQUEST["ruta"];
?>
<!--                        <html>
                            <head>
                                <meta charset="UTF-8">
                                <title>Informacion entrada</title>
                                <link href="../styles/utilities.css" rel="stylesheet" type="text/css"/>
                            </head>
                            <body>
                                <table class="rejilla">
                                    <thead>
                                        <tr>
                                            <th colspan="2"><?php // echo $ruta ?></th>
                                        </tr>
                                    </thead>-->
            <?php
            // Primero me conecto
            $conexion = conectar();
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
//             Por cada atributo obtengo el valor y lo escribo
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

            // Cerramos la conexion
            ldap_close($conexion);
            ?>
<!--                                    </table>
                                </body>
                            </html>-->
