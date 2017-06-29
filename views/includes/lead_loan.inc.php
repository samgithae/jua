<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 19:51
 */
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // …

if(!empty($_POST['clientId'])&&!empty($_POST['loanId'])&&!empty($_POST['amount'])) {

  $loanController = \Hudutech\Controller\LoanController::lendLoan($_POST['clientId'],$_POST['loanId'],$_POST['amount']);


    if ($loanController) {
        $success_msg .= "Loan issued successfully";

    } else {
        $error_msg .= "error occured";

    }

}
else{

    $error_msg .= "All  FIELDS REQUIRED";
}
}