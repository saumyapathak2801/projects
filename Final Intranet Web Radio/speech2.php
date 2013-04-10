<script>
function play(n){
if(n==6)return;
a=document.getElementById(n);
a.play();
a.addEventListener("ended",function(){play(n+1);});
}
function parse_send(){
a=document.forms["myform"]["msg"].value;
for(var i=0;i<a.length;i++)if(a[i]=='\n')a[i]='.';
document.forms["myform"]["msg"].value=a;
//document.getElementById("msg").value="sdgvdfb";
document.getElementById("myform").submit();
//return false;
}


</script>
<?php

session_start();
require("res/config.php");
if(!isset($_SESSION['user']) || $_SESSION['fac']!=0){die("Permission denied");}
unset($_SESSION['ann']);
if(isset($_POST["msg"])){

	//$_POST["msg"]="this is beta testing.".;
	$x="This is an announcement...".$_POST["msg"]."... Announcement ends...";
	//echo "x=".$x."<br/>";
	//.strlen($x)."<br/>";
//	$x=trim($x1, "\n");
//	echo $x."111";
//	for($i=0;$i<strlen($x);$i++)if($x[$i]=='\n')$x[$i]='.';
//	$x[0]='p';
	//echo $x."ssdc";
		
	if(strlen($x)==0){echo "Enter some text..";return;}
	if(strlen($x)>399){echo "limit exceeded";return;}
	
	$y=explode(' ',$x);
	$l=count($y);
	$s="";
	$dump="#!/bin/bash \n";
	$count=1;
	for($i=0;$i<$l;$i++){
//		if($y[$i][0]=='\0')$y[$i][1]='X';
//$y[$i][0]='X';
//echo "a".$y[$i]."_$i ";
		if((strlen($s)+strlen($y[$i]))<=99){
		$s.= $y[$i]."+";
		if($i==$l-1){
	//$f= ("add1.mp3");
	//echo $s."  \n[][]";
	if($count==1)$fp=fopen("upload/add1.mp3", "w");
	else if($count==2)$fp=fopen("upload/add2.mp3", "w");
	else if($count==3)$fp=fopen("upload/add3.mp3", "w");
	else if($count==4)$fp=fopen("upload/add4.mp3", "w");
//	else if($count==5)$fp=fopen("upload/finaladd.mp3", "w");
	$curl=curl_init();
	$proxy='proxy.iiit.ac.in:8080'; curl_setopt($curl ,CURLOPT_PROXY, $proxy);
    	curl_setopt($curl, CURLOPT_URL,'http://translate.google.com/translate_tts?tl=en&q='.$s);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($curl, CURLOPT_REFERER, NULL);
	curl_setopt($curl, CURLOPT_FILE, $fp);
	if(curl_exec($curl) === false)// > add1.mp3
		{ echo 'curl error: ' .curl_error($curl);}
	//fputs($fp , "$r");
	//	fputs($fp,"wdidhedb");
//	echo $r;
	fclose($fp);
	
	
	curl_close($curl);
			$count+=1;
	//		echo "s=".$s;
			$s="";
			//echo $dump."-";
			}
		}
		else{	//echo $s." {}{} ";
		
	//$f= ("add1.mp3");
//	$f=$count."mp3";
	//$f=$count."mp3";	
	if($count==1)$fp=fopen("upload/add1.mp3", "w");
	else if($count==2)$fp=fopen("upload/add2.mp3", "w");
	else if($count==3)$fp=fopen("upload/add3.mp3", "w");
	else if($count==4)$fp=fopen("upload/add4.mp3", "w");
//	else if($count==5)$fp=fopen("upload/finaladd.mp3", "w");
	//$fp=fopen($f, "w");
	$curl=curl_init();
	$proxy='proxy.iiit.ac.in:8080'; curl_setopt($curl ,CURLOPT_PROXY, $proxy);
    	curl_setopt($curl, CURLOPT_URL,'http://translate.google.com/translate_tts?tl=en&q='.$s);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_FILE, $fp);
	curl_exec($curl);// > add1.mp3
	//fputs($fp , "$r");
	//fputs($fp,"djhmbcdb");
//	fclose($fp);
	
	
	curl_close($curl);
		
		$s="";
		$i-=1;
		$count+=1;
		//echo $dump."-";
		}
	}
	//for($i=1;$i<$count;$i++){
	//$dump.="cat  $i.mp3 >> h.mp3 \n";
	$f1=file_get_contents("upload/add1.mp3");
	
	
	      $fp=fopen("/var/lib/mpd/music/finaladd.mp3","w");
