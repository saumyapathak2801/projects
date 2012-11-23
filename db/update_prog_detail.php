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
					<?php if(isset($_SESSION['user'])){
					echo "<li><a href=\"tables.php\">Manage Database</a></li>";}?>
					
					<?php if(isset($_SESSION['user']) && $_SESSION['user']=="admin"){
					echo "<li><a href=\"man_users.php\">Manage Users</a></li>";
					}
					?>
					<li><a href="#">Contact</a></li>
					<?php if (isset($_SESSION['user'])){echo "<li><a href=\"logout.php\">Logout</a></li>";} ?>
				</ul>
			</div>
		</div>
		<div class="container"><img src="images/img03.png" width="1000" height="40" alt="" /></div>
		<div id="banner">
			<div>
			<?php echo "<form action=\"\" method=\"POST\">"; ?>
			<table>
			<?php 
			//echo "<p>".$_GET['id']."</p>";
	//		$res=mysql_query("SELECT * FROM b");
			$myQuery = "show columns from prog_detail";
			$result=mysql_query($myQuery);
			
			while($row = mysql_fetch_row($result))
			{
	//			$col=mysql_num_fields($row);
			//	for($i=0;$i<$col;$i++)
				//{
			if($row[0]=="code")
			{
					echo "<select name=\"code\">";
			$res=mysql_query("select code from prog_detail");
			while($row=mysql_fetch_row($res)){echo "<option value=\"$row[0]\">".$row[0]."</option>";};
			echo "</select>";
			}
			else{
					echo "<tr class=\"table\"><td class=\"table\">$row[0]</td><td class=\"table\"><input type='text' name=\"$row[0]\"/></td></tr>";
				//	echo "hi $row[0]\n";
				//}					
			}
			}
			?>
			<tr class="table"><td><input type="submit" name="submit" value="Update"/></td></tr>
			</table>
			</form>
			</div>
		</div>
	</div>
</div>
</body>
<?php
if(!empty($_POST['description']) && !empty($_POST['students']) && isset($_POST['submit']))
{
				$query=mysql_query("update prog_detail set description='$_POST[description]',students='$_POST[students]' where code='$_POST[code]'");
				if(!$query)
				{die("error");}
				else{header("Location:view.php?id=prog_detail");}
			}
	?>		
</html>
