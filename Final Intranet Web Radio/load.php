<?php
session_start();
include("res/config.php");
//	if($_SERVER['SERVER_ADDR']=="127.0.0.1")$server=1;
	if($_SESSION['user']=="saumya.pathak@students.iiit.ac.in"||$_SESSION['user']=="abhishek.kumar@students.iiit.ac.in")$server=1;
	else $server=0;
	$z=("songs.txt");
	$list3=file($z);
	$list4=explode(" ",$list3[0]);
//	$server=1;
	
$lock = ("lock.txt");
$lock1 = file($lock);
$time = ("time.txt");
$x=("currentsong.txt");

//if($server==1) echo "<button type=\"button\" onclick=\"resetserver()\">RESET</button>";
if($server&&$lock1[0]==0){

$fp = fopen($lock , "w");
fputs($fp , 1);
fclose($fp);

$fp = fopen($time , "w");
$t=time();
fputs($fp , "$t");
fclose($fp);

$fp = fopen($x , "w");
fputs($fp , 1);
fclose($fp);
}

$cursong=file($x);

 echo"<script src=\"sm2/script/soundmanager2-jsmin.js\"></script>
	<script>
	soundManager.setup({
  url: 'sm2/swf/',
 
  useHTML5Audio: true,
  useHighPerformance: true,
   onready: function() {
    var mySound = soundManager.createSound({
      id: '".$list4[$cursong[0]]."',
      url: 'upload/".$list4[$cursong[0]].".mp3',
	   autoPlay: false,
	   autoLoad: true
    });
    //mySound.play();
  },
  
	debugmode: false
  });
 
	</script>";




 ?>
