<?php

require_once "php/util.php";
require_once "php/connectionDB.php";
use Util\Util;
use DB\DBAccess;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: login.php");
}

if(!$_SESSION["isAdmin"]) {
    header("Location: areariservata.php");
}

$messaggio = isset($_GET["messaggio"]) ? "<p id=\"datiNonCorretti\">" . $_GET["messaggio"] . "</p>": "";

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
    $listaOpzioni .= "<option value= \"$nome\">$nome</option>";
}

$content = array(
    "{{ username }}" => $_SESSION["username"],
    "{{ icona }}" => $_SESSION["icona"],
    "{{ stdLuogo }}" => "Via Luigi Luzzati, 10 Padova, PD",//Di default questo luogo, dato che è dove si trova la panineria
    "{{ dataMinima }}" => date("Y-m-d") . "T00:00",
    "<msgErrore/>" => $messaggio,
    "<opzioni/>" => $listaOpzioni
);

echo Util::replacer("html/gestioneEventi.html", $content);

?>