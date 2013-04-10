<?php

session_start();
require("res/config.php");
if(!isset($_SESSION['user']) || $_SESSION['fac']!=0){die("Permission denied");}
?>
<?php
//echo $_FILES['file']['name'];
//return;
$allowedExts = array("mp3", "mp4", "ogg","MP3","MP4","OGG","WAV","wav");
$value=explode(".", $_FILES["file"]["name"]);
$extension = end($value);
//echo $extension;
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
/*    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
 */
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
	if($_POST['click']=="0"){include 'speech2.php';}
	
	$chk=mysql_query("INSERT INTO songs (date,uploader,title,artist,type) VALUES('$_POST[date]','$_SESSION[user]','$_POST[title]','$_POST[artist]',\"song\")");
	if(!$chk)
	{die("couldnt upload");}
	else
	{
//	echo "inserted";
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
/*	//removing spaces from file names..
			$name0=explode(" ",$_FILES["file"]["name"]);
			$name1=array_map('trim',$name0);
			$name2="";
			$l=count($name1);

			for($i=0;$i<$l-1;$i++){$name2.=$name1[$i]."_";}
			$name2.=$name1[$l-1];
			$_FILES["file"]["name"]=$name2;
 */	
	//renaming song file with id...
	$q1=mysql_query("select MAX(id) from songs");
	$q=mysql_fetch_array($q1);
	$a= $q['MAX(id)'];
	$query=mysql_query("select id from songs where date='$_POST[date]' and uploader='$_SESSION[user]'  and id='$a' and type='song'");
	if(!$chk=mysql_fetch_array($query))
	{die(mysql_error());}
	$name1=explode(".",$_FILES['file']['name']);
	$l=count($name1)-1;
	$_FILES["file"]["name"]=$chk['id'].'.'.$name1[$l];
	move_uploaded_file($_FILES["file"]["tmp_name"],
		"/var/lib/mpd/music/".$_FILES['file']['name'] );
	$_GET['upl']=1;
	
	
	//mp3 format check-----------------------------------------------added:14/2/2013
	//
	$name1=explode(".",$_FILES['file']['name']);
	$l=count($name1)-1;
	$fl=0;
	if($l>0){//wav to mp3
		if(strtolower($name1[$l])=="wav"){
		/*	$name0=explode(" ",$_FILES["file"]["name"]);
			$name1=array_map('trim',$name0);
			$name2="";
			$l=count($name1);

			for($i=0;$i<$l-1;$i++){$name2.="_".$name1[$i];}
			$name2.=$name1[$l-1];
			$name1=explode(".",$name2);
			$l=count($name1);
		 */
			$newname=$name1[0];
			for($i=1;$i<=$l-1;$i++)$newname.=$name1[$i];
			$newname.=".mp3";
			
			exec('avconv -i /var/lib/mpd/music/"'.$_FILES["file"]["name"].'"  /var/lib/mpd/music/"'.$newname.'"');
			unlink('/var/lib/mpd/music/'.$_FILES["file"]["name"]);
			$_FILES["file"]["name"]=$newname;
			$fl=1;
		
		}
	

}
	if($fl)echo "file has been automatically converted to mp3 format.";
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
		
	$chk=mysql_query("SELECT * from songs WHERE date='$_POST[date]'");
      $chk2=mysql_num_rows($chk);
      if($chk2==1)
      {
	      $fp=fopen("/var/lib/mpd/playlists/".$_POST['date'].".m3u","w");
	      chmod("/var/lib/mpd/playlists/".$_POST['date'].".m3u",0777);
	      fwrite($fp,$_FILES['file']['name']);
	      fclose($fp);
//	header("Location:upload.php?upl=1&date=".$_POST['date']);
	header("Location:calendar.html");
      }
      else if($chk2>0)
      {
	      chmod("/var/lib/mpd/playlists/".$_POST['date'].".m3u",0777);
	      $fp=fopen("/var/lib/mpd/playlists/".$_POST['date'].".m3u","a");
	      fwrite($fp,"\n".$_FILES['file']['name']);
	      fclose($fp);
//	header("Location:upload.php?upl=1&date=".$_POST['date']);
	header("Location:calendar.html");
      }
	}
    }
  }
else
  {
  echo "hello".$POST["file"].$extension."Invalid file";
  }
?>
