<?php

require_once "php/util.php";
use Util\Util;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: login.php");
    die;
}

$msg = "";
if(isset($_GET["messaggio"])) {
    $msg = "<p id=\"datiNonCorretti\">" . $_GET["messaggio"] . "</p>";
}

$content = array(
    "<msgCambioPassword/>" => $msg,
    "{{ icona }}" => $_SESSION["icona"]
);

echo Util::replacer("html/cambioPassword.html", $content);
?>