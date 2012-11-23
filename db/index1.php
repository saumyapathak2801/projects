<?php

session_start();
//require("res/config.php");
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
			<h4 style="margin-top:20px; margin-left:550px;"><?php if(isset($_SESSION['user'])){echo "Welcome ".$_SESSION['user'];}?></h4>
				<ul <?php if(isset($_SESSION['user'])){echo "style=\"margin-top:-50px;margin-left:-70px;\"";}?>>
					<li class="current_page_item"><a href="index1.php">Homepage</a></li>
					<li><a href="login.php">Login</a></li>
					<?php if(isset($_SESSION['user'])){
					echo "<li><a href=\"tables.php\">Manage Database</a></li>";}
					else{echo "<li><a href=\"register.php\">Register</a></li>";}?>
					
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
			<div class="content"><img src="images/rp.jpg" width="1040" height="400" alt="" /></div>
			<div><img src="images/img03.png" width="1000" height="40" alt="" /></div>
		</div>
	</div>
	<!-- end #header -->
	<div id="page">
		<div id="three-columns">
			<div id="column1">
				
				
				
				
			</div>
			<div id="column2">
				<h2></h2>
				
				
				
			</div>
			<div id="column3">
				
			</div>
		</div>
		<div id="content">
			<div class="post">
				<h2 class="title"><a href="#">Welcome to RP Bhopal </a></h2>
				
				<div style="clear: both;">&nbsp;</div>
				<div class="entry">
					
				</div>
			</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
		
		</div>
		<!-- end #sidebar -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<div class="container"><img src="images/img03.png" width="1000" height="40" alt="" /></div>
	<!-- end #page --> 
</div>
<div id="footer-content"></div>

<!-- end #footer -->
</body>
</html>
