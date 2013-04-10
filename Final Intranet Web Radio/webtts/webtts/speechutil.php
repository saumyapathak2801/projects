<!DOCTYPE HTML>
<html>
<body>
<h1>In this demonstration:<br />
>tts is done on server side (i.e by using SpeechUtil server)<br/>
>then the audio received from speechutil.com is saved on your server (local/production)<br />
>and then that saved audio is played through that saved file on this webpage.</h1>
<h3>
Tested with:
Chrome v21 [Working],
Firefox v14 [Working],
IE v9[Not Working, IE does not support ogg audio format playback]
</h3>
<hr />
<form method="POST" style="font-size:25px">
Text to convert : <input name="txt" type="text" /><br />
Filename to save (without the extension) : <input name="filename" type="text" /><br />
Convert text to speech : <input name="submit" type="submit" value="Convert" />
</form>

<?php
function file_get_contents_curl($url) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
      curl_setopt($ch, CURLOPT_URL, $url);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
      }
if (isset($_POST['txt']) && isset($_POST['filename']))
{
	$text=htmlentities($_POST['txt']);
	$filename=$_POST['filename'].'.ogg';
	
	$querystring = http_build_query(array(
		"text" => $text
	));
	
	//for wav file format use http://speechutil.com/convert/wav? below
	$soundfile = file_get_contents_curl("http://speechutil.com/convert/ogg?".$querystring);
	echo $soundfile;
	if ($soundfile = file_get_contents_curl("http://speechutil.com/convert/ogg?".$querystring))
	{
		file_put_contents($filename,$soundfile);
		echo ('
			<audio autoplay="autoplay" controls="controls">
			<source src="'.$filename.'" type="audio/ogg" />
			</audio>
			<br />
			Saved mp3 location : '.dirname(__FILE__).'\\'.$filename.'
			<br />
			Saved mp3 uri : <a href="'.$filename.'">'.$_SERVER['SERVER_NAME'].'/webtts/'.$filename.'</a>'
		);
	}
	else echo("<br />Audio could not be saved");
}
?>
</body>
</html>