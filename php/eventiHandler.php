<?php

require_once "connectiondb.php";
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

if(isset($_POST["aggiungi"]) && $_POST["aggiungi"] == "Aggiungi") {
    $new_title = $_POST["nuovo_titolo"];
    $data = $_POST["data"];
    $place = $_POST["luogo"];
    $description = $_POST["descrizione"];
    $result = $dbAccess->createNewEvent($new_title, $data, $place, $description);
    if(!$result) {
        header("Location: ../gestioneEventi.php?aggiungi=2");
        die;
    }

    header("Location: ../gestioneEventi.php?aggiungi=1");
} else if(isset($_POST["elimina"]) && $_POST["elimina"] == "Elimina") {
    $title = $_POST["titolo"];
    $data = $_POST["data"];
    $result = $dbAccess->deleteEvent($title, $data);
    if(!$result) {
        header("Location: ../gestioneEventi.php?elimina=2");
        die;
    }

    header("Location: ../gestioneEventi.php?elimina=1");
}

$dbAccess->closeDBConnection();

?>