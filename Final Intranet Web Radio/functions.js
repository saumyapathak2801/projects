var trial=1,current=0;
var list1=new XMLHttpRequest();
	list1.open("POST","songs.txt",false);
list1.send();
var list=list1.responseText.split(' ');
var server=100,incre;
if(getip()=="127.0.0.1")server=1;
else server=0;
server=1;
//document.getElementById("myDiv2").innerHTML=list[1];
function fetchtitle(id){
var title=new XMLHttpRequest();
title.onreadystatechange=function()
  {
  if (title.readyState==4 && title.status==200)
    {
    document.getElementById("title").innerHTML=title.responseText;
    }
  }
		title.open("GET","gettitle.php?q="+id,true);
title.send();

}
function loadXMLDoc()
{
 

//document.getElementById("my1").innerHTML=list[1]+" trial="+trial+" server="+server;
if(current>list[0])return; //last  song played

if(trial==1){
var song=new XMLHttpRequest();
	song.open("POST","currentsong.txt",false);
song.send();
current=song.responseText;

}
else current++;

if(server&&trial>1){
incre=new XMLHttpRequest();
	incre.open("GET","incresong.php?q="+current,true);
incre.send();
}
/*rat=new XMLHttpRequest();
	rat.open("GET","ratesong.php?id="+list[current],true);
rat.send();*/

var xmlhttp,servertime,seek;

xmlhttp=new XMLHttpRequest();
	xmlhttp.open("POST","time.txt",false);
xmlhttp.send();

servertime=new XMLHttpRequest();
	servertime.open("POST","gettime.php",false);
servertime.send();
if(trial==1){
seek=servertime.responseText-xmlhttp.responseText;
}
else seek=0;
var num=soundManager.getSoundById(list[current]).durationEstimate/1000;

document.getElementById("myDiv2").innerHTML="status="+server+"  trial="+trial+"  current="+current+"  seek="+seek+" song="+list[current]+" duration="+num;
document.getElementById("myDiv3").innerHTML="server time="+servertime.responseText+"  start time="+xmlhttp.responseText+" total="+list[0];
//if(current==1)seek=num-15;
//seek=num-15;

var jump=seek*1000;
var next=++current;
current--;

document.getElementById("my1").innerHTML="jump="+jump+" server="+server+ " next="+next;

//soundManager.setPosition(list[current],jump);
//jump=25000;
soundManager.play(list[current],{
 from: jump,
 to: num*1000,
  onfinish: function() {
    loadXMLDoc();
  },
  onstop: function() {
    loadXMLDoc();
  }
  //whileplaying: function() {
  // Move 256 absolutely-positioned 1x1-pixel DIVs, for example (ugly, but works)
  //var gPixels = document.getElementById('graphPixels').getElementsByTagName('div');
  //var gScale = 32,x=0; // draw 0 to 32px from bottom
  //for (var i=0; i<256; i++) {
   // graphPixels[i].style.top = (32-(gScale+Math.ceil(this.waveformData.left[i]*gScale)))+'px';
  // x=x+soundManager.getSoundById(list[current]).eqData.left[0];
  //}
  //document.getElementById("my2").innerHTML="x="+x;
//}
});

fetchtitle(list[current]);
if(current!=list[0]){
soundManager.createSound({
      id: list[next],
      url: "upload/"+list[next]+'.mp3',
	  autoLoad: true,
	 autoPlay: false
    });
}
trial++;
		var fl1=0;
	if(num==0){soundManager.getSoundById(list[current]).load();fl1=1;}
	
	var fl=0,k,zl=1,zr=-1,seek1=seek,zone=1,z=0;
			if(seek>num/2){seek=seek-num/2;fl=1;}
	
	
	
	if(seek==0)zone=9;
	else zone=num/seek;
	
	if(zone>8)z=1;
	
	else if(zone<8&&zone>4)z=2;
	else if(zone<4&&zone>2.6)z=3;
	else if(zone<2.6&&zone>2)z=4;
	else z=5;
	if(zone==0){};
	if(seek!=0)if(z==1&&seek>5)z=2;
	if(fl)zr=15,zl=20+z;
	else zr=10+z,zl=21;
	if(fl1){
	fl=0,k,zl=1,zr=-1,seek1=seek,zone=1,z=0;
	num=soundManager.getSoundById(list[current]).durationEstimate/1000;
		if(seek>num/2){seek=seek-num/2;fl=1;}
			if(seek==0)zone=9;
	else zone=num/seek;
	
	if(zone>8)z=1;
	
	else if(zone<8&&zone>4)z=2;
	else if(zone<4&&zone>2.6)z=3;
	else if(zone<2.6&&zone>2)z=4;
	else z=5;
	if(zone==0){};
	if(seek!=0)if(z==1&&seek>5)z=2;
	if(fl)zr=15,zl=20+z;
	else zr=10+z,zl=21;
	
	}
	print(zl,zr);
  progress(num,zl,zr,seek1,zone);
  //document.getElementById("my1").innerHTML="in load zl="+zl+" zr="+zr;	
//return;

if(current==2)func(seek,num);

}
function func(seek,num){
var s;
s=seek;
if(s!=0){s=1465/num*seek;}


document.getElementById("style").innerHTML="div.ex{width:5px;height:5px;background:red;position:relative;animation-name:mymove;animation-duration:5s;/* Safari and Chrome */-webkit-animation-name:mymove;-webkit-animation-duration:314.13s;/* Safari and Chrome */-webkit-animation-timing-function:linear;@keyframes mymove{from {left:"+s+"px;}to {left:1465px;}}@-moz-keyframes mymove /* Firefox */{from {left:0px;}to {left:200px;}}@-webkit-keyframes mymove /* Safari and Chrome */{from {left:"+s+"px;}to {left:1465px;}}";


document.getElementById("animate").innerHTML="<b>||</b>";
document.getElementById("animate").setAttribute("class", "ex");

}

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


