<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;


$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    die("Errore nell'apertura del DB");
} else {
    $id = isset($_GET["ID"]) ? $_GET["ID"] : 1;
    $panini = $dbAccess->getPaniniByCategoria($id);
    $dbAccess->closeDBConnection();

    $listaPanini = "";
    if(count($panini) > 0) {
        //var_dump($panini);//Funzione utile per scoprire cosa otteniamo dal DB
        $patternPanino = file_get_contents("html/components/paninoShowcase.html");
            foreach($panini as $panino) {
                $content = array(
                    "{{ immaginePanino }}" => $panino["Img"],
                    "{{ idPanino }}" => $panino["ID"],
                    "{{ nomePanino }}" => $panino["Nome"]
                );

                $listaPanini .= Util::replacerFromHTML($patternPanino, $content);
            }
    } else {
        $listaPanini = "NON CI SONO PANINI";
    }

    $content = array(
        "<paniniMenu/>" => $listaPanini
    );

    echo Util::replacer("html/menu.html", $content);
}

?>