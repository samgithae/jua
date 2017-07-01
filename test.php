<?php
$currentDate = date('Y-m-d');

$days = $years * 365;
$days = '+'.$days.' days';
$deadline = date('Y-m-d', strtotime($currentDate . $days));
echo $deadline;


