<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 01/07/2017
 * Time: 01:51
 */
require_once __DIR__.'/../vendor/autoload.php';

use Hudutech\Controller\SavingController;
$data = json_decode(file_get_contents('php://input'), true);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $balance= SavingController::checkBalance($data['clientId']);

    print_r(json_encode(array(
        "balance"=>$balance,
        "data"=>$data
    )));}

