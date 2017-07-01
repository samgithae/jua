<?php
require_once __DIR__.'/vendor/autoload.php';
use Hudutech\Controller\SavingController;
$bal = SavingController::checkBalance(1);
print_r($bal);
?>

