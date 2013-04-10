<?php 


session_start();
require("../res/config.php");
include('include/class.database.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Javascript Star Rating System with Prototype | Star rating tutorial with Prototype</title>
      
		<!-- LOAD PROTOTYPE FROM GOOGLE -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/prototype/1.6.1.0/prototype.js"></script>
        
		<!-- LOAD SCRIPTACULOUS FROM GOOGLE -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.3/scriptaculous.js"></script>
        
        <!-- STAR RATING -->
		<script language="javascript" type="text/javascript" src="js/star-rating.js"></script>	
		<script type="text/javascript">
		// <![CDATA[
		document.observe('dom:loaded', function() {
			init_rating();        
		});
		// ]]>
		</script>	
	</head>
<body>
	<!-- START CONTENT -->
    <h2>1. Demo "Song Rating"</h2>
    
    <ol>
    <?php
	// very quick & dirty code
	$sql = mysql_query("SELECT * FROM tut_starRating");
	$rows = mysql_num_rows($sql);
	if ($rows == 0) {
		echo "no rows found";
	} else {
		while($row = mysql_fetch_array($sql)) {
			$tmp_rating = $row['rating'] / $row['votes'];
			$rating = round(($tmp_rating*2), 0)/2; // round up or down to nearest half
			print("<li><div class='rating' id='rating_".$row['articleId']."'>".$rating."</div><div id='starRatingFeedback_".$row['articleId']."'></div></li>");
		}
	}	
	?>	
	</ol>   
             
			
</body>
</html>
