<?php
require_once "../connectiondb.php";
use DB\DBAccess;


if(isset($_GET["nomeEvento"])) {
    $nomeEvento = $_GET["nomeEvento"];
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openDBConnection();
    if(!$connessioneRiuscita) {
        echo "";
    } else {
        $result = $dbAccess->getDateFromEvento($nomeEvento);

        $toSend ="";
        //2020-12-14#2020-12-14
        foreach($result as $data) {
            if(strlen($toSend)>0)
                $toSend .= "#" . $data["Data"];
            else
                $toSend .= $data["Data"];
        }
        echo $toSend;
    }
}
echo "";
?>