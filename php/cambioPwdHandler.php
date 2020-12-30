<?php

    require_once "connectionDB.php";
    use DB\DBAccess;

    
    $vPassword = $_POST["opwd"];
    $vPasswordCifrata = md5($vPassword);
    $nPassword = $_POST["npwd"];
    $nPasswordCifrata = md5($nPassword);
    $cPassword = $_POST["cpwd"];
    $cPasswordCifrata = md5($cPassword);
    
    
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    if(!$connessioneRiuscita) {
        header("Location: ../error_500.php");
        die;
    }

    session_start();
    $username = $_SESSION["username"];
    if($nPassword === $cPassword) {
        if($nPassword !== $vPassword) {
            $result = $dbAccess->checkUserAndPassword($username, $vPasswordCifrata);
            $_SESSION["isValid"] = $result["isValid"];

            if($_SESSION["isValid"]) {
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