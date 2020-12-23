<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: login.php");
}

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.php");
    die;
}

$commenti = $dbAccess->getCommenti();
$dbAccess->closeDBConnection();

$listaCommenti="";
if(count($commenti) > 0) {
    $patternCommento = file_get_contents("html/components/commento.html");
    foreach($commenti as $commento) {
        $content = array(
            "{{ username }}" => $commento["Username"],
            "{{ dataOraPost }}" => $commento["DataOraPost"],
            "{{ contenuto }}" => $commento["Contenuto"]
        );

        $listaCommenti .= Util::replacerFromHTML($patternCommento, $content);
    }
} else {
    $listaCommenti = "NON CI SONO COMMENTI";
}

$content = array(
    "{{ username }}" => $_SESSION["username"],
    "<commenti/>" => $listaCommenti
);

echo Util::replacer("html/gestioneCommenti.html", $content);

?>