<?php

require_once "connectionDB.php";
use DB\DBAccess;

session_start();

if(isset($_SESSION) && $_SESSION["isValid"]) {
    if(isset($_GET["submit"], $_GET["paninoRedirect"], $_GET["voto"])) {
        $paninoID = $_GET["paninoRedirect"];
        $voto = $_GET["voto"];

        if(is_numeric($paninoID) && is_numeric($voto)) {
            $paninoID = intval($paninoID);
            $voto = intval($voto);

            if($voto >= 1 && $voto <=5) {
                $dbAccess = new DBAccess();
                $connessioneRiuscita = $dbAccess->openDBConnection();
                $res = $dbAccess->setVotoPaninoById($paninoID, $_SESSION["usernameID"], $voto);
                $dbAccess->closeDBConnection();

                header("Location: ../panino.php?ID=$paninoID");
                die;
            }
        }
    }
}
header("Location: ../login.php");

?>