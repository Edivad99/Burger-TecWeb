<?php

require_once "php/util.php";
require_once "php/connectiondb.php";
use Util\Util;
use DB\DBAccess;

session_start();
$username = "";
if(isset($_SESSION["isValid"])) {
    if($_SESSION["isValid"]) {
        $log = "<li><a href=\"areariservata.php\">{{ username }}</a></li>";
        $username = $_SESSION["username"];
    }
    else {
        $log = "<li><a href=\"login.php\" lang=\"en\">LOGIN</a></li>";
    }
}

else {
    $log = "<li><a href=\"login.php\" lang=\"en\">LOGIN</a></li>";
}

$content = array(
    "<login/>" => $log,
    "{{ username }}" => $username
);

echo Util::replacer("html/contatti.html", $content);

?>