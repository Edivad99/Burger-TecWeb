<?php
session_start();
if(isset($_SESSION))
    session_destroy();

header("Location: ../login.php");
?>