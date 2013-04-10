<?php

session_start();
require("res/config.php");
if(!isset($_SESSION['user'])){die("Permission denied");}
$_SESSION['ann']=1;

header("Location:calendar.html");
?>
