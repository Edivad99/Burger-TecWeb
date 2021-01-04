<?php

require_once "php/util.php";
require_once "php/connectionDB.php";
use Util\Util;
use DB\DBAccess;

session_start();
$msgDiErrore = "";
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: login.php");
}

if(!$_SESSION["isAdmin"]) {
    header("Location: areariservata.php");
}

if(isset($_GET["aggiungi"]) && $_GET["aggiungi"] == 1) {
    $msgDiErrore = "<p id=\"datiNonCorretti\">Il panino è stato inserito correttamente</p>";
}

if(isset($_GET["aggiungi"]) && $_GET["aggiungi"] == 2) {
    $msgDiErrore = "<p id=\"datiNonCorretti\">Il panino esiste già</p>";
}

if(isset($_GET["elimina"]) && $_GET["elimina"] == 1) {
    $msgDiErrore = "<p id=\"datiNonCorretti\">Il panino è stato eliminato con successo</p>";
}

if(isset($_GET["elimina"]) && $_GET["elimina"] == 2) {
    $msgDiErrore = "<p id=\"datiNonCorretti\">Il panino non esiste</p>";
}

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.php");
    die;
}

$opzioni = $dbAccess->getPaniniDaCancellare();
$dbAccess->closeDBConnection();

$listaOpzioni="<option value=\"\" disabled selected>Scegli panino</option>";
foreach($opzioni as $opzione) {
    $nome = $opzione["Nome"];
    $listaOpzioni .= "<option>$nome</option>";
}

$content = array(
    "{{ username }}" => $_SESSION["username"],
    "<msgErrore/>" => $msgDiErrore,
    "<opzioni/>" => $listaOpzioni

);

echo Util::replacer("html/gestionePanini.html", $content);

?>