require('fs');
var sec = 1;
function delay(num) {
aa.play();
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
//document.getElementById("myDiv4").innerHTML="aaa "+aa.duration;	
}
function seek1(seek,aa){
var i;
for(i=0;i<100000;i++);
aa.currentTime=10;
aa.play();
}
function delay() {

    var num=100;
    var sec = 150;
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
        right.style.cssText = "-webkit-transition-duration:1s; -webkit-transform:rotate(40deg)";
        left.style.cssText = "-webkit-transition-delay:0s; -webkit-transition-duration:0s; -webkit-transform:rotate(60deg)";   
		 right.style.cssText = left.style.cssText = startMask.style.cssText = endMask.style.cssText = "";
    
    }
    endMask.style.cssText = "-webkit-transition-duration:"+sec+"s; opacity:1; -webkit-transform:rotate(" + ang + "deg)";  
//document.getElementById("myDiv4").innerHTML="aaa "+aa.duration;	
}
function progress(num,zl,zr,seek,zone) {
	//num=292;
	//document.getElementById("my2").innerHTML="aaa zl="+zl+" zone="+zone;
	var mid=num/2;
    sec = 150;
    var right = document.querySelector('.mask'+zr+' .prog'),
        left = document.querySelector('.mask'+zl+' .prog'),
        startMask = document.getElementsByClassName('start_mask')[0],
        endMask = document.getElementsByClassName('end_mask')[0],
        text = document.getElementById('text');
        ang = 360 ;
  //  console.log(ang, ang - 180);
    startMask.style.cssText = "opacity:1";
    var i = 0,
        m = setInterval(function(){if(i >= num) clearInterval(m);i++;/*text.textContent = (i++)+'%';*/}, 1000);
		var langle=180-(zr-11)*45,rangle=180;
        var rightTime = mid-seek,
            leftTime = mid;
		if(zr!=15)
        right.style.cssText = "-webkit-transition-duration:"+rightTime+"s; -webkit-transform:rotate("+langle+"deg)";
		else leftTime = num-seek,rightTime=0,rangle=180-(zl-21)*45;
        left.style.cssText = "-webkit-transition-delay:"+rightTime+"s; -webkit-transition-duration:"+leftTime+"s; -webkit-transform:rotate(" + rangle + "deg)";   
    
 
    endMask.style.cssText = "-webkit-transition-duration:"+sec+"s; opacity:1; -webkit-transform:rotate(" + ang + "deg)";  
document.getElementById("my").innerHTML="aaa zl="+zl+" zr="+zr+" langle="+langle+" rangle="+rangle+" rtimeleft="+rightTime+" ltimeleft="+leftTime+" num="+num;	
}

function reset(){
    var right = document.querySelector('.mask1 .prog'),
        left = document.querySelector('.mask2 .prog'),
        startMask = document.getElementsByClassName('start_mask')[0],
        endMask = document.getElementsByClassName('end_mask')[0];
    right.style.cssText = left.style.cssText = startMask.style.cssText = endMask.style.cssText = "";
    document.getElementById('text').textContent = "0%";
}

function resetserver(){
var incre=new XMLHttpRequest();
	incre.open("POST","reset.php",false);
	incre.send();
	}
function print(zl,zr){

document.getElementById("bar").innerHTML="<span class=\"outer\" style=\"margin-left:350px;margin-top:-480px;opacity:1\"  ><div id=\"bb\"><span><button  id=\"bbb\" href=\"\" class=\"rb mute\" onclick=\"mute()\" style=\"position:absolute;height:140px;width:140px;border-radius:70px;margin-left:30px;margin-top:30px;\"><b>Welcome to Radio!</b></button></span></div><span class=\"end_mask\" style=\"\"></span><span class=\"start_mask\" style=\"\"></span> <span class=\"mask"+zr+"\"><span class=\"prog\" style=\"\"></span></span><span class=\"mask"+zl+"\"><span class=\"prog\" style=\"\"></span></span><span class=\"circle\"></span>";
}
function mute(){
//soundManager.toggleMute();
soundManager.mute();
document.getElementById("bb").innerHTML="<span><button  href=\"\" class=\"rb unmute\" onclick=\"unmute()\" style=\"position:absolute;height:140px;width:140px;border-radius:70px;margin-left:30px;margin-top:30px;\"><b>Welcome to Radio!</b></button></span>";

}
function unmute(){
soundManager.unmute();
document.getElementById("bb").innerHTML="<span><button  href=\"\" class=\"rb mute\" onclick=\"mute()\" style=\"position:absolute;height:140px;width:140px;border-radius:70px;margin-left:30px;margin-top:30px;\"><b>Welcome to Radio!</b></button></span>";


}

