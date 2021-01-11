<?php

require_once "php/util.php";
require_once "php/connectionDB.php";
use Util\Util;
use DB\DBAccess;

session_start();
$messaggio = "";
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: login.php");
}

if(!$_SESSION["isAdmin"]) {
    header("Location: areariservata.php");
}

$messaggio = isset($_GET["messaggi"]) ? "<p id=\"datiNonCorretti\">" . $_GET["messaggi"] . "</p>" : "";

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.php");
    die;
}

$categorie = $dbAccess->getCategorie();
$dbAccess->closeDBConnection();

$listaCategorie="<option value=\"\" disabled selected>Scegli categoria</option>";
for($i=0; $i<3; $i++) {
    $categoriaText = $categorie["result"][$i]["Categoria"];
    $listaCategorie .= "<option value=\"$categoriaText\">$categoriaText</option>";
}

$content = array(
    "{{ icona }}" => $_SESSION["icona"],
    "<msgErrore/>" => $messaggio,
    "<categorie/>" => $listaCategorie

);

echo Util::replacer("html/gestionePanini.html", $content);

?>