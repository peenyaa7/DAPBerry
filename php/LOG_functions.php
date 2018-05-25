<?php

function escribirLog($cadena, $type) {
    /*
     * Types of errors
     * - Info -----> 'Things happen'
     * - Error ----> 'Functionality is unavailable, invariants are broken or data is lost'
     * - Warn -----> 'Service is degraded or endangered'
     * - Debug ----> 'Internal system events that aren´t neccesarily observable from the outside'
     * - Critical -> 'If you have a pager, it goes off when one of these occurs'
     */

    if (isset($_SESSION["cn"]) && isset($_SESSION["basedn"])) {
        $user = $_SESSION["cn"] . "," . $_SESSION["basedn"];
    } else {
        $user = "Usuario no especificado";
    }

    if (isset($_SESSION["servidor"])) {
        $server = $_SESSION["servidor"];
    } else {
        $server = "Servidor no especificado";
    }
    $path = "../log/log.txt";
    if (file_exists($path)) {
//        echo "el fichero existe";
        if (is_writable($path)) {
//            echo "el fichero es writable";
            $fechaLog = "[" . date("Y-m-d H:i:s") . "]";
            $serverLog = "[" . $server . "]";
            $userLog = "[" . $user . "]";
            $typeLog = "[" . $type . "]";
            $file = fopen($path, "a+"); // El modo 'a+' es para apertura para escritura y lectura, tambien coloca el puntero al final del fichero.
            fwrite($file, $cadena . " < " . $typeLog . $userLog . $serverLog . $fechaLog);
            fwrite($file, "\n");
            fclose($file);
        } else {
            echo "<p>El log no tiene permisos de escritura.</p>";
        }
    } else {
        echo "<p>El fichero LOG no existe</p>";
    }
}

function obtenerLOG() {
    $path = "../log/log.txt";
    $file = fopen($path, "r") or exit("Imposible abrir el fichero!!");

    $file_lines = count(file($path)); //Count the lines of a file
    if ($file_lines > 0) {
        ?>
        <table class="rejilla">
            <?php
            $contador = 0;
            while (!feof($file)) {
                $contador++;
                echo "<tr><td>" . $contador . "</td><td>" . fgets($file) . "</td></tr>";
            }
            ?>
        </table>
        <?php
    } else {
        echo "<p>No hay registros en el log :(</p>";
    }
}

function borrarLOG() {
    $path = "../log/log.txt";
    $file = fopen($path, "w+") or exit("Imposible abrir el fichero!!");
    fwrite($file, "");
    fclose($file);
}