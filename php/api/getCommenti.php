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
} else {
    $result = $dbAccess->getCommentiJSON($limit, $offset);

    echo $result;
}

?>