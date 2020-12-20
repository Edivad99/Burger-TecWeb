<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: index.php");
}

if(!isset($_POST["username"]) || !isset($_POST["testo"]) || !isset($_POST["paninoID"]) || !is_numeric($_POST["paninoID"])) {
    header("Location: menu.php");
}

$username = $_POST["username"];
$testo = Util::pulisciInput($_POST["testo"]);
$paninoID = $_POST["paninoID"];

if($_SESSION["username"] != $username || strlen($testo) < 2) {
    header("Location: panino.php?ID=$paninoID");
}





var_dump($_POST);
?>