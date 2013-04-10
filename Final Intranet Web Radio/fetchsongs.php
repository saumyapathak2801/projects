<?php
/*$con = mysql_connect("127.0.0.1","root","password");
if (!$con)
{
//	header("Location:indextemp.php");
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("radio", $con);*/
session_start();
include("res/config.php");
$date=date("Y-m-d");
$result=mysql_query("select id FROM songs WHERE date='$date' and type='song'  order by rating DESC ");
$add=mysql_query("select id FROM songs WHERE date='$date'  and type='announcement'");
$file='songs.txt';
$current="";
//need to insert shuffling algo
//$file2='rate.txt'
$x=mysql_num_rows($result);
$y=mysql_num_rows($add);
$z=$x+$y;

echo $date." x=$x y=$y z=$z";
//$vd=mysql_num_rows($count);
//echo $vd."</br>";
//$filep=fopen("rate.txt","w");
//fwrite($file,$vd);
//fclose($filep);
//file_put_contents($file2,$vd);
$current .=$z." ";
$k=0;$fl=0;$p=0;
while($row = mysql_fetch_array($result)){
	$k=$k+1;
	echo "</br>".$row[0];
	//$p=$p+1;
	//echo $p."<br/>";
//	echo $current;
	$current .=$row[0]." ";
	if($k==3&&$fl<$y){
		$k=0;$fl+=1;
		$row1 = mysql_fetch_array($add);
		$current .=$row1[0]." ";
		//echo "sfvsfvs";
	}
	
}
while($row = mysql_fetch_array($add)){
	$current .=$row[0]." ";
	}
//if(!$row1 = mysql_fetch_array($add)){die(mysql_error());}
//$add=mysql_query("select id FROM songs WHERE date='$date'  and type='announcement'  ");

	//outfile 'songs.txt'
file_put_contents($file, $current);
mysql_close($con);

//$file = file_get_contents('songs.txt', true);
//echo $file;
//echo $date;
?>
				
