<?php include 'metadata.php'; ?>
<?php
$f = '5.mp3';
$m = new mp3file($f);
$a = $m->get_metadata();

if ($a['Encoding']=='Unknown')
    echo "?";
else if ($a['Encoding']=='VBR')
    print_r($a);
else if ($a['Encoding']=='CBR')
    print_r($a);
unset($a);
?>