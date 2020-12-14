<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;


$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
if(!$connessioneRiuscita) {
    header("Location: error_500.html");
    die;
}

$categoria = isset($_GET["categoria"]) ? $_GET["categoria"] : 1;
$panini = $dbAccess->getPaniniByCategoria($categoria);
$categorie = $dbAccess->getCategorie();
$dbAccess->closeDBConnection();

//Controlliamo se $categoria esiste
if($categoria <= 0 || $categoria > $categorie["IDMax"] || count($panini) <= 0) {
    header("Location: error_404.html");
    die;
}

$listaPanini = "";
$patternPanino = file_get_contents("html/components/paninoShowcase.html");
    foreach($panini as $panino) {
        $content = array(
            "{{ immaginePanino }}" => $panino["Img"],
            "{{ idPanino }}" => $panino["ID"],
            "{{ nomePanino }}" => $panino["Nome"]
        );

        $listaPanini .= Util::replacerFromHTML($patternPanino, $content);
    }

//Creo la categoria da PHP per evitare link circolari
$categorieMenu = "";
for($i=1; $i<=3; $i++) {
    $categoriaText = $categorie["result"][$i-1]["Categoria"];

    if($categoria == $i) {//Non devo fare un link circolare
        $categorieMenu .= "<li id=\"categoriaAttiva\">". $categoriaText . "</li>";
    } else {
        $categorieMenu .= "<li><a href=\"menu.php?categoria=$i\">" . $categoriaText . "</a></li>";
    }
}

session_start();
$username = "";
if(!isset($_SESSION["isValid"]) || !$_SESSION["isValid"]) {
    $username = "LOGIN";
}

else {
    $username = $_SESSION["username"];
}

$content = array(
    "<paniniMenu/>" => $listaPanini,
    "<listaCategoria/>" => $categorieMenu,
    "{{ username }}" => $username
);

echo Util::replacer("html/menu.html", $content);

?>