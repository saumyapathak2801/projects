<?php


require("res/config.php");
if(!empty($_POST['roll']) && !empty($_POST['marks']) && !empty($_POST['percentile']) && !empty($_POST['test_id']) && isset($_POST['roll'],$_POST['marks'],$_POST['percentile'],$_POST['test_id'],$_POST['submit']))
	{
		$query=mysql_query("INSERT INTO result (roll,marks,percentile,test_id) values('$_POST[roll]','$_POST[marks]','$_POST[percentile]','$_POST[test_id]')");
		if(!$query)
		{
			die("could not insert");
		}
		else
		{
		unset($_POST['roll'],$_POST['marks'],$_POST['percentile'],$_POST['test_id']);
		header("Location:index1.php");
		}
	}
	else if(isset($_POST['submit']))
	{
	echo "Fill in all the fields";
	}	
?>