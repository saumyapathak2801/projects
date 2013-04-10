<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
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
	margin-top:120px;
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

/* 右图像，左裁剪 */
.mask1 .prog {
    -webkit-mask-image: -webkit-linear-gradient(left, #000 100px, transparent 100px);
}

/* 右裁剪 */
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

function progress(num) {
    num=100;
    sec = 150;
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
</head>
<body>
<div class="topnav">
<?php 
if(!isset($_SESSION['user']))
{
echo "<a href='login.php' class='topnav'>Login</a> <a href='sign_up.php' class='topnav'>Sign Up</a>";
}
?>
<?php 
if (isset($_SESSION['user']))
{
echo "<a href='logout.php' class='topnav'>Logout</a>";
}
?>
</div>
<span class="outer" >
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
<span id="tracktime">0/0</span>
<?php /*for($i=2;$i>0;$i--)
{
echo $i;
echo '
<audio id="song" ontimeupdate="tim()">
<source src="'.$i.'.mp3" type="audio/mp3"><source src="music.ogg" type="audio/ogg">
<embed height="100" width="100" src="music.mp3">
</audio>';
sleep(5);
}*/
?>
<?php //echo tim();?>

<?php echo "<script type='text/javascript'>tim()</script>";?>
<button href="" class="rb play" onclick="progress();plays();"></button>
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