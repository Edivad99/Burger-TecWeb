<?php

require_once "connectionDB.php";
use DB\DBAccess;

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita){
    header("Location: ../error_500.php");
    die;
}

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: login.php");
}

if(!$_SESSION["isAdmin"]) {
    header("Location: areariservata.php");
}

$messaggio = "";
if(isset($_POST["aggiungi"], $_POST["titolo"], $_POST["data-ora"], $_POST["luogo"], $_POST["descrizione"]) && $_POST["aggiungi"] == "Aggiungi") {
    $new_title = $_POST["titolo"];
    $data = $_POST["data-ora"];
    $place = $_POST["luogo"];
    $description = $_POST["descrizione"];
    $result = $dbAccess->createNewEvent($new_title, $data, $place, $description);

    if($result) {
        $messaggio = "L'evento è stato inserito correttamente";
    } else {
        $messaggio = "L'evento esiste già";
    }
} else if(isset($_POST["elimina"], $_POST["titolo"], $_POST["data"]) && $_POST["elimina"] == "Elimina") {
    $title = $_POST["titolo"];
    $data = date("Y-m-d", strtotime($_POST["data"]));
    $result = $dbAccess->deleteEvent($title, $data);

    if($result) {
        $messaggio = "L'evento è stato eliminato con successo";
    } else {
        $messaggio = "L'evento non esiste e non è stato eliminato";
    }
} else {
    $dbAccess->closeDBConnection();
    header("Location: ../gestioneEventi.php");
}

$dbAccess->closeDBConnection();
header("Location: ../gestioneEventi.php?messaggio=$messaggio");
?>