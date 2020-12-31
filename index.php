<?php

require_once "php/util.php";
use Util\Util;

session_start();
$username = "LOGIN";
$icona = "LOGIN";
if(isset($_SESSION["isValid"]) && $_SESSION["isValid"]) {
    $username = $_SESSION["username"];
    $icona = $_SESSION["icona"];
}

$content = array(
    "{{ icona }}" => $icona,
    "{{ username }}" => $username
);

echo Util::replacer("html/index.html", $content);

?>