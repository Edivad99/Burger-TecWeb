<?php

require_once "php/util.php";
use Util\Util;

session_start();
$msgDiErrore = "";
if(isset($_GET["registrazione"]) && $_GET["registrazione"] == 1) {
    //Errore nella registrazione
    $msgDiErrore = "<p id=\"datiNonCorretti\">L'username è già in uso</p>";
} else if(isset($_GET["accesso"]) && $_GET["accesso"] == 1) {
    //Errore nel login
    $msgDiErrore = "<p id=\"datiNonCorretti\">Dati non corretti</p>";
} else if(isset($_SESSION["isValid"]) && $_SESSION["isValid"]) {
    //Redirect nell'area riservata
    header("Location: areariservata.php");
}

$content = array(
    "<msgErrore/>" => $msgDiErrore
);

echo Util::replacer("html/login.html", $content);
?>