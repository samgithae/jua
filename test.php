<?php
require_once __DIR__.'/vendor/autoload.php';

$client = \Hudutech\Controller\ClientController::getId(57);
//print_r($client);
use Hudutech\Controller\SavingController;
$loans= \Hudutech\Controller\LoanController::all();


$balance= SavingController::checkBalance(57);
echo $balance;

