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
if(!isset($_SESSION['user'])){die("Permission denied");}
unset($_SESSION['ann']);
if(isset($_POST["msg"])){
	//$_POST["msg"]="this is beta testing";
	$x=$_POST["msg"];
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
	else if($count==5)$fp=fopen("upload/finaladd.mp3", "w");
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
	else if($count==5)$fp=fopen("upload/finaladd.mp3", "w");
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
	
	
	
	$file=("upload/finaladd.mp3");
	$fp=fopen($file,'w');
	fclose($fp);
	$fp=fopen("$file",'a');
	fwrite($fp, $f1);
	if($count>2)
	{$f2=file_get_contents("upload/add2.mp3");fputs($fp, $f2);}
	if($count>3)
	{$f3=file_get_contents("upload/add3.mp3");fputs($fp, $f3);}
	if($count>4)
	{$f4=file_get_contents("upload/add4.mp3");fputs($fp, $f4);}
	fclose($fp);
	$str="upload/finaladd.mp3";
	$chk=mysql_query("INSERT INTO songs (date,uploader,title,artist,type) VALUES('$_GET[date]','$_SESSION[user]','$_POST[sub]','$_SESSION[user]',\"announcement\")");
	if(!$chk)
	{die("couldnt upload");}
	$query=mysql_query("select id from songs where date='$_GET[date]' and uploader='$_SESSION[user]' and title='$_POST[sub]' and artist='$_SESSION[user]' and type='announcement'");
	if(!$chk=mysql_fetch_array($query))
	{die(mysql_error());}
	rename("upload/finaladd.mp3", "upload/".$chk['id'].".mp3");
//	echo "max length limit=399<br/>"	;echo "<button onclick=\"play(5)\">play</button>"; echo "<audio id=5 src='$str' controls></audio>";
	echo "uploaded announcement";
/*
saumya+meenal: add you code here
line no 122 dislplays audio and button(just for convenience). comment that line too.. 

upload the finaladd.mp3(will b created in r2 folder) as u do in normal case. also ask the subject:(like title fo songs, we have subject for adds)..  first insert in Db , them find the id using subject
and then uploading+renaming finaladd.mp3.

*/
}
	?>
	<!DOCTYPE HTML>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIIT Radio...</title>
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <!-- stylesheets -->
  <link href="css/style1.css" rel="stylesheet" type="text/css" />
  <link href="css/colour_calendar.css" rel="stylesheet" type="text/css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <style type="text/css">

</style>
</head>
<body>
<nav style="margin-top:70px;width:100px;margin-right:120px;">
        <ul class="sf-menu" id="nav"">
          <li class="selected"><a href="indextemp.php">Home</a></li>
          
        </ul>
      </nav>
<p style="color:white;"><b> 1.Limit:399 characters</b></br><b>2.Do not press enter while typing the text to change the line.</b></p>
<div style="margin-top:60px;margin-left:150px;">
  <form method="POST" action="" class="form_settings"  style="margin-left:170;margin-right:400;margin-top:30px;">
  <label for="Subject" style="font-weight:bold;font-size:30px;color:black;">Subject:</label><textarea name="sub" style="border-radius:0px;background:black;font-color:black;width:500px;font-size:20px;" rows="1" cols="10"></textarea></br></br>
  </br><textarea name="msg" style="border-radius:0px;background:black;font-color:black;width:700px;font-size:20px;" rows="5" cols="100"></textarea>
  
  </br><div style="margin-left:450px;"></br><input type="submit" name="req" class="submit" style="margin-left:150px;" /></div>
  </form>
  </div>
</form>

<!--else{

echo "limit: 399 characters <br/>";
 echo "<form action=\"\" method=\"POST\" id=\"myform\">
   text:<br/>
<textarea  name=\"msg\"> </textarea><br/>
  
   <input type=\"submit\">
  </form>";
  }
-->