//	      chmod("/var/lib/mpd/music/finaladd.mp3",0777);
	      fclose($fp);
//	      fwrite($fp,$_FILES['file']['name']);
//	      fclose($fp);
	
	$file=("/var/lib/mpd/music/finaladd.mp3");
	$fp=fopen("$file",'a');
	chmod("/var/lib/mpd/music/finaladd.mp3",0777);

	fwrite($fp, $f1);
	if($count>2)
	{$f2=file_get_contents("upload/add2.mp3");fwrite($fp, $f2);}
	if($count>3)
	{$f3=file_get_contents("upload/add3.mp3");fwrite($fp,$f3);}
	if($count>4)
	{$f4=file_get_contents("upload/add4.mp3");fputs($fp, $f4);}
	fclose($fp);
	
	if(!isset($_POST["place"]))$s="song+announce";
	else $s="announcement";
	$str="/var/lib/mpd/music/finaladd.mp3";
	
	$chk=mysql_query("INSERT INTO songs (date,uploader,title,artist,type) VALUES('$_POST[date]','$_SESSION[user]','$s','$_SESSION[user]',\"announcement\")");
	if(!$chk)
	{die("couldnt upload");}
	$q1=mysql_query("select MAX(id) from songs");
	$q=mysql_fetch_array($q1);
	$a= $q['MAX(id)'];
	$query=mysql_query("select id from songs where date='$_POST[date]' and uploader='$_SESSION[user]'  and id='$a' and type='announcement'");
	if(!$chk=mysql_fetch_array($query))
	{die(mysql_error());}
	rename("/var/lib/mpd/music/finaladd.mp3", "/var/lib/mpd/music/".$chk['id'].".mp3");

	$chk1=mysql_query("SELECT * from songs WHERE date='$_POST[date]'");
      $chk2=mysql_num_rows($chk1);
      if($chk2==1)
      {
	      $fp=fopen("/var/lib/mpd/playlists/".$_POST['date'].".m3u","w");
	      chmod("/var/lib/mpd/playlists/".$_POST['date'].".m3u",0777);
	      fwrite($fp,$chk['id'].".mp3");
	      fclose($fp);
      }
      else if($chk2>0)
      {
	      chmod("/var/lib/mpd/playlists/".$_POST['date'].".m3u",0777);
	      $fp=fopen("/var/lib/mpd/playlists/".$_POST['date'].".m3u","a");
	      fwrite($fp,"\n".$chk['id'].".mp3");
	      fclose($fp);
      }
//	echo "max length limit=399<br/>"	;echo "<button onclick=\"play(5)\">play</button>"; echo "<audio id=5 src='$str' controls></audio>";

	if(!isset($_POST['click'])){
		echo "uploaded announcement";}
}
?>
<?php
	if(!isset($_POST['click'])){
		include 'speech2_part2.php';}
/*
saumya+meenal: add you code here
 dislplays audio and button(just for convenience). comment that line too.. 

upload the finaladd.mp3(will b created in r2 folder) as u do in normal case. also ask the subject:(like title fo songs, we have subject for adds)..  first insert in Db , them find the id using subject
and then uploading+renaming finaladd.mp3.

*/

	?>

