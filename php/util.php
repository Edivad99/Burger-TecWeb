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
}

?>