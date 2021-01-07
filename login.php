<?php

require_once "php/util.php";
use Util\Util;

session_start();
if(isset($_SESSION["isValid"]) && $_SESSION["isValid"]) {
    //Redirect nell'area riservata
    header("Location: areariservata.php");
    die;
}

$messaggio = isset($_GET["messaggio"]) ? "<p id=\"datiNonCorretti\">" . $_GET["messaggio"] . "</p>" : "";

$content = array(
    "<msgErrore/>" => $messaggio
);

echo Util::replacer("html/login.html", $content);
?>