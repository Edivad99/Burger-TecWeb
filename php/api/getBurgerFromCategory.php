<?php
require_once "../connectionDB.php";
use DB\DBAccess;


if(isset($_GET["category"])) {
    $category = $_GET["category"];
    if($category == "Pollo") {
        $category = 1;
    }
    if($category == "Manzo") {
        $category = 2;
    }
    if($category == "Speciali") {
        $category = 3;
    }
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    if(!$connessioneRiuscita) {
        echo "";
    } else {
        $result = $dbAccess->getBurgerFromCategory($category);

        $toSend ="";
        foreach($result as $panino) {
            if(strlen($toSend)>0)
                $toSend .= "#" . $panino["Nome"];
            else
                $toSend .= $panino["Nome"];
        }
        echo $toSend;
    }
}
echo "";
?>