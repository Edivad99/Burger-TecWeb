<?php

require_once "connectionDB.php";
use DB\DBAccess;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: login.php");
}
if(!isset($_GET["ID"]) || !is_numeric($_GET["ID"])) {
    header("Location: ../gestioneCommenti.php");
}

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita){
    header("Location: ../error_500.php");
    die;
}

$idCommento = $_GET["ID"];

if($_SESSION["isAdmin"]) { //L'utente admin può cancellare i commenti di tutti
    $result = $dbAccess->deleteComment($idCommento, -1);

} else { //Prima di cancellare il commento bisogna vedere se il commento appartiene all'utente loggato
    $idUtente = $_SESSION["usernameID"];
    $result = $dbAccess->deleteComment($idCommento, $idUtente);
}
$dbAccess->closeDBConnection();
header("Location: ../gestioneCommenti.php");

?>