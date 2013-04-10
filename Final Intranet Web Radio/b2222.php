<?php include 'load.php'; ?>
<!DOCTYPE HTML>
<?php

session_start();
require("res/config.php");
if(isset($_SESSION['user'])) {
	if($_SESSION['user']=="abhishek.kumar@students.iiit.ac.in"){
		echo " <div>";
		
		//<!-- hitwebcounter Code START -->
echo "<a href=\"http://www.hitwebcounter.com/\" target=\"_blank\">
	<img src=\"http://hitwebcounter.com/counter/counter.php?page=4833476&style=0007&nbdigits=5&type=page&initCount=0\" title=\"\" Alt=\"\"   border=\"0\" ></a>";
	echo "</div>";
	}

	else{
		echo " <div style=\"display:none;\">";
		//<!-- hitwebcounter Code START -->
echo "<a href=\"http://www.hitwebcounter.com/\" target=\"_blank\">
	<img src=\"http://hitwebcounter.com/counter/counter.php?page=4833476&style=0007&nbdigits=5&type=page&initCount=0\" title=\"\" Alt=\"\"   border=\"0\" ></a>";
		echo "</div>";
	}
	//return;
}

else{
		echo " <div style=\"display:none;\">";
		//<!-- hitwebcounter Code START -->
echo "<a href=\"http://www.hitwebcounter.com/\" target=\"_blank\">
	<img src=\"http://hitwebcounter.com/counter/counter.php?page=4833476&style=0007&nbdigits=5&type=page&initCount=0\" title=\"\" Alt=\"\"   border=\"0\" ></a>";
		echo "</div>";
	}
?>
<html>
<head>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>

  


<!--
<script src="jquery.js"></script>

<script src="functions.js"></script>
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

<script>


function getip(){
    var ip = "<?php echo $_SERVER['SERVER_ADDR']; ?>";
    return ip;
}

</script>-->
 <title>IIIT Radio...your music, your beat!</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <!-- stylesheets -->
  <link rel="stylesheet" type="text/css" href="style2.css">
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/colour1.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <style type="text/css">
  body { 
  background-color:black;
  }

<!--#a{
background-color:#8ADE23;
}
.bar {
    background-color:#73776F;
    width:35px;
    height:150px;
    display: inline;
    
}
.eq {
	margin-left:100px;
	margin-top:0px;
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
    background-image: -webkit-radial-gradient(circle, #fff 60px, #73776F 85px, #333530 100px);
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
    background-image: -webkit-radial-gradient(circle, #fff 60px, #8ADE23 80px, #8ADE23 96px); 
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
}-->
</style>
<body >
   


<body style="background-color:black;">

<img src="images/i1.JPG" style="margin-left:550px;margin-top:-20px;height:630px;"/>
  <div id="main" style="background-color:black;">
      <div id="logo" style="margin-left:-550px;margin-top:-600px;"><h1>IIIT<a href="#">Radio</a></br><div style="margin-left:170px;">..your music..your beat!</div></h1></div>
     	</br>
		<!--<center><div id="title" style="color: white;" class="title">sfssfsf<br/></div></center>-->
		<nav style="margin-top:-600px;width:100px;margin-right:150px;">
        <ul class="sf-menu" id="nav">
          <li class="selected"><a href="indextemp.php">Home</a></li>
          
        </ul>
      </nav>
<!--<img src="tiles/images/medium/2.jpg" /> -->
<!--<div style="margin-top:-500px"><?php// include 'tiles.php'; ?></div>
<div style="margin-top:-20px;margin-left:190px;">-->
<div style="top: -460; left: 58%;margin-left: -370px; width: 661px; height: 378px; position: relative; z-index: 1; visibility: show;"> 

<div style="margin-left:1000px;" id="myElement" >Loading the player...</div></div>

   <script type="text/javascript">
       jwplayer("myElement").setup({
	       file: "http://10.4.2.27:8000/mpd.mp3",
//		       width:'560',
//		       height: '24',
		        image: "jwplayer/legends.jpg",
		     //  controlbar: 'bottom',
//		       plugins: {'revolt-1': {} },

		       events: {
			       onPause: function() {
				       jwplayer().stop();
			       }
			       }
		       
                                          });
</script>
  <?php $date=date("Y-m-d"); echo $date; ?>
<div id="audio">audio</div><div id="audio1">audio1</div>
<div id="myDiv1"></div><div id="myDiv2">mydiv2</div><div id="myDiv3"></div><div id="my1">my1</div><div id="my2">my2</div></div><div id="my">duration22</div>
<?php
/*$read=("rate.txt");
$fp=fopen($read,"r");
$id=fgets($fp);
fclose($fp);
$rater_id=$id;
//echo "<p style=\"color:white;\">$id</p>";
$rater_item_name='Item 1';
include("rater.php");*/
?>
<div class="eq" style="margin-top:-150px;margin-left:0px;">
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
