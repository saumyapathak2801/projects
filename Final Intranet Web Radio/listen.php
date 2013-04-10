<!DOCTYPE HTML>
<?php
   $x=("songlist.txt");
	$list=file($x);
	$y=("lock.txt");
	$list2=file($y);
   for($i=1;$i<=1;$i++)
	{
//	if($i!=3){echo "<audio id=".$i." src=".$list[$i]." controls ></audio>";echo $list[$i]."<br/>";}
	if($list2[0]==0) echo "<audio id="."\"".$i."\""." src=".$list[$i]." controls ></audio>";//echo $list[$i]."<br/>";
	else  echo "<audio id="."\"".$i."\""." src=".$list[$i]."   ></audio>";
	// echo $list[$i];
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
<?php

session_start();
require("res/config.php");
?>
<head>
  <title>PhotoArtWork2_reverse</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <!-- stylesheets -->
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/colour1.css" rel="stylesheet" type="text/css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <style type="text/css">
  body { 
  background-color:black;
  }

#a{
background-color:#A30052;
}
.bar {
    background-color:#14000A;
    width:35px;
    height:150px;
    display: inline;
    vertical-align: bottom;
}
.eq {
	margin-left:500px;
	margin-top:100px;
}
body{
    background-color:#ccc; 
    padding: 20px;
}
.outer {
    position:relative;
	margin-left:550px;
	top:5px;
    display:block;
    width: 200px;
    height:200px;
    background-color:black;
    border-radius:100px;
    padding:5px
}

.inner {
    position: absolute;
    z-index: 9;
    display:block;
    width: 140px;
    height:140px;
    background-color: black;
    border-radius: 70px;
    margin: 30px;
    box-shadow: 0px 2px 3px #333;
    
}

#text {
    display:block;
    width: 100%;
    text-align: center;
    line-height: 140px;
    font-family: Helvetica;
    font-size: 40px;
    color: #4B4F58;    
}

