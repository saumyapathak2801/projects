<?php

session_start();
require("res/config.php");
if(!empty($_POST['batch_name']) && !empty($_POST['prog_code']) && isset($_POST['batch_name'],$_POST['prog_code'],$_POST['submit']))
	{
		$query=mysql_query("INSERT INTO batch (prog_code,batch_name) values('$_POST[prog_code]','$_POST[batch_name]')");
		if(!$query)
		{
			die("could not insert");
		}
		else
		{
		header("Location:index1.php");
		}
	}
	else if(isset($_POST['submit']))
	{
	echo "Fill in all the fields";
	}	
?>