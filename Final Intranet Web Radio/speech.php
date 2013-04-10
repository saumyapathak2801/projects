<?php
if(isset($_GET["msg"])){
	$x=$_GET["msg"];
	$y=explode(' ',$x);
	$l=count($y);
	$s="";
	$dump="";
	$count=1;
	for($i=0;$i<$l;$i++){
		if((strlen($s)+strlen($y[$i]))<=100){
		$s.= $y[$i]."+";
		if($i==$l-1){
			$dump.="curl -A \"Mozilla\" \"http://translate.google.com/translate_tts?tl=en&q=".$s." > ".$count.".mp3";
			$dump.="\n";
			$count+=1;
			$s="";
			//echo $dump."-";
			}
		}
		else{
		$dump.="curl -A \"Mozilla\" \"http://translate.google.com/translate_tts?tl=en&q=".$s." > ".$count.".mp3";
		$dump.="\n";
		$count+=1;
		$s="";
		//echo $dump."-";
		}
	}
	$dump.="h.mp3=\"\""."\n";
	for($i=1;$i<$count;$i++){
	$dump.="cat  $i.mp3 >> h.mp3 \n";
	}
	$f = ("get.sh");
	$fp = fopen($f , "w");
	fputs($fp , "$dump");
	fclose($fp);

	//exec("get.sh");
	//for($i=0;$i<$count;$i++)
//	echo "<audio id=1 src=\"h.mp3\" controls autoplay>check</audio>";
	//echo "<button onclick=\"play($count)\">play</button>";
	
}
else{

 echo "<form action=\"\" method=\"GET\">
   text:<textarea name=\"msg\" ></textarea><br />
  
   <input type=\"submit\">
  </form>";
  }

