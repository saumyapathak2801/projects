

<!DOCTYPE HTML>
<?php

session_start();
require("res/config.php");
if(!isset($_SESSION['user']) || $_SESSION['fac']!=0){die("Permission denied");}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
function fill(){
	if(document.getElementById("click").value==0){
		document.getElementById("100").innerHTML="";
		document.getElementById("101").innerHTML="";
		document.getElementById("click").value=1;
		return;
		}
	document.getElementById("100").innerHTML="<p style=\"font: 200% 'trebuchet ms', arial, sans-serif;color:green;\">Announcement:</p>";
	document.getElementById(101).innerHTML="<textarea name=\"msg\" id=\"msg\" style=\"border-radius:0px;background:black;font-color:black;width:600px;font-size:20px;\" rows=\"5\" cols=\"100\"></textarea>";
	document.getElementById("click").value=0;
}
function submitt(){
//alert("First name must be filled out");
//	return false;
	//	document.write("Hello World!");
	if(isset($_GET['upl']))
	{
	if(document.getElementById("click").value==0){
		//alert(document.getElementById("msg").value);
		var i=new XMLHttpRequest();
		i.open("POST","speech2.php",false);
		i.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		i.send("msg="+document.getElementById("msg").value+"&date=<?php echo $_GET['date']; ?>");
//		i.open("GET","speech2.php?msg="+document.getElementById("msg").value);
	//	i.send();
	}
	}
//		return false;


}
</script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIIT Radio...</title>
<link href="calendar.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <!-- stylesheets -->
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/colour_calendar.css" rel="stylesheet" type="text/css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>
  <style type="text/css">

</style>
</head>

<body>
<div id="main">

    <!-- begin header -->
    <header>
      <div id="logo" ><h1 style="margin-left:-1000px;">IIIT<a href="#">Radio</a></br><div style="margin-left:170px;">..your music..your beat!</div></h1></div>
      <nav style="margin-top:-60px;width:100px;margin-right:-80px;">
        <ul class="sf-menu" id="nav"">
          <li class="selected"><a href="indextemp.php">Home</a></li>
          
        </ul>
      </nav>
    </header>
    <!-- end header -->

  </div>

<form action="upload_song.php" method="POST" enctype="multipart/form-data" class="form_settings" >

<?php if(isset($_GET['upl']) && $_GET['upl']==1){
echo "<h1 style=\"text-align:center;\">Song uploaded successfully</h1>";unset($_GET['upl']);
}?>
<table class="table" style="margin-left:450px;margin-top:-70px;font: 250% 'trebuchet ms', arial, sans-serif;color:white;">
<tr class="table"><td class="table"><label for="title">Title:</label></td><td><input type="text" name="title"/></td></tr>
<br/>
<br/>
<tr class="table"><td class="table">
<label for="artist">Artist:</label></td><td><input type="text" name="artist"/></td></tr>
<br/><br/>
<tr class="table"><td class="table">
</td><td><input type="hidden" name="date" value="<?php echo $_GET['date']?>"/ type="hidden"></td></tr>
<br/><br/>
<tr class="table"><td class="table">
<label for="album">Album:</label></td><td><input type="text" name="album"/></td></tr>
<br/><br/>
<tr class="table">
<td class="table"><label for="file">Filename:</label></td>
<td class="table"><input type="file" name="file" id="file"/></td></tr>
</table>
<br/>
<input type="hidden" value=1 name="click" id="click"/>
<input type="button" class="submit" value="Add announcement" style="margin-left:500px;width:150px;" onclick="fill()"><br/><br/>
<div style="margin-left:650px;" id="msgg">
<div id="100"></div>
<div id="101"></div>

</div> <br/>

<input type="submit" name="submit" value="Upload" class="submit" style="margin-left:500px;" />
</form>
<div style="visibility:hidden;margin-top:-200px;">
  <div  id="myElement">Loading the player...</div></div>
 
     <script type="text/javascript">
         jwplayer("myElement").setup({
                 file: "http://10.4.2.27:8000/mpd.mp3",
                  //     width:'560',
                   //   height: '24',
                         //
                         autostart:"true",
                          image: "jwplayer/legends.jpg",
                     //    controlbar: 'bottom',
  //                     plugins: {'revolt-1': {} },
  
                         events: {
                                 onPause: function() {
                                         jwplayer().stop();
                                 }
                                 }
                         
                                            });
 </script>

<p style="margin-left:950px;margin-top:100px;font-size:20px;"> Copyright &copy; <a href='http://iiit.ac.in'>IIIT-H</a></p>
</body>



</html>
