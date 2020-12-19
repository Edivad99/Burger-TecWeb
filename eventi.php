<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.php");
    die;
}

$eventi = $dbAccess->getEventi();
$giorni = $dbAccess->getDayOfWeek();
$dbAccess->closeDBConnection();

$listaEventi = "";
$patternEvento = file_get_contents("html/components/evento.html");
$i = 0;
    foreach($eventi as $evento) {
        $giorno = $giorni[$i];
        $content = array(
            "{{ titolo }}" => $evento["Nome"],
            "{{ giorno }}" => $giorno["Giorno"],
            "{{ dataEvento }}" => $evento["Data_ev"],
            "{{ luogoEvento }}" => $evento["Luogo_Evento"],
            "{{ contenuto }}" => $evento["Descrizione"]
        );
        $i = $i + 1;
        $listaEventi .= Util::replacerFromHTML($patternEvento, $content);
    }

session_start();
$username = "LOGIN";
if(isset($_SESSION["isValid"]) && $_SESSION["isValid"]) {
    $username = $_SESSION["username"];
}

$content = array(
    "<eventi/>" => $listaEventi,
    "{{ username }}" => $username
);

echo Util::replacer("html/eventi.html", $content);

?>