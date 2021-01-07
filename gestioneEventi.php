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
    $msgDiErrore = "<p id=\"datiNonCorretti\">L'evento è stato inserito correttamente</p>";
}

if(isset($_GET["aggiungi"]) && $_GET["aggiungi"] == 2) {
    $msgDiErrore = "<p id=\"datiNonCorretti\">L'evento esiste già</p>";
}

if(isset($_GET["elimina"]) && $_GET["elimina"] == 1) {
    $msgDiErrore = "<p id=\"datiNonCorretti\">L'evento è stato eliminato con successo</p>";
}

if(isset($_GET["elimina"]) && $_GET["elimina"] == 2) {
    $msgDiErrore = "<p id=\"datiNonCorretti\">L'evento non esiste</p>";
}

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.php");
    die;
}

$opzioni = $dbAccess->getEventiDaCancellare();
$dbAccess->closeDBConnection();

$listaOpzioni="<option value=\"\" disabled selected>Scegli evento</option>";
foreach($opzioni as $opzione) {
    $nome = $opzione["Nome"];
    $listaOpzioni .= "<option>$nome</option>";
}

$content = array(
    "{{ username }}" => $_SESSION["username"],
    "{{ icona }}" =>$_SESSION["icona"],
    "{{ iconaClassCSS }}" => "class=\"withImage\"",
    "{{ stdLuogo }}" => "Via Luigi Luzzati, 10 Padova, PD",//Di default questo luogo, dato che è dove si trova la panineria
    "{{ dataMinima }}" => date("Y-m-d") . "T00:00",
    "<msgErrore/>" => $msgDiErrore,
    "<opzioni/>" => $listaOpzioni
);

echo Util::replacer("html/gestioneEventi.html", $content);

?>