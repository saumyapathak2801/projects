<?php 
$current=$_GET["q"];
$count_my_page1=("currentsong.txt");
$fp = fopen($count_my_page1 , "w");
fputs($fp , $current);
fclose($fp);
$count_my_page2 = ("time.txt");
$fp = fopen($count_my_page2 , "w");
$t=time();
fputs($fp , "$t");
fclose($fp);
?>