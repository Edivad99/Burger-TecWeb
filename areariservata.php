<?php
require_once "php/util.php";
require_once "php/connectionDB.php";
use Util\Util;
use DB\DBAccess;

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