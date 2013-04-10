<?php include 'fetchsongs.php'; ?>
<?php 
$count_my_page2 = ("time.txt");
$fp = fopen($count_my_page2 , "w");
$t=time();
fputs($fp , "$t");
fclose($fp);
$count_my_page2 = ("lock.txt");
$fp = fopen($count_my_page2 , "w");
fputs($fp , 0);
fclose($fp);
?>
