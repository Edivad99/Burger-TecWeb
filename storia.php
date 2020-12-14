<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;

session_start();
$username = "";
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    $username = "LOGIN";
}

else {
    $username = $_SESSION["username"];
}

$content = array(
    "{{ username }}" => $username
);

echo Util::replacer("html/storia.html", $content);

?>