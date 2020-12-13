<?php
require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: index.html");
}

$content = array(
    "{{ username }}" => $_SESSION["username"]
);

echo Util::replacer("html/areariservata.html", $content);
?>