.circle {
    position: absolute;    
    top: 0;
    left:0;
    margin: 5px;
    z-index: 1;
    display: block;
    float: left;
    width: 200px;
    height: 200px;
    border-radius: 100px;
    background-image: -webkit-radial-gradient(circle, #fff 60px, #14000A 85px, #1F000A 100px);
}

.start_mask {
    display: block;
    width: 100px;
    height: 100px;
    background-image: -webkit-linear-gradient(right, transparent 95px, rgba(65,157,34,0.2) 100px, transparent 100px);
    position: absolute;
    top:5px;
    left:105px;
    z-index: 10;
    background-size: 100px 30px;
    background-repeat: no-repeat;
    opacity:0;
    
}    
.end_mask {
    display: block;
    width: 100px;
    height: 100px;
    background-image: -webkit-linear-gradient(left, transparent 95px, rgba(65, 157, 34, 0.2) 100px);
    position: relative;
    z-index: 10;
    background-size: 100px 30px;
    background-repeat: no-repeat;
    -webkit-transform-origin: right bottom;    
    opacity:0; 
    -webkit-transition-timing-function: linear;
}


/* for right */
.mask1 {    
    position: absolute;
    top:0;
    left:0;
    margin: 5px;
    z-index:2;
    display:block;
    width:200px;
    height:200px;
    -webkit-mask-image: -webkit-linear-gradient(left, transparent 100px, #000 100px); 
    
}

/* for left  */
.mask2 {    
    position:absolute;
    top:0;
    left:0;
    margin: 5px;    
    z-index:2;
    display:block;
    width:200px;
    height:200px;
    -webkit-mask-image: -webkit-linear-gradient(left, #000 100px, transparent 100px);     
}

.prog {
    display: block;    
    float: left;
    width: 200px;
    height: 200px;
    border-radius: 100px;
    background-image: -webkit-radial-gradient(circle, #fff 60px, #990099 80px, #FF1975 96px); 
    -webkit-transition-timing-function: linear;
}

/* ???,??? */
.mask1 .prog {
    -webkit-mask-image: -webkit-linear-gradient(left, #000 100px, transparent 100px);
}

/* ??? */
.mask2 .prog {
    -webkit-mask-image: -webkit-linear-gradient(left, transparent 100px, #000 100px);
}




#image
{
margin-left:280px;
height:610px;
border-radius:30px;
}
.rb
{
height:40px;
width:40px;
-moz-border-radius:20px;
border-radius:20px;
}
.play:before
{
content:"\25B6";
}
</style>
<script src="jquery.js"></script>
<script>
function fluctuate(bar) {
    var hgt = Math.random() * 100;
    hgt += 1;
    var t = hgt * 3;
    
    bar.animate({
        height: hgt
    }, t, function() {
        fluctuate($(this));
    });
}
$(document).ready(
function bars()
{
$("button").click(function bars()
{
$(".bar").each(function(i) {
    fluctuate($(this));
});
});
});
</script>
<script type="text/javascript">//<![CDATA[ 
require('fs');
var sec = 1;

function progress(sec) {
    num=100;
  //  sec = 150;
    var right = document.querySelector('.mask1 .prog'),
        left = document.querySelector('.mask2 .prog'),
        startMask = document.getElementsByClassName('start_mask')[0],
        endMask = document.getElementsByClassName('end_mask')[0],
        text = document.getElementById('text');
        ang = 360 * ( num / 100 );
    console.log(ang, ang - 180);
    startMask.style.cssText = "opacity:1";
    var i = 0,
        m = setInterval(function(){if(i >= num) clearInterval(m);i++;/*text.textContent = (i++)+'%';*/}, sec*1000/num);
   if(num > 0 && num <= 50){
        right.style.cssText = "-webkit-transition-duration:"+sec+"s; -webkit-transform:rotate(" + ang + "deg)";
    }
    else if(num > 50 && num <= 100) {
        var rightTime = 50 * sec / num,
            leftTime = (num-50)* sec/num;
        right.style.cssText = "-webkit-transition-duration:"+rightTime+"s; -webkit-transform:rotate(180deg)";
        left.style.cssText = "-webkit-transition-delay:"+rightTime+"s; -webkit-transition-duration:"+leftTime+"s; -webkit-transform:rotate(" + (ang-180) + "deg)";   
    
    }
    endMask.style.cssText = "-webkit-transition-duration:"+sec+"s; opacity:1; -webkit-transform:rotate(" + ang + "deg)";    
}

function reset(){
    var right = document.querySelector('.mask1 .prog'),
        left = document.querySelector('.mask2 .prog'),
        startMask = document.getElementsByClassName('start_mask')[0],
        endMask = document.getElementsByClassName('end_mask')[0];
    right.style.cssText = left.style.cssText = startMask.style.cssText = endMask.style.cssText = "";
    document.getElementById('text').textContent = "0%";
}
</script>
<script>

function loadXMLDoc()
{
var xmlhttp,song,servertime;
xmlhttp=new XMLHttpRequest();
	xmlhttp.open("POST","time.txt",false);
xmlhttp.send();
song=new XMLHttpRequest();
	song.open("POST","songs.txt",false);
song.send();
servertime=new XMLHttpRequest();
	servertime.open("POST","gettime.php",false);
servertime.send();
//document.getElementById("myDiv1").innerHTML="server start time="+xmlhttp.responseText*1000;
var mediaElement = document.getElementById(1);

var t = new Date();

//document.getElementById("myDiv").innerHTML=t.getTime();
var seek=servertime.responseText-xmlhttp.responseText;
//document.getElementById("myDiv2").innerHTML=xmlhttp.responseText;
//document.getElementById("myDiv3").innerHTML=servertime.responseText;

mediaElement.currentTime = seek;
mediaElement.play()


progress(228);
}
</script>
</head>

<body style="background-color:black;">
<img src="images/i1.jpg" style="margin-left:550px;margin-top:-20px;height:630px;"/>
  <div id="main" style="background-color:black;">

    <!-- begin header -->
    <header>
      <div id="logo" style="margin-left:-160px;margin-top:-600px;"><h1>IIIT<a href="#">Radio</a></br>..your music..your beat!</h1></div>
     <!-- <nav style="margin-top:30px;">
        <ul class="sf-menu" id="nav">
          <li class="selected"><a href="index.html">home</a></li>
          <li><a href="about.html">about me</a></li>
          <li><a href="#">my portfolio</a>
            <ul>
              <li><a href="portfolio_one.html">portfolio_one</a></li>
              <li><a href="portfolio_two.html">portfolio_two</a></li>
            </ul>
          </li>
          <li><a href="blog.html">blog</a></li>
          <li><a href="contact.php">contact</a></li>
        </ul>
      </nav>
    </header>
    end header -->

    <!-- begin content -->
 <!--  <div id="site_content">-->

	</br>
	<span class="outer" style="margin-left:350px;margin-top:-480px;opacity:1">
    <span class="inner">
    </span>
   <span class="end_mask" style=""></span>
    <span class="start_mask" style=""></span> 
    <span class="mask1">
        <span class="prog" style=""></span>
    </span>
    <span class="mask2">
        <span class="prog" style=""></span>        
    </span>
    <span class="circle">
    </span>

</span>
<button href="" class="rb play" onclick="loadXMLDoc()"></button>
</br>
    <!--  <ul class="slideshow">
        <li class="show"><img width="950" height="450" src="images/home_1.jpg" alt="&quot;You can put a caption for your image right here&quot;" /></li>
        <li><img width="950" height="450" src="images/home_2.jpg" alt="&quot;You can put a description of the image here if you like, or anything else if you want.&quot;" /></li>
        <li><img width="950" height="450" src="images/home_3.jpg" alt="&quot;You can put a description of the image here if you like, or anything else if you want.&quot;" /></li>
      </ul>-->
  <!--  </div>-->
    <!-- end content -->

    <!-- begin footer -->
  <!--  <footer>
      <p>Copyright &copy; 2012 PhotoArtWork2_reverse. All Rights Reserved. <a href="http://www.css3templates.co.uk">Design from css3templates.co.uk</a>.</p>
      <p><img src="images/twitter.png" alt="twitter" />&nbsp;<img src="images/facebook.png" alt="facebook" />&nbsp;<img src="images/rss.png" alt="rss" /></p>
    </footer>-->
    <!-- end footer -->

  </div>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="js/jquery.sooperfish.js"></script>
  <script type="text/javascript" src="js/image_fade.js"></script>
  <!-- initialise sooperfish menu -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
</body>
</html>
