<?php

namespace Util;

class Util {

    public static function getUlFromArray($array) {
        $lista = "<ul>";
        foreach($array as $element)
            $lista .= "<li>" . trim($element) . "</li>";
        $lista .="</ul>";
        return $lista;
    }

    public static function replacer($urlHTML, $array) {
        $paginaHTML = file_get_contents($urlHTML);

        foreach($array as $key => $value)
            $paginaHTML = str_replace($key, $value, $paginaHTML);

        return $paginaHTML;
    }
}

?>