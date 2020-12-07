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
            var_dump($panino);
            $nomePanino = $panino["Nome"];
            $imgPanino = $panino["Img"];
            $altImgPanino = "AGGIUNGI UN ALT";
            $ingredienti = explode(";", $panino["Ingredienti"]);
            $categoria = $panino["Categoria"];
            $categoriaText = $panino["CategoriaText"];
            $descrizione = 
            "Pollo croccante, pomodoro, lattuga e doppia maionese, racchiusi in un morbido pane al mais.
            Vieni a provare il nostro nuovo Crunchicken.
            Un pollo così non l'hai mai sentito!";

            $paginaHTML = file_get_contents("html/panino.html");

            $paginaHTML = str_replace("{{ nomePanino }}", $nomePanino, $paginaHTML);
            $paginaHTML = str_replace("{{ immaginePanino }}", $imgPanino, $paginaHTML);
            $paginaHTML = str_replace("{{ altImmaginePanino }}", $altImgPanino, $paginaHTML);
            $lista = Util::getUlFromArray($ingredienti);
            $paginaHTML = str_replace("<listaIngredienti/>", $lista, $paginaHTML);
            $paginaHTML = str_replace("{{ categoria }}", $categoriaText, $paginaHTML);
            $paginaHTML = str_replace("{{ categoriaID }}", $categoria, $paginaHTML);
            $paginaHTML = str_replace("{{ descrizione }}", $descrizione, $paginaHTML);

            echo $paginaHTML;
        } else {
            die("Id non corretto");
        }
    }
}

?>