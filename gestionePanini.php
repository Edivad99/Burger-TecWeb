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

$listaOpzioni="<option value=\"\" disabled selected>Scegli panino</option>";
for($i=1; $i<=3; $i++) {
    $categoriaText = $categorie["result"][$i-1]["Categoria"];
    $listaOpzioni .= "<option>$categoriaText</option>";
}

$listaCategorie="<option value=\"\" disabled selected>Scegli categoria</option>";
for($i=1; $i<=3; $i++) {
    $categoriaText = $categorie["result"][$i-1]["Categoria"];
    $listaCategorie .= "<option>$categoriaText</option>";
}

$content = array(
    "{{ username }}" => $_SESSION["username"],
    "<msgErrore/>" => $messaggio,
    "<categorie/>" => $listaCategorie,
    "<opzioni/>" => $listaOpzioni

);

echo Util::replacer("html/gestionePanini.html", $content);

?>