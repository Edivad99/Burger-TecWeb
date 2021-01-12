<?php

require_once "util.php";
require_once "connectionDB.php";
use Util\Util;
use DB\DBAccess;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: ../login.php");
    die;
}

if(!isset($_POST["commentoID"]) || !is_numeric($_POST["commentoID"])) {
    header("Location: ../gestioneCommenti.php");
    die;
}

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: ../error_500.php");
    die;
}

//Controlliamo se il commento appartiene all'utente loggato, l'admin può modificarlo
$commento = $dbAccess->getCommentoById($_POST["commentoID"]);
if($commento == null || ($commento["Username"] != $_SESSION["username"] && !$_SESSION["isAdmin"])) {
    header("Location: ../gestioneCommenti.php");
}

$commentoID = $_POST["commentoID"];
$testo = Util::pulisciInput($_POST["testo"]);

if(strlen($testo) < 2) {
    $messaggio = "Controlla la lunghezza del testo!";
    header("Location: ../modificaCommento.php?ID=$commentoID&messaggio=$messaggio");
    die;
}
$result = $dbAccess->updateCommentoById($commentoID, $testo);
$dbAccess->closeDBConnection();

if($result) {
    header("Location: ../gestioneCommenti.php");
} else {
    $messaggio = "Modifica del commento non riuscita, riprova";
    header("Location: ../modificaCommento.php?ID=$commentoID&messaggio=$messaggio");
}
?>