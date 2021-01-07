<?php
require_once "../connectionDB.php";
use DB\DBAccess;


if(isset($_GET["category"])) {
    $category = $_GET["category"];
    switch($_GET["category"]) {
        case "Pollo": $category = 1; break;
        case "Manzo": $category = 2; break;
        case "Speciali": $category = 3; break;
        default: $category = -1; break;
    }

    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    if(!$connessioneRiuscita || $category == -1) {
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