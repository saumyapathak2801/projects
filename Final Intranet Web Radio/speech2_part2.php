<?php
echo "
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>IIIT Radio...</title>
<link href=\"calendar.css\" rel=\"stylesheet\" type=\"text/css\" />
<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\" />
<meta name=\"description\" content=\"website description\" />
  <meta name=\"keywords\" content=\"website keywords, website keywords\" />
  <meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />
  <!-- stylesheets -->
  <link href=\"css/style1.css\" rel=\"stylesheet\" type=\"text/css\" />
  <link href=\"css/colour_calendar.css\" rel=\"stylesheet\" type=\"text/css\" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type=\"text/javascript\" src=\"js/modernizr-1.5.min.js\"></script>
  <style type=\"text/css\">

</style>
<script type=\"text/javascript\" src=\"jwplayer/jwplayer.js\"></script>
</head>
<body>
<nav style=\"margin-top:70px;width:100px;margin-right:120px;\">
        <ul class=\"sf-menu\" id=\"nav\"\">
          <li class=\"selected\"><a href=\"indextemp.php\">Home</a></li>
          
        </ul>
      </nav>
<p style=\"color:white;\"><b> 1.Limit:399 characters</b></br><b>2.Do not press enter while typing the text to change the line.</b></p>
<div style=\"margin-top:60px;margin-left:150px;\">
  <form method=\"POST\" action=\"\" class=\"form_settings\"  style=\"margin-left:170;margin-right:400;margin-top:30px;\">
  <label for=\"Subject\" style=\"font-weight:bold;font-size:30px;color:black;\">Subject:</label><textarea name=\"sub\" style=\"border-radius:0px;background:black;font-color:black;width:500px;font-size:20px;\" rows=\"1\" cols=\"10\"></textarea></br></br>
  </br><textarea name=\"msg\" style=\"border-radius:0px;background:black;font-color:black;width:700px;font-size:20px;\" rows=\"5\" cols=\"100\"></textarea>
  <input type=\"hidden\" name=\"place\" value=\"100\">
  <input type=\"hidden\" value=\"$_GET[date]\" name=\"date\">
  <div style=\"visibility:hidden;margin-top:-200px;\">
   <div  id=\"myElement\">Loading the player...</div></div>
      <script type=\"text/javascript\">
          jwplayer(\"myElement\").setup({
                  file: \"http://10.4.2.27:8000/mpd.mp3\",
                   //     width:'560',
                    //   height: '24',
                          //
                          autostart:\"true\",
                           image: \"jwplayer/legends.jpg\",
                      //    controlbar: 'bottom',
   //                     plugins: {'revolt-1': {} },

                          events: {
                                  onPause: function() {
                                          jwplayer().stop();
                                  }
                                  }
});
</script>
  </br><div style=\"margin-left:450px;\"></br><input type=\"submit\" name=\"req\" class=\"submit\" style=\"margin-left:150px;\" /></div>

  </form>

  " ?>
