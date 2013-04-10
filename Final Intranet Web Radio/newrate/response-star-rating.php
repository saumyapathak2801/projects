<?php
header('Content-type: application/javascript');
include("include/class.database.php");

	foreach ($_GET as $key => $value) {
		if(is_numeric($value)) {
			$_GET[$key] = mysql_real_escape_string($value);
		} else {
			print("Don't tase me, bro! ");
		}
	} 
	$sql = mysql_query("SELECT * FROM tut_starRating WHERE articleId = ".$_GET['ratingId']."");
	$rows = mysql_num_rows($sql);
	if($rows == 0) {
		$sql = mysql_query("INSERT INTO tut_starRating (articleId, votes, rating) VALUES (".$_GET['ratingId'].", 1, ".$_GET['value'].")") or die(mysql_error());
		if ($sql) {
			print("Thank you for rating article ".$_GET['ratingId']." with the value ".$_GET['value']."");
		}			
	} else {
		$sql = mysql_query("UPDATE tut_starRating SET votes = votes+1, rating = rating+".$_GET['value']." WHERE articleId = ".$_GET['ratingId']."") or die(mysql_error());
		if ($sql) {
			print("Thank you for rating article ".$_GET['ratingId']." with the value ".$_GET['value']."");
		}		
	}
?>
<script type="application/javascript" language="javascript">
<!--
$('rating_'+<?php echo $_GET['ratingId'] ?>).immediateDescendants().each(function(c){
	Event.stopObserving(c, 'click', submitRating);
});
-->
</script>

