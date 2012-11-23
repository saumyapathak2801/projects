<?php

session_start();
require("res/config.php");
header("Location:update_".$_GET['id'].".php");
?>