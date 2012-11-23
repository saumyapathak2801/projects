<?php

//session_start();
require("res/config.php");
?>
<html>
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
			<div class="content">
			<ul>
			<?php
			$res=mysql_query("SHOW TABLES FROM rp");
			$i=1;
			while($row = mysql_fetch_array($res, MYSQL_NUM)) {
			if($row[0]!="login")
			{
				echo "<li><a href=\"idu.php?id=$row[0]\">$row[0]\n</a></li>";
				$i=$i+1;
				}
			}?>
			</ul>
			</div>
		</div>
	</div>
	<!-- end #header -->
	
	<div class="container"><img src="images/img03.png" width="1000" height="40" alt="" /></div>
	<!-- end #page --> 
</div>
<div id="footer-content"></div>

<!-- end #footer -->
</body>
</html>
