<?php
	//require("res/config.php");
	//if(!mysql_connect("localhost","root","password"))
	//{die("sorry".mysql_error());}
//	mysql_select_db("radio");
	require("res/config.php");
	$no_require_login = "true";
	return;	
	require_once("/home/y2y/public_html/finalradio/r2/pitchfork/inc/base.php");
	$iamincluded = true;
	require_once("/home/y2y/public_html/finalradio/r2/pitchfork/player/metadata.php"); 
	header("Content-Type: text/plain");
	try {
		$pl = get_playback();
		$info = $pl->getCurrentSong();
		$pl->disconnect();

		$rlyric = "";
		$id=2;
		if(isset($info['file']))
//			echo $info['file'];
		{	$id1=explode('.',$info['file']);
			$id=$id1[0];
		}
		$id=284;
		$query=mysql_query("select * from songs where id='$id'");
		if(!$chk=mysql_fetch_array($query))
			{die(mysql_error());}
		else{
			if($chk["title"]=="song+announce"){
				$chk["title"]="Announcement";
			
			}
			echo "<center>".$chk['title']."<br/>".$chk['artist']."<br/>".$chk['uploader'];
				

		}
		
		//else echo "not playing";
	}
	catch(PEARException $e) {
		echo "error contacting mpd";
	}
	echo "\n";
?>
