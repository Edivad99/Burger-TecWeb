<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
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
$commenti = $dbAccess->getCommentiPaninoById($id);
$voti = $dbAccess->getVotiPaninoById($id);
$dbAccess->closeDBConnection();


//Processa i commenti
$listaCommenti = "";
if(count($commenti) > 0) {
    $patternCommento = file_get_contents("html/components/commento.html");
    foreach($commenti as $commento) {
        $content = array(
            "{{ username }}" => $commento["Username"],
            "{{ dataOraPost }}" => date_format($commento["DataOraPost"], 'H:i:s d/m/Y'),
            "{{ contenuto }}" => $commento["Contenuto"]
        );

        $listaCommenti .= Util::replacerFromHTML($patternCommento, $content);
    }
} else {
    $listaCommenti = "NON CI SONO COMMENTI";
}

session_start();
$votoForm = file_get_contents("html/components/formVotoPanino.html");
$username = "LOGIN";
if(isset($_SESSION["isValid"]) && $_SESSION["isValid"]) {
    $username = $_SESSION["username"];
} else {
    $votoForm = ""; //L'utente non può votare se non loggato
}

//Processo i voti
$media = 0;
foreach($voti as $voto) {
    $media += intval($voto["Voto"]);
    if($username != "LOGIN" && $voto["Username"] == $username) {
        $votoForm = "Il tuo voto è: " . intval($voto["Voto"]) . "/5";//Se l'utente ha già votato, non mostro la form per il voto
    }
}
$mediaText = "";
if(count($voti) > 0) {
    $media /= count($voti);
    $media = round($media, 0, PHP_ROUND_HALF_DOWN);
    $mediaText = "<p>Il nostro panino è valutato $media/5</p>";
}


if(isset($panino)) {
    //var_dump($panino);//Funzione utile per scoprire cosa otteniamo dal DB
    $nomePanino = $panino["Nome"];
    $imgPanino = $panino["Img"];
    $ingredienti = explode(";", $panino["Ingredienti"]);
    $categoria = $panino["Categoria"];
    $categoriaText = $panino["CategoriaText"];
    $descrizione = $panino["Descrizione"];

    $content = array(
        "{{ username }}" => $username,
        "{{ nomePanino }}" => $nomePanino,
        "{{ immaginePanino }}" => $imgPanino,
        "{{ categoria }}" => $categoriaText,
        "{{ categoriaID }}" => $categoria,
        "{{ descrizione }}" => $descrizione,
        "<mediaPanino/>" => $mediaText,
        "<formVotoPanino/>" => str_replace("{{ paninoID }}", $id, $votoForm),
        "<listaIngredienti/>" => Util::getUlFromArray($ingredienti),
        "<commenti/>" => $listaCommenti
    );

    echo Util::replacer("html/panino.html", $content);

} else {
    header("Location: error_404.php");
    die;
}

?>