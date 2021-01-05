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
    if(isset($_POST["nome"], $_POST["categoriaForm"], $_POST["ingred"], $_POST["descrizione"], $_FILES["immagine"])) {

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
        $ingredienti = $_POST["ingred"]; //TODO: Da sistemare
        $descrizione = $_POST["descrizione"];


        $check = getimagesize($_FILES["immagine"]["tmp_name"]);
        $imageFileType = strtolower(pathinfo($percorsoBase,PATHINFO_EXTENSION));
        if($check !== false && $imageFileType == "png") {
            //L'immagine è valida
            $result = $dbAccess->createNewPanino($nomePanino, $percorsoBase, $categoria, $ingredienti, $descrizione);
            if($result) {
                $result = move_uploaded_file($_FILES["immagine"]["tmp_name"], "../" . $percorsoBase);
                header("Location: ../gestionePanini.php?aggiungi=1");
                die;
            } else {
                header("Location: ../gestionePanini.php?aggiungi=2");
                die;
            }
        } else {
            echo "File is not a valid image.";
            //TODO: Creare un errore
        }
    }
} else if(isset($_POST["elimina"]) && $_POST["elimina"] == "Elimina") {
    $name = $_POST["name"];
    $result = $dbAccess->deletePanino($name);
    if(!$result) {
        header("Location: ../gestionePanini.php?elimina=2");
        die;
    }

    header("Location: ../gestionePanini.php?elimina=1");
}

$dbAccess->closeDBConnection();

?>