<?php
if(!empty($_GET['id'])){ 
$current=$_GET["id"];
$count_my_page1=("rate.txt");
$fp = fopen($count_my_page1 , "w");
fputs($fp , $current);
fclose($fp);
}
?>