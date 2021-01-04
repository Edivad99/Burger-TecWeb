<?php

require_once "connectionDB.php";
use DB\DBAccess;

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita){
    header("Location: ../error_500.php");
    die;
}

session_start();
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    header("Location: login.php");
}

if(!$_SESSION["isAdmin"]) {
    header("Location: areariservata.php");
}

if(isset($_POST["aggiungi"]) && $_POST["aggiungi"] == "Aggiungi") {
    $new_name = $_POST["nome"];
    $image = $_POST["immagine"];

    if($_POST["categoriaForm"] == "Pollo") {
        $categoria = 1;
    }
    if($_POST["categoriaForm"] == "Manzo") {        //Forse così è un po bruttino ma sennò bisogna cambiare il campo categoria
        $categoria = 2;                             //della tabella Prodotti e trasformare Categoria da INT a VARCHAR
    }                                               //però prima di farlo bisogna vedere cosa modificare in tutto il codice
    if($_POST["categoriaForm"] == "Speciali") {
        $categoria = 3;
    }

    $category = $categoria;
    $ingredients = $_POST["ingred"];
    $description = $_POST["descrizione"];
    $result = $dbAccess->createNewPanino($new_name, $image, $category, $ingredients, $description);
    if(!$result) {
        header("Location: ../gestionePanini.php?aggiungi=2");
        die;
    }

    header("Location: ../gestionePanini.php?aggiungi=1");
} else if(isset($_POST["elimina"]) && $_POST["elimina"] == "Elimina") {
    $name = $_POST["nome"];
    $result = $dbAccess->deletePanino($name);
    if(!$result) {
        header("Location: ../gestionePanini.php?elimina=2");
        die;
    }

    header("Location: ../gestionePanini.php?elimina=1");
}

$dbAccess->closeDBConnection();

?>