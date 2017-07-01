<?php
$datetime1 = new DateTime('2009-10-11');
$datetime2 = new DateTime('2009-10-13');
$date3 = new DateTime(date('Y-m-d'));

$year = date('Y', strtotime(date('Y-m-d')));
echo $year;
$month = date('m', strtotime(date('Y-m-d')));
echo PHP_EOL.$month;
?>

