<?php

//session_start();
require("res/config.php");
if(!empty($_POST['emp_id']) && !empty($_POST['batch']) && isset($_POST['emp_id'],$_POST['batch'],$_POST['submit']))
	{
		$query=mysql_query("INSERT INTO teaches (emp_id,batch) values('$_POST[emp_id]','$_POST[batch]')");
		if(!$query)
		{
			die("could not insert");
		}
		else
		{
		unset($_POST['emp_id'],$_POST['batch']);
		header("Location:index1.php");
		}
	}
	else if(isset($_POST['submit']))
	{
	echo "Fill in all the fields";
	}	
?>