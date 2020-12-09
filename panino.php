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
        $dbAccess->closeDBConnection();

        if(isset($panino)) {
            //var_dump($panino);//Funzione utile per scoprire cosa otteniamo dal DB
            $nomePanino = $panino["Nome"];
            $imgPanino = $panino["Img"];
            $ingredienti = explode(";", $panino["Ingredienti"]);
            $categoria = $panino["Categoria"];
            $categoriaText = $panino["CategoriaText"];
            $descrizione = $panino["Descrizione"];

            $content = array(
                "{{ nomePanino }}" => $nomePanino,
                "{{ immaginePanino }}" => $imgPanino,
                "{{ categoria }}" => $categoriaText,
                "{{ categoriaID }}" => $categoria,
                "{{ descrizione }}" => $descrizione,
                "<listaIngredienti/>" => Util::getUlFromArray($ingredienti)
            );

            echo Util::replacer("html/panino.html", $content);

        } else {
            die("Id non corretto");
        }
    }
}

?>