<?php

    require_once "connectionDB.php";
    use DB\DBAccess;

    if(!isset($_POST["opwd"], $_POST["npwd"], $_POST["cpwd"])) {
        header("Location: ../cambioPassword.php");
        die;
    }

    $vPasswordCifrata = md5($_POST["opwd"]);
    $nPasswordCifrata = md5($_POST["npwd"]);
    $cPasswordCifrata = md5($_POST["cpwd"]);


    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    if(!$connessioneRiuscita) {
        header("Location: ../error_500.php");
        die;
    }

    session_start();
    $username = $_SESSION["username"];
    $messaggio = "";
    if($nPasswordCifrata === $cPasswordCifrata) {
        if($nPasswordCifrata !== $vPasswordCifrata) {
            $result = $dbAccess->checkUserAndPassword($username, $vPasswordCifrata);

            if($result["isValid"]) {
                $dbAccess->changePassword($username, $vPasswordCifrata, $nPasswordCifrata);
                $dbAccess->closeDBConnection();
                $messaggio = "La modifica della password è avvenuta con successo!";
            } else {
                $messaggio = "La vecchia password non è corretta";
            } 
        } else {
            $messaggio = "La nuova password è uguale a quella vecchia";
        }
    } else {
        $messaggio = "La nuova password e quella di conferma non corrispondono";
    }
    header("Location: ../cambioPassword.php?messaggio=$messaggio");
?>