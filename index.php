<?php

require_once "php/util.php";
use Util\Util;

session_start();
if(isset($_SESSION["isValid"])) {
    if($_SESSION["isValid"]) {
        $log = "<li><a href=\"areariservata.php\">Area Riservata</a></li>";
    }
    else {
        $log = "<li><a href=\"login.php\" lang=\"en\">LOGIN</a></li>";
    }
}

else {
    $log = "<li><a href=\"login.php\" lang=\"en\">LOGIN</a></li>";
}

$content = array(
    "<login/>" => $log
);

echo Util::replacer("html/index.html", $content);

?>