<?php
session_start();
require("res/config.php");
$query=mysql_query("INSERT into requests (request,user,date) values('$_POST[request]','$_SESSION[user]',NOW())");
if(!$query)
{die(mysql_error());}
else
{header("Location:song_req.php");}
?>