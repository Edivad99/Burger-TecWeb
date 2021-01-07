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

$messaggi="";
if(isset($_POST["aggiungi"]) && $_POST["aggiungi"] == "Aggiungi" && isset($_POST["nome"], $_POST["categoriaForm"], $_POST["ingred"], $_POST["descrizione"], $_FILES["immagine"])) {

    $nomePanino = $_POST["nome"];
    $categoria = 1;
    $percorsoBase = "img/";
    switch ($_POST["categoriaForm"]) {
        case "Pollo": $categoria = 1; $percorsoBase.= "pollo/"; break;
        case "Manzo": $categoria = 2; $percorsoBase.= "manzo/"; break;
        case "Speciali": $categoria = 3; $percorsoBase.= "speciali/"; break;
        default: $categoria = 1; $percorsoBase.= "pollo/"; break;
    }
    $percorsoBase .= basename($_FILES["immagine"]["name"]);
    $ingredienti = $_POST["ingred"];

    $ultimoCarattere = substr($ingredienti, strlen($ingredienti) - 1);
    while($ultimoCarattere == ";") {
        $ingredienti = substr($ingredienti, 0, strlen($ingredienti) - 1);
        $ultimoCarattere = substr($ingredienti, strlen($ingredienti) - 1);
    }

    $descrizione = $_POST["descrizione"];


    $check = getimagesize($_FILES["immagine"]["tmp_name"]);
    $imageFileType = strtolower(pathinfo($percorsoBase,PATHINFO_EXTENSION));
    if($check !== false && $imageFileType == "png") {
        //L'immagine è valida
        $result = $dbAccess->createNewPanino($nomePanino, $percorsoBase, $categoria, $ingredienti, $descrizione);
        if($result) {
            $result = move_uploaded_file($_FILES["immagine"]["tmp_name"], "../" . $percorsoBase);
            if($result) {
                $messaggi = "Il panino è stato inserito correttamente";
            } else {
                $messaggi = "La foto del panino non è stata salvata";
            }
        } else {
            $messaggi = "Il panino esiste già";
        }
    } else {
        $messaggi = "Il file caricato non è un'immagine valida";
    }
} else if(isset($_POST["elimina"], $_POST["name"]) && $_POST["elimina"] == "Elimina") {
    $name = $_POST["name"];
    $result = $dbAccess->deletePanino($name);
    if(!$result) {
        $messaggi = "Il panino non esiste";
    } else {
        if(is_string($result)) {
            $result = unlink("../" . $result);
        }
        $messaggi = "Il panino è stato eliminato con successo";
    }
}
$dbAccess->closeDBConnection();
if(strlen($messaggi) > 0) {
    header("Location: ../gestionePanini.php?messaggi=$messaggi");
} else {
    header("Location: ../gestionePanini.php");
}

?>