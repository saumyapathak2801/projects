<?php



error_reporting(0);
include("config.php");

/// get current month and year and store them in $cMonth and $cYear variables
(intval($_REQUEST["month"])>0) ? $cMonth = $_REQUEST["month"] : $cMonth = date("n");
(intval($_REQUEST["year"])>0) ? $cYear = $_REQUEST["year"] : $cYear = date("Y");

if ($cMonth<10) $cMonth = '0'.$cMonth;

// generate an array with all unavailable dates
$sql = "SELECT * FROM calendar WHERE `date` LIKE '".$cYear."-".$cMonth."-%'";
$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
while ($row = mysql_fetch_assoc($sql_result)) {
	$unavailable[] = $row["date"];
}

// calculate next and prev month and year used for next / prev month navigation links and store them in respective variables
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = intval($cMonth)-1;
$next_month = intval($cMonth)+1;

// if current month is Decembe or January month navigation links have to be updated to point to next / prev years
if ($cMonth == 12 ) {
	$next_month = 1;
	$next_year = $cYear + 1;
} elseif ($cMonth == 1 ) {
	$prev_month = 12;
	$prev_year = $cYear - 1;
}
?>
<html>
<head>

<link href="calendar.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/colour_calendar.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
  <table width="300%" height="400" class="tab">
  <tr>
      <td class="mNav"><a href="javascript:LoadMonth('<?php echo $prev_month; ?>', '<?php echo $prev_year; ?>')">&lt;&lt;</a></td>
      <td colspan="5" class="cMonth"  style="color:black;font-size:20px;font: normal 450% 'Jenna Sue', arial, sans-serif;"><?php echo date("F, Y",strtotime($cYear."-".$cMonth."-01")); ?></td>
      <td class="mNav" style="font: normal 450% 'Jenna Sue', arial, sans-serif;"><a href="javascript:LoadMonth('<?php echo $next_month; ?>', '<?php echo $next_year; ?>')">&gt;&gt;</a></td>
  </tr>
  <tr>
      <td class="wDays">M</td>
      <td class="wDays">T</td>
      <td class="wDays">W</td>
      <td class="wDays">T</td>
      <td class="wDays">F</td>
      <td class="wDays">S</td>
      <td class="wDays">S</td>
  </tr>
<?php 
$first_day_timestamp = mktime(0,0,0,$cMonth,1,$cYear); // time stamp for first day of the month used to calculate 
$maxday = date("t",$first_day_timestamp); // number of days in current month
$thismonth = getdate($first_day_timestamp); // find out which day of the week the first date of the month is
$startday = $thismonth['wday'] ; // 0 is for Sunday and as we want week to start on Mon we subtract 1
if (!$thismonth['wday']) $startday = 7;
for ($i=1; $i<($maxday+$startday); $i++) {
	
	if (($i % 7) == 1 ) echo "<tr>";
	
	if ($i < $startday) { echo "<td>&nbsp;</td>"; continue; };
	
	$current_day = $i - $startday + 1;
	
	(in_array($cYear."-".$cMonth."-".$current_day,$unavailable)) ? $css='booked' : $css='available'; // set css class name based on date availability
	$code=$cYear."-".$cMonth."-".$current_day;
	$day=$cYear."-".$cMonth."-".$current_day;
	$query=mysql_query("SELECT * from calendar WHERE date='$day'");
	if(mysql_num_rows($query)==0){$css='available';$bg="background-color:white";}else{$css="booked";$bg="background-color:red";}
	echo "<td class='".$css."'	>";
	$date=getdate();
	//echo "<h1>$date[year]</h1>";
	//echo "<h1>$cYear</h1>";
	$d1=date_create($date['year']."-".$date['mon']."-".$date['mday']);
	$d2=date_create($cYear."-".$cMonth."-".$day);
	$d1=date_create($date['year']."-".$date['mon']."-".$date['mday']);
	$d2=date_create($cYear."-".$cMonth."-".$current_day);
	echo "</h1>".date_diff($d1-$d2)."</h1>";
//	if(date_diff($d2,$d1)>0){echo "<h1>hello</h1>";}
	$query=mysql_query("SELECT * from calendar WHERE date='$day'");
	if(!$query){die("sorry");}
	if(mysql_num_rows($query)==0){echo "<a href=\"upload.php?date=".$code."\">". $current_day . "</a></td>";}
	else { echo $current_day."</td>";}
	
	if (($i % 7) == 0 ) echo "</tr>";
}
?> 
</table>
