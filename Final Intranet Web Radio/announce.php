

<!DOCTYPE HTML>
<?php

session_start();
require("res/config.php");
?>

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

<form action="upload_song.php" method="POST" enctype="multipart/form-data" class="form_settings">
<table class="table" style="margin-left:500px;margin-top:-70px;font: 250% 'trebuchet ms', arial, sans-serif;color:black;">
<tr class="table"><td class="table"><label for="title">Title:</label></td><td><input type="text" name="title"/></td></tr>
<br/>
<br/>
<tr class="table"><td class="table">
<label for="artist">Artist:</label></td><td><input type="text" name="artist"/></td></tr>
<br/><br/>
<tr class="table"><td class="table">
</td><td><input type="date" name="date"/></td></tr>
<br/><br/>
<tr class="table"><td class="table">
<label for="album">Album:</label></td><td><input type="text" name="album"/></td></tr>
<br/><br/>
<tr class="table">
<td class="table"><label for="file">Filename:</label></td>
<td class="table"><input type="file" name="file" id="file"/></td></tr>
</table>
<br/>
<input type="submit" name="submit" value="Upload" class="submit" style="margin-left:660px;"/>
</form>
</body>



</html>
