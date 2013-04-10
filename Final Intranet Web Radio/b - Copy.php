<?php
   $x=("songlist.txt");
	$list=file($x);
   for($i=1;$i<=$list[0];$i++)
	{
//	if($i!=3){echo "<audio id=".$i." src=".$list[$i]." controls ></audio>";echo $list[$i]."<br/>";}
	 echo "<audio id="."\"".$i."\""." src=".$list[$i]." controls ></audio>";//echo $list[$i]."<br/>";
	 echo $list[$i];
	}
$count_my_page1 = ("lock.txt");
$count_my_page2 = ("time.txt");
$count_my_page3 = ("songlist.txt");
$lock1 = file($count_my_page1);
if($lock1[0]==0){

$fp = fopen($count_my_page1 , "w");
fputs($fp , "1");
fclose($fp);

$fp = fopen($count_my_page2 , "w");
$t=time();
fputs($fp , "$t");

}
 ?>
<html>
<head>
   <title>Website Hits</title>
</head>
<body><script>document.write("<p>This is a paragraph</p>");</script>
   
<script>

function loadXMLDoc()
{
var xmlhttp,song;
xmlhttp=new XMLHttpRequest();
	xmlhttp.open("POST","time.txt",false);
xmlhttp.send();
song=new XMLHttpRequest();
	song.open("POST","songs.txt",false);
song.send();
document.getElementById("myDiv1").innerHTML="server start time="+xmlhttp.responseText*1000;
var mediaElement = document.getElementById(1);

var t = new Date();

document.getElementById("myDiv").innerHTML=t.getTime();
var seek=((t.getTime()-(xmlhttp.responseText*1000))/1000);
if(seek>4)seek=seek-4;
else if(seek>5)seek=seek-5;
else if(seek>6)seek=seek-6;
document.getElementById("myDiv2").innerHTML=seek;
document.getElementById("myDiv3").innerHTML="song="+song.responseText;
mediaElement.currentTime = seek;
mediaElement.play()



}
</script>

-----------------------------------------------------------------------------------------------------------







  <button onclick="document.getElementById('demo').play()">Play the Audio</button>
  <button onclick="document.getElementById('demo').pause()">Pause the Audio</button>
  <button onclick="document.getElementById('demo').volume+=0.1">Increase Volume</button>
  <button onclick="document.getElementById('demo').volume-=0.1">Decrease Volume</button>
<button type="button" onclick="myFunction()">Try it</button>




<button type="button" onclick="loadXMLDoc()">Request data</button>
<div id="myDiv1"></div>
<div id="myDiv"></div>
<div id="myDiv2"></div><div id="myDiv3"></div>




</body>
</html>