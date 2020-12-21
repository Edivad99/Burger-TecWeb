<?php

require_once "php/util.php";
use Util\Util;

session_start();
$username = "LOGIN";
if(isset($_SESSION["isValid"]) && $_SESSION["isValid"]) {
    $username = $_SESSION["username"];
}

$content = array(
    "{{ username }}" => $username
);

echo Util::replacer("html/storia.html", $content);

?>