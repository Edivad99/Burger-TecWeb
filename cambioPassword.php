<?php

require_once "php/util.php";
use Util\Util;

session_start();
$msg = "";
if(isset($_GET["cambioAvvenuto"]) && $_GET["cambioAvvenuto"] == 1) {
    //Cambio avvenuto con successo
    $msg = "<p id=\"cambioAvvenuto\">La modifica della password è avvenuta con successo!</p>";
} else if(isset($_GET["errConferma"]) && $_GET["errConferma"] == 1) {
    //Errore nella nuova password e sua conferma
    $msg = "<p id=\"datiNonCorretti\">La nuova password e quella di conferma non corrispondono</p>";
} else if(isset($_GET["errNuovaPwd"]) && $_GET["errNuovaPwd"] == 1) {
    //Errore nella nuova password, è uguale alla vecchia
    $msg = "<p id=\"datiNonCorretti\">La nuova password è uguale a quella vecchia</p>";
} else if(isset($_GET["errDati"]) && $_GET["errDati"] == 1) {
    //Errore inserimento dei dati user e password
    $msg = "<p id=\"datiNonCorretti\">La vecchia password non è corretta</p>";
}

$content = array(
    "<msg/>" => $msg,
    "{{ username }}" => $_SESSION["username"]
);

echo Util::replacer("html/cambioPassword.html", $content);
?>