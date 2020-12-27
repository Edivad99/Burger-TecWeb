<?php

require_once "php/util.php";
require_once "php/connectionDB.php";
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

$commenti = $dbAccess->getCommenti($_SESSION["username"], 5, 0);
$dbAccess->closeDBConnection();

$listaCommenti="";
if(count($commenti) > 0) {
    $patternCommento = file_get_contents("html/components/gestioneCommento.html");
    foreach($commenti as $commento) {
        $content = array(
            "{{ username }}" => $commento["Username"],
            "{{ dataOraPost }}" => $commento["DataOraPost"],
            "{{ contenuto }}" => $commento["Contenuto"],
            "{{ panino }}" => $commento["Panino"],
            "{{ paninoID }}" => $commento["PaninoID"],
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