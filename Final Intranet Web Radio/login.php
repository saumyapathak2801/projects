<?php

session_start();
require("res/config.php");
if(isset($_SESSION['user']))
{
	die("You are already logged in");
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<style>

.form
{
	margin-top:150px;
	margin-left:400px;
	margin-right:400px;
position:relative;
border-radius:10px;
}
.table
{
	margin-top:-70px;
	margin-left:60px;
}
.table tr
{
	margin-top:-50px;
	font-family: 'Abel', sans-serif;
	font-size: 16px;
	font-weight: 300;
}
.table td
{
padding:10px;
	font-size:30px;
	color:white;
	margin-top:-50px;
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
margin-left:230px;
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
<form action="" method="POST" class="form">
<table class="table">
<tr class="table"><td class="table"><label for="user">User:</label></td><td><input type="text" name="user"/></td></tr>
<br/>
<br/>
<tr class="table"><td class="table">
<label for="passwd">Password:</label></td><td><input type="password" name="passwd"/></td></tr>
<br/><br/>
</table>
<br/>
<input type="submit" name="login" value="Log in" id="al"/>
</form>
</body>


<?php
if (isset($_POST['user'],$_POST['passwd']))
{
$_POST['user']=trim($_POST['user']);
$_POST['passwd']=trim($_POST['passwd']);
}
//echo $_POST['user'],$_POST['passwd'];
if(!empty($_POST['user']) && !empty($_POST['passwd']) && isset($_POST['user'],$_POST['passwd'],$_POST['login']))
{
	$chk=mysql_query("SELECT * FROM users WHERE name='$_POST[user]'");
	if(!$chk)
	{ die("select".mysql_error());}
	$chk2=mysql_num_rows($chk);
	$arr=mysql_fetch_array($chk);
	if($arr["pass"]==$_POST["passwd"])
	{
	//	echo "helo";
		$_SESSION['valid']=1;
		$_SESSION['user']=trim($_POST['user']);
	//	echo "<h1>YAYY</h1>";
		header("Location:b22.php");
	}
	else
	{
		echo "<h1>DON'T tresspass</h1>";
	}
	unset($_POST['user'],$_POST['passwd']);
}
else if(isset($_POST['login']))
{
	echo "<h1>Fill in all d fields</h1>";
}
?>
</html>