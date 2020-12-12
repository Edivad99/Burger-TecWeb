<?php

require_once "php/util.php";
use Util\Util;

session_start();
$msgDiErrore;
if(isset($_SESSION["isValid"])) {
    if(!$_SESSION["isValid"]) {
        if($_SESSION["isValidMsg"] == "registrazione")
            $msgDiErrore = "<p id=\"datiNonCorretti\">L'username è già in uso</p>";
        else if ($_SESSION["isValidMsg"] == "login")
            $msgDiErrore = "<p id=\"datiNonCorretti\">Dati non corretti</p>";
    } else {
        //TODO: devo sloggare
    }
} else {
    $msgDiErrore = "";
}

$content = array(
    "<msgErrore/>" => $msgDiErrore
);

echo Util::replacer("html/login.html", $content);
?>