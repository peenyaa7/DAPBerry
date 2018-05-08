<?php
include_once '../php/utilities.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <script src="../scripts/jquery/jquery-3.3.1.js" type="text/javascript"></script>
        <script src="../scripts/jstree/dist/jstree.js" type="text/javascript"></script>
        <script src="../scripts/pruebas.js" type="text/javascript"></script>
        <link href="../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../scripts/jstree/dist/themes/default/style.css" rel="stylesheet" type="text/css"/>
        <style>
            * {
                /*border: 1px red solid;*/
            }
        </style>
    </head>
    <body>
        <div id="otro" class="demo">
            <ul id="listaPadre">
                <li>x=nivel0,x=nivel1</li>
            </ul>
<!--            <ul>
                <li>0
                    <ul>
                        <li>1
                            <ul>
                                <li>2
                                    <ul>
                                        <li>3
                                            <ul>
                                                <li>4
                                                    
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>-->
        </div>
        <hr>
        <table id="tabla">
            <tr>
                <th>NAME</th>
                <th>DESC</th>
                <th>SUP</th>
                <th>TYPE</th>
                <th>MUST</th>
                <th>MAY</th>
            </tr>
        </table>
    </body>
</html>
