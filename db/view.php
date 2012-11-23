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
					<?php if(isset($_SESSION['user']) && $_SESSION['user']=="admin"){echo "
					<li><a href=\"tables.php\">Manage Database</a></li>
					<li><a href=\"#\">Manage Users</a></li>";}?>
					<li><a href="#">Contact</a></li>
					<?php if (isset($_SESSION['user'])){echo "<li><a href=\"logout.php\">Logout</a></li>";} ?>
				</ul>
			</div>
		</div>
		<div class="container"></div>
		<div id="banner">
			<div class="content">
			<form action="" method="POST">
			<?php
			$q=mysql_query("show index from $_GET[id] where Key_name='PRIMARY'");
			while($p=mysql_fetch_row($q))
			{
			echo "<p><b>".$p[4]."</b></p>";
			
//			echo "<select name=\"primary\">";
			$res=mysql_query("select $p[4] from $_GET[id]");
			while($row=mysql_fetch_row($res)){echo "<input type=\"checkbox\" name=\"check[]\" value=\"$row[0]\"/>".$row[0]."</br>";}
//			echo "</select></br></br>";
			}
			?>
			<input type="submit" name="submitone" value="Show"/>
			<input type="submit" name="submitall" value="Show All"/>
			</form>
			<?php 
			if(isset($_POST['submitall']))
			{
			echo "<table style=\"margin-left:200px;margin-top:-140px;\" border=\"1\">";
		//	echo "<p>hello</p>";
		$myQuery = "show columns from $_GET[id]";
			$result=mysql_query($myQuery);
			echo "<tr>";
			while($row = mysql_fetch_row($result))
			{
					echo "<td style=\"text-align:center;width:100px;\"><b>".$row[0]."</b>"."</td>";
			}
			echo "</tr>";
			$query=mysql_query("select * from $_GET[id]");
//			$row=mysql_fetch_array($query);
			while($row=mysql_fetch_assoc($query))
			{
			echo "<tr>";
//			print_r($row);
				foreach($row as $value)
				{
				echo "<td style=\"text-align:center;width:100px;\">".$value."</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			}
			if(isset($_POST['submitone']))
			{
			echo "<table style=\"margin-left:200px;margin-top:-140px;\" border=\"1\">";
			$q=mysql_query("show index from $_GET[id] where Key_name='PRIMARY'");
			
			while($p=mysql_fetch_row($q))
			{
	//		echo "<p>".$p[4]."</p>";
		//	echo "<p>abcd</p>";
//			echo "<table>";
$myQuery = "show columns from $_GET[id]";
			$result=mysql_query($myQuery);
			echo "<tr>";
			while($row = mysql_fetch_row($result))
			{
					echo "<td style=\"text-align:center;width:100px;\"><b>".$row[0]."</b>"."</td>";
			}
			echo "</tr>";
			if(!empty($_POST['check'])){
			foreach($_POST['check'] as $check)
			{
			$query=mysql_query("select * from $_GET[id] where $p[4]='$check'");
			while($row=mysql_fetch_row($query))
			{
			echo "<tr>";
//			print_r($row);
				foreach($row as $value)
				{
				echo "<td style=\"text-align:center;width:100px;\">".$value."</td>";
				}
				echo "</tr>";
			}
			}
			}
			
			}
			echo "</table>";
			}
			?>
			</div>
			
		</div>
	</div>
	
	<div style="clear: both;">&nbsp;</div>
	</div>
	<div class="container"></div>
 
</div>
<div id="footer-content"></div>

</body>
</html>
