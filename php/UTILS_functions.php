<?php

function after($substr, $str) {
    if (!is_bool(strpos($str, $substr))) {
        return substr($str, strpos($str, $substr) + strlen($substr));
    }
}

function before($substr, $str) {
    return substr($str, 0, strpos($str, $substr));
}

function between($firstsubstr, $secondsubstr, $str) {
    return before($secondsubstr, after($firstsubstr, $str));
}

function extraerCN($usuario) {
    $array = explode(".", $usuario);
    if (count($array) > 1) {
        $usuarioFinal = "cn=" . $array[0];
        for ($i = 1; $i < count($array); $i++) {
            $usuarioFinal = $usuarioFinal . ",ou=" . $array[$i];
        }
    } else {
        $usuarioFinal = "cn=" . $usuario;
    }
    return $usuarioFinal;
}

function extraerBaseDN($dominioCompleto) {
//        $numeroDominios = substr_count($dominioCompleto, ".");
//        echo "Nombre del usuario: " . $usuario . "<br>";
//        echo "Base DN: " . $dominioCompleto . "<br>";
//        echo "El numero de dominios es: " . $numeroDominios . "<br>";
    $todosLosDominios = explode(".", $dominioCompleto);
    $baseDN = "";
    for ($i = 0; $i < count($todosLosDominios); $i++) {
        $baseDN = $baseDN . ",dc=" . $todosLosDominios[$i];
    }
    return substr($baseDN, 1); // Me elimina el "," del principio
}