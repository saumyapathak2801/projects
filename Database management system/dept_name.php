<?php

session_start();
require("res/config.php");
if(!empty($_POST['name']) && !empty($_POST['id']) && isset($_POST['name'],$_POST['id'],$_POST['submit']))
	{
		$query=mysql_query("INSERT INTO dept_name (name,id) values('$_POST[name]','$_POST[id]')");
		if(!$query)
		{
			die("could not insert");
		}
		else
		{
		unset($_POST['id'],$_POST['submit']);
		header("Location:index1.php");
		}
	}
	else if(isset($_POST['submit']))
	{
	echo "Fill in all the fields";
	}	
?>