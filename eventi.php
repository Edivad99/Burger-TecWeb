<?php

require_once "php/util.php";
require_once "php/connectionDB.php";
use Util\Util;
use DB\DBAccess;

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.php");
    die;
}

$eventi = $dbAccess->getEventi();
$dbAccess->closeDBConnection();

$listaEventi = "";
$patternEvento = file_get_contents("html/components/evento.html");
    foreach($eventi as $evento) {
        $content = array(
            "{{ titolo }}" => $evento["Nome"],
            "{{ giorno }}" => $evento["Giorno"],
            "{{ dataEvento }}" => $evento["Data_ev"],
            "{{ luogoEvento }}" => $evento["Luogo_Evento"],
            "{{ contenuto }}" => $evento["Descrizione"]
        );
        $listaEventi .= Util::replacerFromHTML($patternEvento, $content);
    }

session_start();
$username = "LOGIN";
$icona = "LOGIN";
if(isset($_SESSION["isValid"]) && $_SESSION["isValid"]) {
    $username = $_SESSION["username"];
    $icona = $_SESSION["icona"];
}

$content = array(
    "<eventi/>" => $listaEventi,
    "{{ icona }}" => $icona,
    "{{ username }}" => $username
);

echo Util::replacer("html/eventi.html", $content);

?>