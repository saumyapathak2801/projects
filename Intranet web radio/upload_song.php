<?php

session_start();
require("res/config.php");
if(!isset($_SESSION['user'])){die("Permission denied");}
?>
<?php
$allowedExts = array("mp3", "mp4", "ogg");
$value=explode(".", $_FILES["file"]["name"]);
$extension = end($value);
echo $extension;
if (//($_FILES["file"]["type"] == "audio/mpeg")
//|| ($_FILES["file"]["type"] == "audio/x-mpeg")
// $_FILES["file"]["type"] == "audio/mp3"
//|| ($_FILES["file"]["type"] == "audio/x-mp3")

//&& ($_FILES["file"]["size"] < 20000)
 in_array($extension, $allowedExts)
 )
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      
	if (isset($_POST['title'],$_POST['artist'],$_POST['album']))
	{
	$_POST['title']=trim($_POST['title']);
	$_POST['artist']=trim($_POST['artist']);
	$_POST['album']=trim($_POST['album']);

	}
	//echo $_POST['user'],$_POST['passwd'];
	if(!empty($_POST['title']) && !empty($_POST['album']) && !empty($_POST['artist']) && isset($_POST['artist'],$_POST['title'],$_POST['submit']))
	{
	echo $_POST['date'];
	$chk=mysql_query("INSERT INTO songs (date,uploader,title,artist,type) VALUES('$_POST[date]','$_SESSION[user]','$_POST[title]','$_POST[artist]','song')");
	if(!$chk)
	{die("couldnt upload");}
	else
	{
	echo "inserted";
	$chk=mysql_query("SELECT * from songs WHERE date='$_POST[date]'");
	$chk2=mysql_num_rows($chk);
	if($chk2>=10)
	{
	$query=mysql_query("INSERT INTO calendar (date) VALUES('$_POST[date]')");
	}
	}
	}
	else
	{
	echo "<h1>Fill in all the fields</h1>";
	}
	$query=mysql_query("select id from songs where date='$_POST[date]' and uploader='$_SESSION[user]' and title='$_POST[title]' and artist='$_POST[artist]'");
	if(!$chk=mysql_fetch_array($query))
	{die(mysql_error());}
	move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" .$chk['id'].".mp3" );
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
	
	}
    }
  }
else
  {
  echo "Invalid file";
  }
?>