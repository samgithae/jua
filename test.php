<?php
require_once __DIR__.'/vendor/autoload.php';

use Hudutech\Controller\SavingController;

use Hudutech\Controller\LoanController;
use Hudutech\Controller\ClientController;

$savings = SavingController::checkBalance(57);

$loans = LoanController::getLoan();
//print_r($loans);
$loan = LoanController::getPreviousRepayment(3, 9);


//print_r($loan);
//echo ClientController::getShortTermLoanLimit(57).PHP_EOL;
//print_r(LoanController::calculateInterest('monthly', 5000));
//$cashReceived = 7000;
//$dumpedSaving = 0;
//
//$contribution = null;
//$updated = SavingController::clearPreviousDumpSaving(13);
//if($updated){
//    echo "ndani ndani kabisa";
//}else{
//    echo "nasa hawa";
//}
//$prev =  SavingController::getPreviousSavings(3);
//echo "id is {$prev['id']}";

$arr1 = array(
    "name"=>"githae",
    "age"=>24
);

//print_r($arr1);

//$totalMonthContrib = SavingController::getTotalMonthContribution(3);
//$totalMonthAmt = 56;

//if (empty($previousSavings['dumpedSaving'])) {
//
//    if ((float)$totalMonthContrib['total_contribution'] >= 0 && $totalMonthContrib['total_contribution'] <= 5000) {
//        $totalMonthAmt = (float)$totalMonthContrib['total_contribution'];
//
//        $compareFactor = 5000 - $totalMonthAmt;
//        $dumpCompareFactor = $cashReceived - $compareFactor;
//        if($dumpCompareFactor == 0 ){
//            $dumpedSaving = 0;
//            $contribution = $cashReceived;
//        }elseif($dumpCompareFactor > 0){
//            $dumpedSaving = $dumpCompareFactor;
//            $contribution = $compareFactor;
//        } elseif ($dumpCompareFactor< 0){
//            $contribution = $cashReceived;
//            $dumpedSaving = 0;
//        }
//    }
//
//} elseif (!empty($previousSavings['dumpedSaving'])) {
//    $time1 = strtotime($previousSavings['datePaid']);
//    $month1 = date("m", $time1);
//    $year1 = date("Y", $time1);
//
//    $time2 = strtotime(date('Y-m-d'));
//    $month2 = date("m", $time2);
//    $year2 = date("Y", $time2);
//    if($year1==$year2 && $month2 > $month1){
//        $newCash = $previousSavings['dumpedSaving'] + $cashReceived;
//        if($newCash >=5000){
//            $dumpedSaving = $newCash - 5000;
//            $contribution = 5000;
//            //execute function to put previous dump saving to Zero
//            //
//        } elseif ($newCash<5000){
//            $dumpedSaving = 0;
//            $contribution = $cashReceived;
//        }
//
//    }
//}
//
//echo "CONTRIB {$contribution} dump {$dumpedSaving}  cash {$cashReceived}";