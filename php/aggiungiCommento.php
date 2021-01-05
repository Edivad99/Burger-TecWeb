<?php

require_once "util.php";
require_once "connectionDB.php";
use Util\Util;
use DB\DBAccess;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: ../index.php");
    die;
}

if(!isset($_POST["username"]) || !isset($_POST["testo"]) || !isset($_POST["paninoID"]) || !is_numeric($_POST["paninoID"])) {
    header("Location: ../menu.php");
    die;
}

$username = $_POST["username"];
$testo = Util::pulisciInput($_POST["testo"]);
$paninoID = $_POST["paninoID"];

if($_SESSION["username"] != $username || strlen($testo) < 2) {
    $messaggio = "Controlla la lunghezza del testo!";
    header("Location: ../panino.php?ID=$paninoID&messaggio=$messaggio#commenti");
    die;
}
$data = date("Y-m-d H:i:s");
$IDUtente = $_SESSION["usernameID"];


$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: ../error_500.php");
    die;
}

$dbAccess->addCommentToPanino($paninoID, $IDUtente, $data, $testo);
$dbAccess->closeDBConnection();
header("Location: ../panino.php?ID=$paninoID#commenti");

?>