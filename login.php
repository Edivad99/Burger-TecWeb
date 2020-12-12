<?php

require_once "php/util.php";
use Util\Util;

session_start();
$msgDiErrore;
if(isset($_SESSION["isValid"]) && !$_SESSION["isValid"]) {
    $msgDiErrore = "<p id=\"datiNonCorretti\">Dati non corretti</p>";
} else {
    $msgDiErrore = "";
}

$content = array(
    "<msgErrore/>" => $msgDiErrore
);

echo Util::replacer("html/login.html", $content);
?>