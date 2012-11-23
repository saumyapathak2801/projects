<?php

//session_start();
require("res/config.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>RP Bhopal</title>
<link href='font.css' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<style>
.form
{
	margin-top:150px;
	margin-left:200px;
	margin-right:400px;
position:relative;
border-radius:10px;
}
.table
{
	margin-top:-200px;
	margin-left:160px;
}
.table tr
{
	margin-top:-200px;
	font-family: 'Abel', sans-serif;
	font-size: 16px;
	font-weight: 300;
}
.table td
{
padding:10px;
	font-size:30px;
	color:white;
	margin-top:-200px;
	font-family: 'Abel', sans-serif;
	font-size: 16px;
	font-weight: 300;
}
.table td > input
{
width:200px;
height:30px;
	border-radius:20px;
}
#al
{font-family:"Trebuchet MS", Helvetica, sans-serif;
width:70px;
padding:7px;
font-weight:bold;
margin-left:320px;
background:#808080;
border-bottom-left-radius:1em;
border-bottom-right-radius:1em;
border-top-left-radius:1em;
border-top-right-radius:1em;
}
#al:hover
{
background:#DCDCDC;
}
h1
{
color:white;
}
</style>
</head>
<body>
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header" class="container">
			<div id="logo">
				<h1><a href="#">RP Bhopal </a></h1>
			</div>
			<div id="menu">
				<ul>
					<li class="current_page_item"><a href="index1.php">Homepage</a></li>
					<li><a href="login.php">Login</a></li>
					<li><a href="tables.php">Manage Database</a></li>
					<li><a href="man_users.php">Manage Users</a></li>
					<li><a href="#">Contact</a></li>
					<?php if (isset($_SESSION['user'])){echo "<li><a href=\"logout.php\">Logout</a></li>";} ?>
				</ul>
			</div>
		</div>
		<div class="container"><img src="images/img03.png" width="1000" height="40" alt="" /></div>
		<div id="banner">
			<div>
			<form action="" method="POST">
			<table>
			<?php 
			if($_GET['id']=="employee")
			{
			echo "<select name=\"emp\">";
			$res=mysql_query("select id from employee");
			while($row=mysql_fetch_row($res)){echo "<option value=\"$row[0]\">".$row[0]."</option>";};
			echo "</select>";
			if(!empty($_POST['emp']) && isset($_POST['submit']))
			{
				$query=mysql_query("DELETE from employee where id='$_POST[emp]'");
				if(!$query)
				{die("error");}
				else{header("Location:index1.php");}
			}
			}
			if($_GET['id']=="student")
			{
			echo "<select name=\"stu\">";
			$res=mysql_query("select roll from student");
			while($row=mysql_fetch_row($res)){echo "<option value=\"$row[0]\">".$row[0]."</option>";};
			echo "</select>";
			if(!empty($_POST['stu']) && isset($_POST['submit']))
			{
				$query=mysql_query("DELETE from student where roll='$_POST[stu]'");
				if(!$query)
				{die("error");}
				else{header("Location:index1.php");}
			}
			}
			if($_GET['id']=="dept_name")
			{
			echo "<select name=\"dname\">";
			$res=mysql_query("select id from dept_name");
			while($row=mysql_fetch_row($res)){echo "<option value=\"$row[0]\">".$row[0]."</option>";};
			echo "</select>";
			if(!empty($_POST['dname']) && isset($_POST['submit']))
			{
				$query=mysql_query("DELETE from dept_name where id='$_POST[dname]'");
				if(!$query)
				{die("error");}
				else{header("Location:index1.php");}
			}
			}
			if($_GET['id']=="prog_name")
			{
			echo "<select name=\"pname\">";
			$res=mysql_query("select code from prog_name");
			while($row=mysql_fetch_row($res)){echo "<option value=\"$row[0]\">".$row[0]."</option>";};
			echo "</select>";
			if(!empty($_POST['pname']) && isset($_POST['submit']))
			{
				$query=mysql_query("DELETE from prog_name where code='$_POST[pname]'");
				if(!$query)
				{die("error");}
				else{header("Location:index1.php");}
			}
			}
			if($_GET['id']=="batch")
			{
			echo "<select name=\"bname\">";
			$res=mysql_query("select batch_name from batch");
			while($row=mysql_fetch_row($res)){echo "<option value=\"$row[0]\">".$row[0]."</option>";};
			echo "</select>";
			if(!empty($_POST['bname']) && isset($_POST['submit']))
			{
				$query=mysql_query("DELETE from batch where batch_name='$_POST[bname]'");
				if(!$query)
				{die("error");}
				else{header("Location:index1.php");}
			}
			}
			if($_GET['id']=="teaches")
			{
			echo "<select name=\"emp\">";
			echo "emp_id";
			$res=mysql_query("select emp_id from teaches");
			while($row=mysql_fetch_row($res)){echo "<option value=\"$row[0]\">".$row[0]."</option>";};
			echo "</select>";
			echo "<select name=\"batch\">";
			$res=mysql_query("select batch from teaches");
			while($row=mysql_fetch_row($res)){echo "<option value=\"$row[0]\">".$row[0]."</option>";};
			echo "</select>";
			
			if(!empty($_POST['emp']) && !empty($_POST['batch']) && isset($_POST['submit']))
			{
				$query=mysql_query("DELETE from teaches where batch='$_POST[batch]' and emp_id='$_POST[emp]'");
				if(!$query)
				{die("error".mysql_error());}
				else{header("Location:index1.php");}
			}
			}
			if($_GET['id']=="test_detail")
			{
			echo "<select name=\"tid\">";
			$res=mysql_query("select id from test_detail");
			while($row=mysql_fetch_row($res)){echo "<option value=\"$row[0]\">".$row[0]."</option>";};
			echo "</select>";
			if(!empty($_POST['tid']) && isset($_POST['submit']))
			{
				$query=mysql_query("DELETE from test_detail where id='$_POST[tid]'");
				if(!$query)
				{die("error");}
				else{header("Location:index1.php");}
			}
			}
			
			
		
		/*	//echo "<p>".$_GET['id']."</p>";
	//		$res=mysql_query("SELECT * FROM batch");
			$myQuery = "show keys from $_GET[id] where key_name='PRIMARY'";
			$result=mysql_query($myQuery);
			echo $result;
			while($row = mysql_fetch_row($result))
			{
	//			$col=mysql_num_fields($row);
			//	for($i=0;$i<$col;$i++)
				//{
//					echo "<tr class=\"table\"><td class=\"table\">$row[0]</td><td class=\"table\"><input type='text' name=\"$row[0]\"/></td></tr>";
					echo "hi $row[2]\n";
				//}					
			}
			*/
			?>
			<tr class="table"><td><input type="submit" name="submit" value="delete"/></td></tr>
			</table>
			</form>
			</div>
		</div>
	</div>
</div>
</body>	
</html>
