<?php

require_once "connectiondb.php";
use DB\DBAccess;

/*$title = $_POST["titolo"];*/

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

if($_POST["azione"] == "add") {
    $new_title = $_POST["nuovo_titolo"];
    $data_place = $_POST["data_luogo"];
    $description = $_POST["descrizione"];
    $result = $dbAccess->createNewEvent($new_title, $data_place, $description);
    if(!$result) {
        header("Location: ../gestioneEventi.php?aggiungi=2");
        die;
    }

    header("Location: ../gestioneEventi.php?aggiungi=1");
}

else {
    $title = $_POST["titolo"];
    $result = $dbAccess->deleteEvent($title);
    if(!$result) {
        header("Location: ../gestioneEventi.php?elimina=2");
        die;
    }

    header("Location: ../gestioneEventi.php?elimina=1");
}

$dbAccess->closeDBConnection();

?>