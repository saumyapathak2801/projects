<?php

//session_start();
require("res/config.php");
if(!empty($_POST['id']) && !empty($_POST['avg']) && !empty($_POST['cut_off']) && isset($_POST['id'],$_POST['avg'],$_POST['cut_off'],$_POST['submit']))
	{
		$query=mysql_query("INSERT INTO test_detail (id,avg,cut_off) values('$_POST[id]','$_POST[avg]','$_POST[cut_off]')");
		if(!$query)
		{
			die("could not insert");
		}
		else
		{
		unset($_POST['id'],$_POST['avg'],$_POST['cut_off']);
		header("Location:index1.php");
		}
	}
	else if(isset($_POST['submit']))
	{
	echo "Fill in all the fields";
	}	
?> 