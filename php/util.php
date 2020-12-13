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
        return Util::replacerFromHTML($paginaHTML, $array);
    }

    public static function replacerFromHTML($HTMLPage, $array) {
        foreach($array as $key => $value)
            $HTMLPage = str_replace($key, $value, $HTMLPage);

        return $HTMLPage;
    }
}

?>