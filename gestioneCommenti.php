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
$limit = 5;
$commenti = $dbAccess->getCommenti($_SESSION["username"], $limit, 0);
$dbAccess->closeDBConnection();

$listaCommenti="";
$buttonCaricaCommenti="";
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
    if(count($commenti) >= $limit) {
        $buttonCaricaCommenti = "<button id=\"caricaCommenti\" class=\"button\" onclick=\"showMoreComments('{{ username }}')\">Carica altri commenti</button>";
    }
} else {
    $listaCommenti = "NON CI SONO COMMENTI";
}

$content = array(
    "<buttonCaricaCommenti/>" => $buttonCaricaCommenti,
    "{{ username }}" => $_SESSION["username"],
    "<commenti/>" => $listaCommenti
);

echo Util::replacer("html/gestioneCommenti.html", $content);

?>