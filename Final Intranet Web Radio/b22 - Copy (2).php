<?php
   $x=("songlist.txt");
	$list=file($x);
	$y=("lock.txt");
	$list2=file($y);
  	if($_SERVER['SERVER_ADDR']=="127.0.0.1")$server=1;
	else $server=0;
	$z=("songs.txt");
	$list3=file($z);
	//for($i=1;$i<=1;$i++)
	//{}
//	if($i!=3){echo "<audio id=".$i." src=".$list[$i]." controls ></audio>";echo $list[$i]."<br/>";}
	//if(($server&&$i==$list3[0])||($server&&$i==1)||(!$server&&$i==$list3[0])) echo "<audio id="."\"".$i."\""." src=".$list[$i]." controls  ></audio>";//echo $list[$i]."<br/>";
	//else if($i>1) echo "<audio id="."\"".$i."\""." src=".$list[$i]."  controls preload=\"none\"></audio>";
	// echo $list[$i];
	
	
$count_my_page1 = ("lock.txt");
$count_my_page2 = ("time.txt");
$lock1 = file($count_my_page1);
$count_my_page3 = ("songs.txt");
$start1=file($count_my_page3);
$start = explode("\n",$start1[0]);

	if($server) echo "<button type=\"button\" onclick=\"resetserver()\">RESET</button>";
if($server&&$lock1[0]==0){

$fp = fopen($count_my_page1 , "w");
fputs($fp , 1);
fclose($fp);

$fp = fopen($count_my_page2 , "w");
$t=time();
fputs($fp , "$t");
fclose($fp);
}
 echo"<script src=\"sm2/script/soundmanager2.js\"></script>
	<script>
	soundManager.setup({
  url: 'sm2/swf/',
  useHTML5Audio: true,
  useHighPerformance: true,
   onready: function() {
    var mySound = soundManager.createSound({
      id: ".$start[0].",
      url: ".$start[0].",
	   autoPlay: false,
	   autoLoad: true
    });
    //mySound.play();
  },
  
	debugmode: false
  });
	</script>";




 ?>
<html>
<head>
  <head>

<link rel="stylesheet" type="text/css" href="style2.css">

<script src="jquery.js"></script>

<script src="functions.js"></script>
<script>
var trial=1,current=1;
var list1=new XMLHttpRequest();
	list1.open("POST","songlist.txt",false);
list1.send();
var list=list1.responseText.split('\'');


function loadXMLDoc()
{
if(current>3)return;


//delay();
//for(i=0;i<100000;i++);
//delay();
var server=100,incre;
if(getip()=="127.0.0.1")server=1;
else server=0;
var song=new XMLHttpRequest();
	song.open("POST","songs.txt",false);
song.send();
var currentsong=song.responseText.split('\'')[1];


//current++;
	//if(trial%2)document.getElementById("audio").innerHTML="<audio id=\""+current+"\" src=\""+current+".mp3\"   ></audio>"+"  current= "+current;
	//else document.getElementById("audio1").innerHTML="<audio id=\""+current+"\" src=\""+current+".mp3\"   ></audio>"+"  current= "+current;
var xmlhttp,servertime;
//current--;
xmlhttp=new XMLHttpRequest();
	xmlhttp.open("POST","time.txt",false);
xmlhttp.send();

servertime=new XMLHttpRequest();
	servertime.open("POST","gettime.php",false);
servertime.send();
if(server){
incre=new XMLHttpRequest();
	incre.open("GET","incresong.php?q="+current,true);
incre.send();
}
//document.getElementById("myDiv1").innerHTML="server start time="+xmlhttp.responseText*1000;
//var mediaElement = document.getElementById(currentsong);

var seek=servertime.responseText-xmlhttp.responseText;
//mediaElement.load();
if(trial>1)seek=0;
var num=soundManager.getSoundById(currentsong).durationEstimate/1000;
//mediaElement.play();
//document.getElementById("myDiv2").innerHTML=xmlhttp.responseText;
document.getElementById("myDiv2").innerHTML="status="+server+"  trial="+trial+"  current="+current+"  seek="+seek+" song="+current+" duration="+num;
document.getElementById("myDiv3").innerHTML="server time="+servertime.responseText+"  start time="+xmlhttp.responseText+ "currentsong="+currentsong;


//document.getElementById("myDiv4").innerHTML=mediaElement.duration;
//mediaElement.oncanplay=function(){document.getElementById("myDiv4").innerHTML="nonoonoon";}

//if(current==1)seek=250;
trial++;
//mediaElement.currentTime =seek;
//play22(currentsong);
var bb='raaz.mp3',cc=currentsong,jump=seek*1000;
document.getElementById("my1").innerHTML="currentsong="+cc+'a'+"  jump="+jump;
soundManager.setPosition(cc,jump);

soundManager.play(cc,{
  onfinish: function() {
    loadXMLDoc();
  }
});
current++;
soundManager.createSound({
      id: list[2*current-1],
      url: list[2*current-1],
	  autoLoad: true,
	 autoPlay: false
    });
	var fl=0,k,zl=1,zr=-1,seek1=seek;
			if(seek>num/2){seek=seek-num/2;fl=1;}
	var zone=1,z=0;
	if(seek==0)zone=9;
	else zone=num/seek;
	if(zone>8)z=1;
	else if(zone<8&&zone>4)z=2;
	else if(zone<4&&zone>2.6)z=3;
	else if(zone<2.6&&zone>2)z=4;
	else z=5;
	if(seek!=0)if(z==1&&seek>5)z=2;
	if(fl)zr=15,zl=20+z;
	else zr=10+z,zl=21;
	print(zl,zr);
  progress(num,zl,zr,seek1);
  document.getElementById("my1").innerHTML="in load zl="+zl+" zr="+zr;	

}
</script>
</head>
<body ><script>document.write("<p>This is a paragraph</p>");</script>
   

<button onclick="playy()">play</button>
<button onclick="soundManager.play('22.mp3')">progress</button>
-----------------------------------------------------------------------------------------------------------

<div class="topnav" id="bar">
<span class="outer" >
     <span><button href="" class="rb play" onclick="loadXMLDoc()">Start listening!</button></span>
   <span class="end_mask" style=""></span>
    <span class="start_mask" style=""></span> 
    <span class="mask10">
        <span class="prog" style=""></span>
    </span>
    <span class="mask20">
        <span class="prog" style=""></span>        
    </span>
    <span class="circle">
    </span>


</div>
  
<div id="audio">audio</div><div id="audio1">audio1</div>
<div id="myDiv1"></div><div id="myDiv2"></div><div id="myDiv3"></div><div id="my1">z in load</div></div><div id="my">duration22</div>

<div class="eq">
    <span class="bar"></span>
    <span class="bar" id="a"></span>
    <span class="bar"></span>
    <span class="bar" id="a"></span>
    <span class="bar"></span>
	<span class="bar" id="a"></span>
	<span class="bar"></span>
	<span class="bar" id="a"></span>
	<span class="bar"></span>
	<span class="bar" id="a"></span>
	<span class="bar"></span>
	<span class="bar" id="a"></span>
	<span class="bar"></span>
	<span class="bar" id="a"></span>
	<span class="bar"></span>
	<span class="bar" id="a"></span>
	<span class="bar"></span>
	<span class="bar" id="a"></span>
	<span class="bar"></span>
	<span class="bar" id="a"></span>
</div>



</body>
</html>