<?php

require_once "php/util.php";
require_once "php/connectionDB.php";
use Util\Util;
use DB\DBAccess;

if(!isset($_GET["ID"])) {
    header("Location: error_404.php");
    die;
}

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.php");
    die;
}

$id = $_GET["ID"];
$panino = $dbAccess->getPaninoById($id);
$commenti = $dbAccess->getCommentiPaninoById($id, 5, 0);
$voti = $dbAccess->getVotiPaninoById($id);
$dbAccess->closeDBConnection();


//Processa i commenti
$listaCommenti = "";
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
    $listaCommenti = "Commenta per primo l'incredibile ".$panino["Nome"];
}

session_start();
$votoForm = file_get_contents("html/components/formVotoPanino.html");
$commentoForm = file_get_contents("html/components/formCommentoPanino.html");
$username = "SCONOSCIUTO";
$icona = "LOGIN";
if(isset($_SESSION["isValid"]) && $_SESSION["isValid"]) {
    $username = $_SESSION["username"];
    $icona = $_SESSION["icona"];
} else { //All'utente viene mostrato il link per loggarsi e votare/commentare
    $votoForm = "<p>Per votare, effettua il <a href=\"login.php\" lang=\"eng\" id=\"loginVotoPanino\">login</a></p>";
    $commentoForm = file_get_contents("html/components/formCommentoPaninoDisabled.html");
}

//Processo i voti
$media = 0;
foreach($voti as $voto) {
    $media += intval($voto["Voto"]);
    if($username != "SCONOSCIUTO" && $voto["Username"] == $username) {
        $votoInt = intval($voto["Voto"]);
        $votoForm = "<p>Il tuo voto è: <abbr title=\"$votoInt su 5\">$votoInt/5</abbr></p>";//Se l'utente ha già votato, non mostro la form per il voto
    }
}
$mediaText = "";
if(count($voti) > 0) {
    $media /= count($voti);
    $media = round($media, 0, PHP_ROUND_HALF_DOWN);
    $mediaText = "<p>Il nostro panino è valutato <abbr title=\"$media su 5\"><span class=\"number\">$media</span>/5</abbr></p>";
}

$errore = isset($_GET["messaggio"]) ? $_GET["messaggio"] : "";

$buttonCaricaCommenti = "";
if(count($commenti) >= 5) {
    $buttonCaricaCommenti = "<button id=\"caricaCommenti\" class=\"button\" onclick=\"showMoreCommentsByPanino({{ paninoID }})\">Carica altri commenti</button>";
}

if(isset($panino)) {
    $nomePanino = $panino["Nome"];
    $imgPanino = $panino["Img"];
    $ingredienti = explode(";", $panino["Ingredienti"]);
    $categoria = $panino["Categoria"];
    $categoriaText = $panino["CategoriaText"];
    $descrizione = $panino["Descrizione"];

    $content = array(
        "<buttonCaricaCommenti/>" => $buttonCaricaCommenti,
        "<formCommentoPanino/>" => $commentoForm,
        "<formVotoPanino/>" => $votoForm,
        "{{ icona }}" => $icona,
        "{{ paninoID }}" => $id,
        "{{ username }}" => $username,
        "{{ nomePanino }}" => $nomePanino,
        "{{ immaginePanino }}" => $imgPanino,
        "{{ categoria }}" => $categoriaText,
        "{{ categoriaID }}" => $categoria,
        "{{ descrizione }}" => $descrizione,
        "{{ erroreCommento }}" => $errore,
        "<mediaPanino/>" => $mediaText,
        "<listaIngredienti/>" => Util::getUlFromArray($ingredienti),
        "<commenti/>" => $listaCommenti
    );

    echo Util::replacer("html/panino.html", $content);

} else {
    header("Location: error_404.php");
    die;
}

?>