<?php

require_once "php/util.php";
use Util\Util;

$paginaHTML = file_get_contents("html/panino.html");

$paginaHTML = str_replace("{{ nomePanino }}", "Crunchicken", $paginaHTML);
$paginaHTML = str_replace("{{ immaginePanino }}", "img/pollo/crunchicken.png", $paginaHTML);
$paginaHTML = str_replace("{{ altImmaginePanino }}", "AGGIUNGI UN ALT", $paginaHTML);

$ingredienti = explode(";", "Pane al mais;Doppia maionese;Pomodoro a fette;Lattuga;Pollo croccante");
$lista = Util::getUlFromArray($ingredienti);
$paginaHTML = str_replace("<listaIngredienti/>", $lista, $paginaHTML);

echo $paginaHTML;
?>