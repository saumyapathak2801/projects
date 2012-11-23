<?php

session_start();
require("res/config.php");
if(/*!empty($_POST['code']) && !empty($_POST['description']) && !empty($_POST['students']) &&*/ isset($_POST['code'],$_POST['description'],$_POST['students'],$_POST['submit']))
	{
		$query=mysql_query("INSERT INTO prog_detail (code,description,students) values('$_POST[code]','$_POST[description]','$_POST[students]')");
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