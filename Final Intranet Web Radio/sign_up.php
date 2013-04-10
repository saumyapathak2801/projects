<html>
<?php
require("res/config.php");
?>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<style>
.table
{
margin-top:70px;
margin-left:400px;
}
tr
{
margin-top:-50px;
font-family:"Comic Sans MS", cursive, sans-serif;
font-size:30px;
}
td
{
padding:10px;
font-size:30px;
color:white;
margin-top:-50px;
font-family:"Comic Sans MS", cursive, sans-serif;
}
td > input
{
width:200px;
height:30px;
border-bottom-left-radius:1em;
border-bottom-right-radius:1em;
border-top-left-radius:1em;
border-top-right-radius:1em;
}
#sub
{
font-family:"Trebuchet MS", Helvetica, sans-serif;
width:80px;
padding:7px;
font-weight:bold;
margin-left:630px;
background:#808080;
border-bottom-left-radius:1em;
border-bottom-right-radius:1em;
border-top-left-radius:1em;
border-top-right-radius:1em;
}
#sub:hover
{
background:#DCDCDC;
}
h1,h3
{
color:white;
}
</style>
</head>
<body>
<form action="" autocomplete="on" method="POST">
<table class="table">
<tr>
<td>First name</td>
<td><input type="text" name="f_name"/>
</tr>
<tr>
<td>Last name</td>
<td><input type="text" name="l_name"/>
</tr>
<tr>
<td>Username</td>
<td><input type="text" name="U_name"/>
</tr>
<tr>
<td>Email Id</td>
<td> <input type="email" name="email" autocomplete="off"/></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" name="pwd"/>
</tr>
<tr>
<td>Confirm Password</td>
<td><input type="password" name="pwd1"/>
</tr>
</table>
<br/>
<input type="submit" value="submit" name="submit" id="sub"/>
</form>
<?php
if(!empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['U_name']) && !empty($_POST['email']) && !empty($_POST['pwd']) && !empty($_POST['pwd1']) && isset($_POST['f_name'],$_POST['l_name'],$_POST['U_name'],$_POST['email'],$_POST['pwd'],$_POST['pwd1'],$_POST['submit']))
{
if($_POST['pwd']==$_POST['pwd1'])
{
mysql_query("INSERT INTO users (fname,lname,emailid,name,pass) 
VALUES('$_POST[f_name]', '$_POST[l_name]' ,'$_POST[email]','$_POST[U_name]','$_POST[pwd]')");
session_start();
$_SESSION['user']=trim($_POST['user']);
$_SESSION['valid']=1;
header("Location:b.php");
}
else 
{
echo "<h3> Passwords dont match</h3>";
}
}
else if(isset($_POST['submit']))
{
echo "<h1>Fill in all the fields</h1>";
}
?>
</body>
</html>