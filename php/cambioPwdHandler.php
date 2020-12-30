<?php

    require_once "connectionDB.php";
    use DB\DBAccess;

    if(!isset($_POST["opwd"]) || !isset($_POST["npwd"]) || !isset($_POST["cpwd"])) {
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
    if($nPasswordCifrata === $cPasswordCifrata) {
        if($nPasswordCifrata !== $vPasswordCifrata) {
            $result = $dbAccess->checkUserAndPassword($username, $vPasswordCifrata);

            if($result["isValid"]) {
                $dbAccess->changePassword($username, $vPasswordCifrata, $nPasswordCifrata);
                header("Location: ../cambioPassword.php?cambioAvvenuto=1");
            } else {
                header("Location: ../cambioPassword.php?errDati=1");
            } 
        } else {
            header("Location: ../cambioPassword.php?errNuovaPwd=1");
        }
    } else {
        header("Location: ../cambioPassword.php?errConferma=1");
    }

    $dbAccess->closeDBConnection();
?>