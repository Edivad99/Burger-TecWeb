<?php

    require_once "connectiondb.php";
    use DB\DBAccess;

    $username = $_POST["usr"];
    $password = $_POST["pwd"];
    $passwordCifrata = md5($password);

    $isRegistrazione = in_array("Registrati", $_POST);
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    if($isRegistrazione) {
        //REGISTRA
        
    }
    
    //ACCEDI
    if(!$connessioneRiuscita) {
        die("Errore nell'apertura del DB");
    }

    $result = $dbAccess->checkUserAndPassword($username, $passwordCifrata);
    session_start();
    $_SESSION["isValid"] = $result["isValid"];

    if($result["isValid"]) {
        $_SESSION["isAdmin"] = $result["isAdmin"];
        $_SESSION["username"] = $result["username"];
        header("Location: ../index.html");
    } else {
        header("Location: ../login.php");
    }

    $dbAccess->closeDBConnection();
?>