<?php

require_once "php/util.php";
require_once "php/connectionDB.php";
use Util\Util;
use DB\DBAccess;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: login.php");
    die;
}

if(!isset($_GET["ID"]) || !is_numeric($_GET["ID"])) {
    header("Location: gestioneCommenti.php");
    die;
}

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.php");
    die;
}

//Controlliamo se il commento appartiene all'utente loggato, l'admin può modificarlo
$commento = $dbAccess->getCommentoById($_GET["ID"]);
$dbAccess->closeDBConnection();
if($commento == null || ($commento["Username"] != $_SESSION["username"] && !$_SESSION["isAdmin"])) {
    header("Location: gestioneCommenti.php");
}

$commentoForm = file_get_contents("html/components/formModificaCommento.html");

$content = array(
    "<formModificaCommento/>" => $commentoForm,
    "{{ testo }}" => $commento["Contenuto"],
    "{{ lenTesto }}" => 400 - strlen($commento["Contenuto"]),
    "{{ commentoID }}" => $commento["ID"],
    "{{ erroreCommento }}" => isset($_GET["messaggio"]) ? $_GET["messaggio"] : "",
    "{{ icona }}" => $_SESSION["icona"],
    "{{ username }}" => $_SESSION["username"]
);

echo Util::replacer("html/modificaCommento.html", $content);

?>