<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;

if(!isset($_GET["ID"])) {
    
} else {
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    if(!$connessioneRiuscita) {
        die("Errore nell'apertura del DB");
    } else {
        $id = $_GET["ID"];
        $panino = $dbAccess->getPaninoById($id);
        $nomePanino = $panino["Nome"];
        $imgPanino = $panino["Img"];
        $altImgPanino = "AGGIUNGI UN ALT";
        $ingredienti = explode(";", $panino["Ingredienti"]);
        $categoria = "Recupera categoria";

        $paginaHTML = file_get_contents("html/panino.html");

        $paginaHTML = str_replace("{{ nomePanino }}", $nomePanino, $paginaHTML);
        $paginaHTML = str_replace("{{ immaginePanino }}", $imgPanino, $paginaHTML);
        $paginaHTML = str_replace("{{ altImmaginePanino }}", $altImgPanino, $paginaHTML);
        $lista = Util::getUlFromArray($ingredienti);
        $paginaHTML = str_replace("<listaIngredienti/>", $lista, $paginaHTML);
        $paginaHTML = str_replace("{{ categoria }}", $categoria, $paginaHTML);

        echo $paginaHTML;
    }
}

?>