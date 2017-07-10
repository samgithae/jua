<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 7/9/17
 * Time: 5:55 PM
 */
require_once  __DIR__.'/../vendor/autoload.php';

use Hudutech\Controller\LoanController;

$requestMethod = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

if($requestMethod == 'POST') {
    if(!empty($data['clientId']) && !empty($data['clientLoanId']) && !empty($data['amount'])  ){
     if($data['loanType'] !='long_term'){
         $repaid = LoanController::serviceLoan($data['clientId'], $data['clientLoanId'], $data['amount']);
         if($repaid === true){
             print_r(json_encode(array(
                 'statusCode'=>200,
                 "message"=> "Transaction Completed Successfully"
             )));
         }else{
             print_r(json_encode(array(
                 "statusCode"=>500,
                 "message"=>"Internal Server error occurred Transaction not completed please try again later"
             )));
         }
     }else{
         $repaid = LoanController::serviceLongTermLoan($data['clientId'], $data['clientLoanId'], $data['amount']);
         if($repaid === true){
             print_r(json_encode(array(
                 'statusCode'=>200,
                 "message"=> "Transaction Completed Successfully"
             )));
         }
     }
    } else{
        print_r(json_encode(array(
            "statusCode"=>500,
            "message"=>"No LoanRepayment data submitted. Please fill in the required data and try again"
        )));
    }
}