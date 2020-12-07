<?php

//Rendere di default la chiamata menu.php => menu.php?categoria=1
$paginaHTML = file_get_contents("html/menu.html");
echo $paginaHTML;
?>