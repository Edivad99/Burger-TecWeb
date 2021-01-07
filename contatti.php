<?php

require_once "php/util.php";
use Util\Util;

session_start();
$icona = "LOGIN";
if(isset($_SESSION["isValid"]) && $_SESSION["isValid"]) {
    $icona = $_SESSION["icona"];
}

$content = array(
    "{{ icona }}" => $icona
);

echo Util::replacer("html/contatti.html", $content);

?>