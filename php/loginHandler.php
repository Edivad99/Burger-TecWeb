<?php

    require_once "connectionDB.php";
    use DB\DBAccess;

    $username = $_POST["usr"];
    $password = $_POST["pwd"];
    $passwordCifrata = md5($password);
    $isRegistrazione = in_array("Registrati", $_POST);
    
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    if(!$connessioneRiuscita) {
        header("Location: ../error_500.php");
        die;
    }

    session_start();
    $registrazioneValida = true;
    if($isRegistrazione) {
        //REGISTRA
        $registrazioneValida = $dbAccess->createNewUser($username, $passwordCifrata);
        if(!$registrazioneValida) {
            header("Location: ../login.php?registrazione=1");
            die;
        }
    }

    //ACCEDI
    if($registrazioneValida) {

        $result = $dbAccess->checkUserAndPassword($username, $passwordCifrata);
        $_SESSION["isValid"] = $result["isValid"];

        if($_SESSION["isValid"]) {
            $_SESSION["isAdmin"] = $result["isAdmin"];
            $_SESSION["username"] = $result["username"];
            $_SESSION["usernameID"] = $result["usernameID"];
            header("Location: ../areariservata.php");
        } else {
            header("Location: ../login.php?accesso=1");
        }
    }

    $dbAccess->closeDBConnection();
?>