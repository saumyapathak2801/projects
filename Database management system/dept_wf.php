<?php

session_start();
require("res/config.php");
if(!empty($_POST['id']) && !empty($_POST['workforce']) && isset($_POST['id'],$_POST['workforce'],$_POST['submit']))
	{
		$query=mysql_query("INSERT INTO dept_wf (id,workforce) values('$_POST[id]','$_POST[workforce]')");
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