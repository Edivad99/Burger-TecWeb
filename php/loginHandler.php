<?php

    require_once "connectiondb.php";
    use DB\DBAccess;

    $username = $_POST["usr"];
    $password = $_POST["pwd"];
    $passwordCifrata = md5($password);
    $isRegistrazione = in_array("Registrati", $_POST);
    
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    if(!$connessioneRiuscita) {
        die("Errore nell'apertura del DB");
    }

    session_start();
    $registrazioneValida = true;
    if($isRegistrazione) {
        //REGISTRA
        $registrazioneValida = $dbAccess->createNewUser($username, $passwordCifrata);
        if(!$registrazioneValida) {
            $_SESSION["isValid"] = false;
            $_SESSION["isValidMsg"] = "registrazione";
            header("Location: ../login.php");
        }
    }

    //ACCEDI
    if($registrazioneValida) {

        $result = $dbAccess->checkUserAndPassword($username, $passwordCifrata);
        $_SESSION["isValid"] = $result["isValid"];

        if($_SESSION["isValid"]) {
            $_SESSION["isAdmin"] = $result["isAdmin"];
            $_SESSION["username"] = $result["username"];
            $_SESSION["isValidMsg"] = "";
            header("Location: ../index.html");
        } else {
            $_SESSION["isValidMsg"] = "login";
            header("Location: ../login.php");
        }
    }

    $dbAccess->closeDBConnection();
?>