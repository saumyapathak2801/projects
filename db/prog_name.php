<?php

session_start();
require("res/config.php");
if(!empty($_POST['code']) && !empty($_POST['name']) && isset($_POST['name'],$_POST['code'],$_POST['submit']))
	{
		$query=mysql_query("INSERT INTO prog_name (code,name) values('$_POST[code]','$_POST[name]')");
		if(!$query)
		{
			die("could not insert");
		}
		else
		{
		unset($_POST['code'],$_POST['name']);
		header("Location:index1.php");
		}
	}
	else if(isset($_POST['submit']))
	{
	echo "Fill in all the fields";
	}	
?>