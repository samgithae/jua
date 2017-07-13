<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 7/3/17
 * Time: 2:37 PM
 */
require_once __DIR__.'/../vendor/autoload.php';
use Hudutech\Controller\LoanController;

$data = json_decode(file_get_contents('php://input'), true);

if(!empty($data)){
$hasActiveLoan = LoanController::checkClientHasActiveLoan($data['clientId']);
if(isset($hasActiveLoan['error'])){
    print_r(json_encode(array(
        "statusCode"=>500,
        "message"=>$hasActiveLoan['error']
        )));
}elseif(!isset($hasActiveLoan['error']) and !empty($hasActiveLoan)){
    print_r(json_encode(array(
        "statusCode"=>200,
        "loanType"=>$hasActiveLoan['loanType'],
    )));
}
}