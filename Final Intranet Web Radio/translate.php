<?php
function file_get_contents_curl($url) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
      curl_setopt($ch, CURLOPT_URL, "http://translate.google.com");
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
      }
// Convert Words (text) to Speech (MP3)
// ------------------------------------
// Google Translate API cannot handle strings > 100 characters
   $words = substr("hello world", 0, 100);
// Replace the non-alphanumeric characters
// The spaces in the sentence are replaced with the Plus symbol
   $words = urlencode("hello world my name is saumya!");
// Name of the MP3 file generated using the MD5 hash
   $file  = md5($words);
  
// Save the MP3 file in this folder with the .mp3 extension
   $file = "upload/" . $file . ".mp3";
// If the MP3 file exists, do not create a new request
   if (!file_exists($file)) {
     $mp3 = file_get_contents_curl(
        'http://translate.google.com/#en/en/'.$words);
   //  file_put_contents($file, $mp3);*/
   }
?>
// Embed the MP3 file using the AUDIO tag of HTML5
<audio controls="controls" autoplay="autoplay">
  <source src="<?php echo $file; ?>" type="audio/mp3" />
</audio>
