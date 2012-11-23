<?php

session_start();
require("res/config.php");
if(!empty($_POST['name']) && !empty($_POST['id']) && isset($_POST['name'],$_POST['id'],$_POST['submit']))
	{
		$query=mysql_query("INSERT INTO employee (name,address,salary,id,dept_no,dob,sex,contact,joining_date) values('$_POST[name]','$_POST[address]','$_POST[salary]','$_POST[id]','$_POST[dept_no]','$_POST[dob]','$_POST[sex]','$_POST[contact]','$_POST[joining_date]')");
		if(!$query)
		{
			die("could not insert");
		}
		else
		{
		unset($_POST['name'],$_POST['address'],$_POST['salary'],$_POST['id'],$_POST['dept_no'],$_POST['dob'],$_POST['sex'],$_POST['contact'],$_POST['joining_date']);
		header("Location:index1.php");
		}
	}
	else if(isset($_POST['submit']))
	{
	echo "Fill in all the fields";
	}	
?>