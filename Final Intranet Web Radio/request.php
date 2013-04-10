<html>
<?php

session_start();
require("res/config.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIIT Radio...</title>
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <!-- stylesheets -->
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/colour_calendar.css" rel="stylesheet" type="text/css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <style type="text/css">
  body{background:black;}
  html body ul.sf-menu ul,html body ul.sf-menu ul li { 
  width: 100px;}
  </style>
</head>
  <body>
<div id="main">

    <!-- begin header -->
    <header>
      <div id="logo" ><h1 style="margin-left:-1000px;">IIIT<a href="#">Radio</a></br><div style="margin-left:170px;">..your music..your beat!</div></h1></div>
      <nav style="margin-top:-60px;width:100px;margin-right:-80px;">
        <ul class="sf-menu" id="nav"">
          <li class="selected"><a href="indextemp.php">Home</a></li>
          
        </ul>
      </nav>
    </header>
    <!-- end header -->

  </div>
  <div style="background:transparent;opacity:1;color:black;font: 160% 'News Cycle', arial, sans-serif;margin-left:400;margin-top:50px;font-weight:normal;margin-right:400;border-radius:40px;">
  <?php 
  $query=mysql_query("select * from requests");
	if(!$query){die(mysql_error);}
	else{
	while($row=mysql_fetch_row($query))
	{
		echo "<p style=\"margin-left:10px;padding:10px;color:white;\">$row[1]</br>By:$row[2]</br>$row[3]</p>";
		if($row[2]==$_SESSION['user'])
		{
		echo "<a href=\"del_req.php?id=$row[0]\">Delete</a>";
		}
	}
	}if(isset($_POST['req'],$_POST['request']) && !empty($_POST['request'])){
	$query=mysql_query("INSERT into requests (request,user,date) values('$_POST[request]','$_SESSION[user]',NOW())");
	if(!$query){
	die(mysql_error());}
	else{
	header("Location:request.php");}
	
  }
  ?>
  </div>
  <form method="POST" action="" class="form_settings"  style="margin-left:400;margin-right:400;margin-top:30px;">
  <textarea name="request" style="border-radius:40px;background:grey;font-color:black;"></textarea>
  </br><input type="submit" name="req" style="margin-left:0px;"/>
  </form>
</body>
</html>