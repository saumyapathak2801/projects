<?php
$apikey = "508fb5333693163987492cbcc487a8caeb4f06b027985"; //api key is available in settings page

//change your language appropriately
$lang = "english"; //telugu, hindi, kannada

//in the case Telugu, Hindi and Kannada, the content should be in UTF8.
$utf8 = "Welcome to Akshar Speech technologies.";
$url = "http://msg2voice.com/aspeak/php/aspeak.php";
$data = "utf8=".$utf8."&lang=".$lang."&apikey=".$apikey;
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$result = curl_exec($ch);

curl_close($ch);
print $result;
?>

 
