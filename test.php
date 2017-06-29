<?php
$datetime1 = new DateTime('2009-10-11');
$datetime2 = new DateTime('2009-10-13');
$date3 = new DateTime(date('Y-m-d'));
if($datetime1 < $date3){
    echo "doing fine".PHP_EOL;
    echo date('Y-m-d');
}

?>

