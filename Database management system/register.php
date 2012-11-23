<?php
session_start();
$con=mysql_connect("127.0.0.1","root","");
if(!$con){die("Could not connect");}
mysql_select_db("rp");
//require("res/config.php");
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
	color:black;
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
					<li><a href="#">Login</a></li>
					<?php if(isset($_SESSION['user']) && $_SESSION['user']=="admin"){echo "
					<li><a href=\"tables.php\">Manage Database</a></li>
					<li><a href=\"musers.php\">Manage Users</a></li>";}?>
					<li><a href="#">Contact</a></li>
					<?php if (isset($_SESSION['user'])){echo "<li><a href=\"logout.php\">Logout</a></li>";} ?>
				</ul>
			</div>
		</div>
		<div class="container"></div>
		<div id="banner">
			<div class="content">		
			<form action="" method="POST" class="form">
<table class="table">
<tr class="table"><td class="table"><label for="user">Username:</label></td><td><input type="text" name="user"/></td></tr>
<br/>
<br/>
<tr class="table"><td class="table">
<label for="passwd">Password:</label></td><td><input type="password" name="passwd"/></td></tr>
<br/><br/>
<tr class="table"><td class="table"><label for="repass">Re-type Password:</label></td><td><input type="password" name="repass"/></td></tr>
<br/>
<br/>
</table>
<br/>
<input type="submit" name="login" value="Log in" id="al"/>
</form>
</div>
			<div><img src="images/img03.png" width="1000" height="40" alt="" /></div>
		</div>
	
<?php
//echo "<p>hello</p>";
//echo $_POST['user'],$_POST['passwd'];
if (!empty($_POST['user']) && !empty($_POST['passwd']) && !empty($_POST['repass']) && isset($_POST['user'],$_POST['passwd'],$_POST['repass']))
{
$_POST['user']=trim($_POST['user']);
$_POST['passwd']=trim($_POST['passwd']);
$_POST['repass']=trim($_POST['repass']);
if($_POST['passwd']!=$_POST['repass'])
{echo "<p>Passwords do not match</p>";}
else
{
$query=mysql_query("CREATE USER '$_POST[user]'@'localhost' identified by '$_POST[passwd]'");
if(!$query){die("sorry".mysql_error());}
$query=mysql_query("GRANT SELECT ON rp.* to '$_POST[user]'@'localhost' identified by '$_POST[passwd]'");
if(!$query){die(mysql_error());}
mysql_close($con);
$con=mysql_connect("127.0.0.1",$_POST['user'],$_POST['passwd']);
if(!$con){die("Could not connect");}
mysql_select_db("rp");

$_SESSION['user']=$_POST['user'];
$_SESSION['passwd']=$_POST['passwd'];
header("Location:index1.php");
}
}
?>
</div>
</body>
</html>
