<html>
<?php

session_start();
require("res/config.php");
if(!isset($_SESSION['user'])){die("Permission denied");}
?>
<head>
  <title>IIIT Radio...</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <!-- stylesheets -->
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/color2.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
  body
  {
  background-size:200px 200px;
  background-position:-10px 0px;
  background-repeat:no-repeat;
  background-color:#1A1A1A;
  }
  td
  {
  font-size:15px;
  }
table > td{
width:200;



}
  </style>
</head>
<body >
<div id="main">

    <!-- begin header -->
    <header>
      <div id="logo" ><h1 style="margin-left:30px;">IIIT<a href="#">Radio</a></br><div style="margin-left:5px;">..your music..your beat!</div></h1></div>
      <nav style="margin-top:-60px;width:100px;margin-right:-80px;">
        <ul class="sf-menu" id="nav"">
          <li class="selected"><a href="indextemp.php">Home</a></li>
          
        </ul>
      </nav>
	  
    </header>
	<img src="images/mic5.jpg" style="margin-left:-400px;margin-top:0px;position:fixed;height:550px;margin-right:300px;"/>
	
    <!-- end header -->

  </div>
  <div style="background:transparent;opacity:1;color:black;font: 160% 'News Cycle', arial, sans-serif;margin-left:400;margin-top:50px;font-weight:normal;margin-right:400;border-radius:40px;">
  <?php 
  $query=mysql_query("select * from requests");
	if(!$query){die(mysql_error);}
	else{
	echo "<table cellspacing=\"15\">";
	while($row=mysql_fetch_row($query))
	{
		echo "<div style='margin-left:50px;margin-top:50px;'>";
		echo "<tr><td style='text-transform:capitalize;' ><p style=\"padding:10px;color:white;font-size:30px;\">$row[1]</p>";
		echo "<td></td><td></td><td style='white-space: nowrap;'><p style=\"margin-left:10px;padding:10px;color:white;font-size:20px;\">$row[2]</br>$row[3]</p></div>";
		if(isset($_SESSION['user']) && $row[2]==$_SESSION['user'])
		{
		echo "<div style='text-align:right;'><a href=\"del_req.php?id=$row[0]\">Delete</a></div></td></tr>";
		}
	}
	echo "</table>";
	}
//	else{
	//header("Location:song_req.php");}
	
  
  ?>
  </div>
  <div style="margin-top:60px;margin-left:150px;">
  <form method="POST" action="insert1.php" class="form_settings"  style="margin-left:300;margin-right:400;margin-top:30px;">
  <textarea name="request" style="border-radius:0px;background:grey;font-color:black;width:400px;font-size:20px	;" rows="3" cols="100"></textarea>
  </br></br><div style="margin-left:300px;"><input type="submit" name="req" style="margin-left:0px;" class="submit"/></div>
  </form>
  </div>

<!--<input type="text" name="name" id="name" size="30" /></text>

change size here...

<textarea name="comments" id="comments" rows="7" cols="30" ></textarea>
-->
<p style="margin-left:950px;margin-top:50px;font-size:20px;"> Copyright &copy; <a href='http://iiit.ac.in'>IIIT-H</a></p>
</body>
</html>
