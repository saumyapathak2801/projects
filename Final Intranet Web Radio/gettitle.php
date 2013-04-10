<?php 
$id=$_GET["q"];
$con = mysql_connect("127.0.0.1","root","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("radio", $con);
$result="select title FROM songs WHERE id='$id' ";
if ( ! ($r = mysql_query($result) ))
			{
			die("Error :". mysql_error());exit;
			}
else{			
$row = mysql_fetch_array($r);
echo $row[0];
return;
}
echo "hey";
?>
