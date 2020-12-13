<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;

if(!isset($_GET["ID"])) {
    header("Location: error_404.html");
    die;
} 

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.html");
    die;
}

$id = $_GET["ID"];
$panino = $dbAccess->getPaninoById($id);
$commenti = $dbAccess->getCommentiPaninoById($id);
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
$username = "";
if(isset($_SESSION["isValid"])) {
    if($_SESSION["isValid"]) {
        $log = "<li><a href=\"areariservata.php\">{{ username }}</a></li>";
        $username = $_SESSION["username"];
    }
    else {
        $log = "<li><a href=\"login.php\" lang=\"en\">LOGIN</a></li>";
    }
}

else {
    $log = "<li><a href=\"login.php\" lang=\"en\">LOGIN</a></li>";
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
        "<login/>" => $log,
        "{{ username }}" => $username,
        "{{ nomePanino }}" => $nomePanino,
        "{{ immaginePanino }}" => $imgPanino,
        "{{ categoria }}" => $categoriaText,
        "{{ categoriaID }}" => $categoria,
        "{{ descrizione }}" => $descrizione,
        "<listaIngredienti/>" => Util::getUlFromArray($ingredienti),
        "<commenti/>" => $listaCommenti
    );

    echo Util::replacer("html/panino.html", $content);

} else {
    header("Location: error_404.html");
    die;
}

?>