<?php

namespace Util;

class Util {

    public static function getUlFromArray($array) {
        $lista = "<ul>";
        foreach($array as $element)
            $lista .= "<li>" . $element . "</li>";
        $lista .="</ul>";
        return $lista;
    }
}

?>