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
			<li><a href="insert_batch.php?id=<?php echo $_GET['id']; ?>">Insert</a>
			<li><a href="update.php?id=<?php echo $_GET['id']; ?>">Update</a>
			<li><a href="delete.php?id=<?php echo $_GET['id']; ?>">Delete</a>
			<li><a href="view.php?id=<?php echo $_GET['id']; ?>">View</a>
			
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
