<?php
	//require("res/config.php");
	if(!mysql_connect("localhost","root","password"))
	{die("sorry".mysql_error());}
	mysql_select_db("radio");
//	require("res/config.php");
	$no_require_login = "true";
//	return;	
	require_once("/home/y2y/public_html/finalradio/r2/pitchfork/inc/base.php");
	$iamincluded = true;
	require_once("/home/y2y/public_html/finalradio/r2/pitchfork/player/metadata.php"); 
//	header("Content-Type: text/plain");
	try {
		$pl = get_playback();
		$info = $pl->getCurrentSong();
		$pl->disconnect();

		$rlyric = "";
		$id=2;
		$time=date('H:i');
		if(strtotime($time)>strtotime("22:00")){//strtotime($time)<strtotime("17:58")){
		//	echo $time;
		echo "You missed today's awesome show.. :( <br/> We will be back tomorrow at 8pm :) ";
			return;
		}
		if(isset($info['file']))
//			echo $info['file'];
		{	//echo "check";
		
			$id1=explode('.',$info['file']);
		//echo $id1[0];		
			$id=(int)$id1[0];
	//		if(gettype($id)!="integer")
	//	echo $id;		
//$id=284;
		$date=date("Y-m-d");
		$query=mysql_query("select * from songs where id='$id'");
		$n=mysql_num_rows($query);
		$msgg= "You missed today's awesome show.. :( <br/> We will be back tomorrow at 8pm :) ";

		if(!$chk=mysql_fetch_array($query))
		{
			
		//	if($n==0){
		//		$id=284;

	echo "We will be back again at 8pm :)";
			
			
			 die(mysql_error());
		}
		else{
//			echo "sds";
						
			if($n==0)
		echo $msgg;
			else {
				if($chk["title"]=="song+announce"){
				$chk["title"]="Announcement";
			
			}
			echo "Title: ".$chk['title']."<br/>Artist: ".$chk['artist']."<br/>Uploader: ".$chk['uploader'];
				
			}
		}
		}
		else echo "$msgg";
		
		//else echo "not playing";
	}
	catch(PEARException $e) {
		echo "error contacting mpd";
	}
	echo "\n";
?>
