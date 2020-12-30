<?php
require_once "../connectionDB.php";
use DB\DBAccess;

$offset = 0;
$limit = 5;
if(isset($_GET["offset"])) {
    $offset = $_GET["offset"];
}

if(isset($_GET["limit"])) {
    $limit = $_GET["limit"];
}

header("Content-Type: application/json; charset=UTF-8");
$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();

if(!$connessioneRiuscita) {
    echo "{}";
} else if (isset($_GET["user"])) {
    $result = $dbAccess->getCommentiJSON($_GET["user"], $limit, $offset);
    echo $result;
} else if (isset($_GET["paninoID"])) {
    //Ottieni tutti i commenti di quel panino
    $result = $dbAccess->getCommentiPaninoByIdJSON($_GET["paninoID"], $limit, $offset);
    echo $result;
} else {
    echo "{}";
}

$dbAccess->closeDBConnection();

?>