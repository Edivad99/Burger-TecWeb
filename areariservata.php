<?php
require_once "php/util.php";
use Util\Util;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: index.php");
}

$evento = "";
if($_SESSION["isAdmin"]){
    $evento = "<a class=\"button\" href=\"gestioneEventi.php\">Gestisci gli Eventi</a>";
}

$content = array(
    "{{ icona }}" => $_SESSION["icona"],
    "{{ username }}" => $_SESSION["username"],
    "<gestisciEventi/>" => $evento
);

echo Util::replacer("html/areariservata.html", $content);
?>