<?php
session_start();
include_once './utilities.php';
// Primero me conecto
$conexion = conectar();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Manual LDAP</title>
        <script src="../scripts/jquery/jquery-3.3.1.js" type="text/javascript"></script>
<!--        <script type="text/javascript">
            function inicializar() {
                $.getJSON("../json/objectClasses.json", function (datos) {
                    var tbody = document.getElementById("objectClasses");
                    $.each(datos, function (uno, dos) {
//                        alert(uno + "   -   " + dos);
                        var fila = document.createElement("tr");
                        $.each(dos, function (hola, adios) {
                            var celda = document.createElement("td");
                            var ul = document.createElement("ul");
                            $.each(adios, function (blanco, negro) {
                                var li = document.createElement("li");
                                var contenidoli = document.createTextNode(negro);
                                li.appendChild(contenidoli);
                                ul.appendChild(li);
                                celda.appendChild(ul);
                            });
                            fila.appendChild(celda);
                        });
                        tbody.appendChild(fila);
                    });
                });
            }
        </script>-->
    </head>
    <body onload="inicializar()">
        <hr>
        <hr>
        <hr>
        <hr>
        <hr>
        <hr>
        <hr>
        <hr>
        <hr>
        <hr>
        <hr>
        <div>
            
        </div>
        
        
        
        
        
        
        
        
        
        <table>
            <?php
//            $archivo = "../json/objectClasses.json";
//            $datos = file_get_contents($archivo);
//            $entradas = json_decode($datos);
//            foreach ($entradas as $numeroEntrada => $valorEntrada)
//            {
//                foreach ($valorEntrada as $atributo => $valor)
//                {
//                    echo print_r($valor)."<hr>";
//                }
//            }
            ?>
<!--            <thead>
                <tr>
                    <th></th>
                </tr>
            </thead>-->
        <h1>Manual LDAP</h1>
        <div>
            <h2><a name="indice">Índice</a></h2>
            <ol>
                <li><a href="#attributeTypes">Attribute Types</a></li>
                <li><a href="#objectClasses">Object Classes</a></li>
            </ol>
        </div>
        <div>
            <h2><a name="attributeTypes">Attribute Types</a></h2>
            
                
                
                <?php
            // Obtengo todos las subentradas
            //Get the subschema dn from rootDSE
            $search = ldap_read($conexion, "", "objectclass=*", array('*', 'subschemasubentry'));
            $entries = ldap_get_entries($conexion, $search);
            $schemadn = $entries[0]["subschemasubentry"][0];

            // Read all objectclass, attributetype from subschema
            $schsearch = ldap_read($conexion, $schemadn, "objectClass=subSchema", array('objectclasses', 'attributetypes'));
            $schentries = ldap_get_entries($conexion, $schsearch);

//            echo "<hr>";
//            print "Printing all attribute types <br/>";
//            echo "<hr>";
            $count = $schentries[0]["attributetypes"]["count"];
            for ($i = 0; $i < $count; $i++)
            {
                $fullEntry = $schentries[0]["attributetypes"][$i];
                $formatEntry = substr($fullEntry, 2, -2);
//                $posicionNAME = strpos($formatEntry, "NAME");
//                echo "Numero raro: " . substr($formatEntry, 0, $posicionNAME) . "</br>";
//                $posicionDESC = strpos($formatEntry, "DESC");
//                echo "--> " . substr($formatEntry, $posicionNAME, $posicionDESC-$posicionNAME) . "</br>";
//                echo "--> " . ;
                echo $formatEntry;
                echo "<hr>";
//                echo sacarNAME($attributeType) . "</br>";
            }

//            echo "<hr>";
//            print "Printing all objectclasses";
//            echo "<hr>";
            ?>
        </div>
        <div>
            <h2><a name="objectClasses">Object Classes</a></h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>DESC</th>
                        <th>SUP</th>
                        <th>TYPE</th>
                        <th>MUST</th>
                        <th>MAY</th>
                    </tr>
                </thead>
                <tbody id="objectClasses"></tbody>
            </table>
        </div>
        <?php
        // Cerramos la conexion
        ldap_close($conexion);
        ?>
    </body>
</html>
