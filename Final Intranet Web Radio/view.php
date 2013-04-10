
<?php
$date=date("Y-m-d");
 $con = mysql_connect("127.0.0.1","root","password");
		 
		
		if (!$con)
		{
		die('Could not connect: ' . mysql_error());
		}
		echo $date;
		echo "
	<h2 style=\"position: fixed; margin-left:200px;\">ALL SONGS</h2>
		<div style=\"width: 600px; height: 400px; overflow: scroll;\" class=\"margin\">
		
		";
		$fields=mysql_query("SHOW COLUMNS FROM radio.songs");
		$result = mysql_query("SELECT * FROM radio.songs");
		$result1=mysql_query("select * FROM radio.songs WHERE date='$date'");
		$fields=mysql_query("SHOW COLUMNS FROM radio.songs");
		echo"<table style=\"width:100%\"><tr >";
		while($row1 = mysql_fetch_array($fields)){
		echo "<th><center>&emsp;&emsp;&nbsp;$row1[0]</center></th>";}
		echo "</tr>";
		while($row = mysql_fetch_array($result))
{
  echo "<tr >";
  //echo sizeof($row);
  for($i=0;$i<count($row);$i+=2)
  {
 echo "<td><center>&emsp;&emsp;" . $row[$i/2] . "</center></td>";
 // echo "srgsrgvsgrssrgf=".$row1[0];
} 
 echo "</tr>"; 
  }
echo "</table ></div></center>";
$fields=mysql_query("SHOW COLUMNS FROM radio.songs");
	echo "
	<h2 style=\"position: fixed; margin-left:65%;\">SONGS to be played today</h2>";
echo"<div style=\"width: 600px; height: 400px; overflow: scroll;  margin-right:30px;\" class=\"margin2\">

<table style=\"width:100%\"><tr >";
		while($row1 = mysql_fetch_array($fields)){
		echo "<th><center>&emsp;&emsp;&nbsp;$row1[0]</center></th>";}
		echo "</tr>";
		while($row = mysql_fetch_array($result1))
{
  echo "<tr >";
  //echo sizeof($row);
  for($i=0;$i<count($row);$i+=2)
  {
 echo "<td><center>&emsp;&emsp;" . $row[$i/2] . "</center></td>";
 // echo "srgsrgvsgrssrgf=".$row1[0];
} 
 echo "</tr>"; 
  }
echo "</table></center></div>";
mysql_close($con);


	?>

	<link rel="stylesheet" type="text/css" href="style_table.css">
