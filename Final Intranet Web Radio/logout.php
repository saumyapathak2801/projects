<?php


require("res/config.php");
include_once("CAS.php");
phpCAS::client(CAS_VERSION_2_0,"login.iiit.ac.in",443,"/cas");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<style>
h1
{
color:white;
}
</style>
</head>
<body>
<h1>You have successfully logged out :)</h1>
</body>
<?php
unset($_SESSION['valid'],$_SESSION['user']);
session_destroy();
phpCAS::logout();
?>
</html>
