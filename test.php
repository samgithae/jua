<?php
require_once __DIR__.'/vendor/autoload.php';

use Hudutech\Controller\SavingController;

print SavingController::checkBalance($_GET['id']);


