<?php
$paginaHTML = file_get_contents("html/panino.html");

$paginaHTML = str_replace("{{ nomePanino }}", "Crunchicken", $paginaHTML);
$paginaHTML = str_replace("{{ immaginePanino }}", "img/pollo/crunchicken.png", $paginaHTML);
$paginaHTML = str_replace("{{ altImmaginePanino }}", "AGGIUNGI UN ALT", $paginaHTML);

//Crea un metodo che faccia questo

$ingredienti = explode(";", "Pane al mais;Doppia maionese;Pomodoro a fette;Lattuga;Pollo croccante");

$lista = "<ul>";
foreach($ingredienti as $ingrediente)
    $lista .= "<li>" . $ingrediente . "</li>";
$lista .="</ul>";

$paginaHTML = str_replace("<listaIngredienti/>", $lista, $paginaHTML);

echo $paginaHTML;
?>