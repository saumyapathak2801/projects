<?php
session_start();
require("res/config.php");

if(isset($_POST['submit']))
		{
		$query=mysql_query("INSERT INTO student (name,parents_name,roll,dob,sex,address,contact,batch,status) VALUES
		('$_POST[name]','$_POST[parents_name]','$_POST[roll]','$_POST[dob]','$_POST[sex]','$_POST[address]','$_POST[contact]','$_POST[batch]','$_POST[status]')");
		if(!$query)
		{
		die("could not insert");
		}
		else
		{
		header("Location:index1.php");
		}
		}
?>