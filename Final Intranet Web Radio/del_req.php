<?php
session_start();
require("res/config.php");
$query=mysql_query("delete  from requests where id='$_GET[id]' ");
if(!$query)
{die(mysql_error());}
else
{header("Location:song_req.php");}