<script>
function play(n){
if(n==5)return;
a=document.getElementById(n);
a.play();
a.addEventListener("ended",function(){play(n+1);});
}
</script>
<?php
if(isset($_GET["msg"])){
	$x=$_GET["msg"];
	echo "saas=".strlen($x);
	if(strlen($x)>399){echo "limit exceeded";return;}
	echo "<button onclick=\"play(1)\">play</button>";
	$y=explode(' ',$x);
	$l=count($y);
	$s="";
	$dump="#!/bin/bash \n";
	$count=1;
	$f= ("1.mp3");
	for($i=0;$i<$l;$i++){
		if((strlen($s)+strlen($y[$i]))<=99){
		$s.= $y[$i]."+";
		if($i==$l-1){
	//$f= ("1.mp3");
	echo $s."  \n[][]";
	$f= $count."mp3";
	if($count==1)$fp=fopen("1.mp3", "w");
	else if($count==2)$fp=fopen("2.mp3", "w");
	else if($count==3)$fp=fopen("3.mp3", "w");
	else if($count==4)$fp=fopen("4.mp3", "w");
	else if($count==5)$fp=fopen("5.mp3", "w");
	$curl=curl_init();
    	curl_setopt($curl, CURLOPT_URL,'http://translate.google.com/translate_tts?tl=en&q='.$s);
	//curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_FILE, $fp);
	curl_exec($curl);// > 1.mp3
	//fputs($fp , "$r");
//	fputs($fp,"wdidhedb");
	fclose($fp);
	
	
	curl_close($curl);
			$count+=1;
			$s="";
			//echo $dump."-";
			}
		}
		else{	echo $s." {}{} ";
		
	//$f= ("1.mp3");
//	$f=$count."mp3";
	//$f=$count."mp3";	
	if($count==1)$fp=fopen("1.mp3", "w");
	else if($count==2)$fp=fopen("2.mp3", "w");
	else if($count==3)$fp=fopen("3.mp3", "w");
	else if($count==4)$fp=fopen("4.mp3", "w");
	else if($count==5)$fp=fopen("5.mp3", "w");
	//$fp=fopen($f, "w");
	$curl=curl_init();
    	curl_setopt($curl, CURLOPT_URL,'http://translate.google.com/translate_tts?tl=en&q='.$s);
//	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_FILE, $fp);
	curl_exec($curl);// > 1.mp3
	//fputs($fp , "$r");
	//fputs($fp,"djhmbcdb");
	fclose($fp);
	
	
	curl_close($curl);
		
		$s="";
		$i-=1;
		$count+=1;
		//echo $dump."-";
		}
	}
	//for($i=1;$i<$count;$i++){
	//$dump.="cat  $i.mp3 >> h.mp3 \n";
	$f1=("1.mp3");
	$f2=("2.mp3");
	$f3=("3.mp3");
	$f4=("4.mp3");
	$fp=fopen("5.mp3","w");
	fclose($fp);
	fopen("5.mp3","a");
	fputs($fp, $f1[0]);
	fputs($fp, $f2[0]);
	fputs($fp, $f3[0]);
	fputs($fp, $f4[0]);
	fclose($fp);
	
	for($i=1;$i<$count;$i++){
		echo "<audio id=$i src=\"$i.mp3\"></audio>";
		}
		echo "<audio id=$i src=\"5.mp3\"></audio>";
	}
	//echo "message=".$dump;
	//shell_exec('su sh get.sh');
//	exec("rm 4.mp3");
//for($i=0;$i<$count;$i++)
	//echo "<audio id=1 src=\"h.mp3\" controls autoplay>check</audio>";
	//echo "<button onclick=\"play($count)\">play</button>";
	
else{
echo "limit: 399 characters <br/>";
 echo "<form action=\"\" method=\"GET\">
   text:<textarea name=\"msg\" ></textarea><br />
  
   <input type=\"submit\">
  </form>";
  }
?>
