<?php
require_once __DIR__.'/vendor/autoload.php';


use Hudutech\Controller\LoanController;

print_r(LoanController::checkClientHasActiveLoan(1, 3));
