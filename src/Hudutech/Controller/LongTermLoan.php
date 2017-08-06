<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 7/1/17
 * Time: 7:48 PM
 */

namespace Hudutech\Controller;
use Hudutech\DBManager\DB;
use Hudutech\Entity\Loan;

trait LongTermLoan
{
    public static function lendLongTermLoan($clientId, $loanId, $amount, $years)
    {

        // check if the client can be given amount requested
        $longTermLoanLimit= ClientController::getLongTermLoanLimit($clientId);
        $loanDate = date('Y-m-d');
        if ($amount <= $longTermLoanLimit) {
            $loan = self::getId($loanId);
            $loanType = $loan['loanType'];
            $interest = self::calculateInterest($loanType, $amount);
            $loanBal = $amount + $interest;
            $status = "active";


            //save loan detain to client loan table.
            try {
                $db = new DB();
                $conn = $db->connect();

                $stmt = $conn->prepare("INSERT INTO client_loans(clientId, loanAmount, loanType, loanDate, status)
                                          VALUES (:clientId, :loanAmount, :loanType, :loanDate, :status)");


                $stmt->bindParam(":clientId", $clientId);
                $stmt->bindParam(":loanAmount", $amount);
                $stmt->bindParam(":loanType", $loanType);
                $stmt->bindParam(":loanDate", $loanDate);
                $stmt->bindParam(":status", $status);
                if ($stmt->execute()) {
                    $config = array(
                        "clientId" => $clientId,
                        "principal" => $amount,
                        "loanInterest" => $interest,
                        "loanBal" => $loanBal,
                        "loanType"=> $loanType,
                        "clientLoanId" => $conn->lastInsertId()
                    );
                    self::createRepaymentDates($clientId, $loanType, $years);
                    self::createLoanStatus($clientId, $loanType, $years);
                    self::createLongTermLoanServing($config);
                    ClientController::createTransactionLog(array(
                        "amount" => $amount,
                        "details" => "Received Loan of Ksh " . $amount . " To be repaid in " . $loanType . " Plan",
                        "clientId" => $clientId
                    ));
                    return true;
                } else {
                    return [
                        "error" => "Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                    ];
                }

            } catch (\PDOException $exception) {
                return [
                    "error" => $exception->getMessage()
                ];
            }
        } else {
            return [
                "error" => "Amount More than your allowed limit of {$longTermLoanLimit}"
            ];
        }
    }

    public static function serviceLongTermLoan($clientId, $clientLoanId, $amount){
// TODO: make sure interest is calculated only yearly bases
        $db = new DB();
        $conn = $db->connect();

        $table = "client_loans";
        $tableColumns = array();
        $options = array(
            "clientId" => $clientId,
            "status" => "active",
            "id" => $clientLoanId,
            "limit" => 1
        );

        $table2 = "long_term_loan_servicing";
        $cols = array();
        $options2 = array(
            "clientId" => $clientId,
            "clientLoanId" => $clientLoanId

        );
        $loanServicing = self::customFilter($table2, $cols, $options2);


        $clientLoan = self::customFilter($table, $tableColumns, $options);

        $loanType = $clientLoan[0]['loanType'];

        // make first payment

        try {
            $previousPayment = self::getPreviousLongTermLoan($clientLoanId);

            if (sizeof($loanServicing) == 1 &&
                empty($loanServicing[0]['loanCF']) &&
                empty($loanServicing[0]['amountPaid'])
            ) {

                $loanCF = (float)($loanServicing[0]['loanBal'] - $amount);
                $id = $previousPayment['id'];
                if ($loanCF == 0) {
                    self::markLoanCleared($clientId, $clientLoanId);
                }

                $stmt = $conn->prepare("UPDATE long_term_loan_servicing SET amountPaid=:amountPaid, loanCF=:loanCF
                                        WHERE id=:id");
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":amountPaid", $amount);
                $stmt->bindParam(":loanCF", $loanCF);

                if ($stmt->execute()) {
                    //create transaction log
                    ClientController::createTransactionLog(array(
                        "amount" => $amount,
                        "details" => "Repayment of Loan",
                        "clientId" => $clientId
                    ));
                    return true;
                } else {
                    return false;
                }
            }
            if (sizeof($loanServicing) == 1 && !empty($loanServicing[0]['loanCF']) && !empty($loanServicing[0]['amountPaid']) && $loanServicing[0]['loanCF'] > 0) {
                // get the previous payment and create an new record
                //previous LoanCF = new principal
                $previousLoanCF = $loanServicing[0]['loanCF'];
                $createdAt = $loanServicing[0]['createdAt'];
                $newInterest = self::calculateInterest($loanType, $previousLoanCF);
                $newLoanBal = $previousLoanCF + $newInterest;
                $newLoanCF = (float)($newLoanBal - $amount);
                $datePaid = date("Y-m-d h:i:s");

                if ($newLoanCF == 0) {
                    self::markLoanCleared($clientId, $clientLoanId);
                }

                //create new row for the payment

                $stmt = $conn->prepare("INSERT INTO long_term_loan_servicing(
                                                                            principal,
                                                                            clientId,
                                                                            clientLoanId,
                                                                            loanInterest,
                                                                            loanBal,
                                                                            amountPaid,
                                                                            loanCF,
                                                                            datePaid,
                                                                            createdAt
                                                                        )
                                                                VALUES (
                                                                            :principal,
                                                                            :clientId,
                                                                            :clientLoanId,
                                                                            :loanInterest,
                                                                            :loanBal,
                                                                            :amountPaid,
                                                                            :loanCF,
                                                                            :datePaid,
                                                                            :createdAt
                                                                        )");
                $stmt->bindParam(":principal", $previousLoanCF);
                $stmt->bindParam(":clientId", $clientId);
                $stmt->bindParam(":clientLoanId", $clientLoanId);
                $stmt->bindParam(":loanInterest", $newInterest);
                $stmt->bindParam(":loanBal", $newLoanBal);
                $stmt->bindParam(":amountPaid", $amount);
                $stmt->bindParam(":loanCF", $newLoanCF);
                $stmt->bindParam(":datePaid", $datePaid);
                $stmt->bindParam(":createdAt", $createdAt);

                if ($stmt->execute()) {
                    ClientController::createTransactionLog(array(
                        "amount" => $amount,
                        "details" => "Repayment of Loan",
                        "clientId" => $clientId
                    ));
                    return true;
                } else {
                    return false;
                }
            }


            if (sizeof($loanServicing) > 1 && !empty($previousPayment['loanCF']) && !empty($previousPayment['amountPaid']) && $previousPayment['loanCF'] > 0) {
                // get the previous payment and create an new record
                //previous LoanCF = new principal
                $previousLoanCF = $previousPayment['loanCF'];

                $time1 = strtotime($previousPayment['datePaid']);
                $year1 = date("Y", $time1);
                $time2 = strtotime(date('Y-m-d'));
                $year2 = date("Y", $time2);
                $newLoanCF = 0;
                if($year1 == $year2){
                    //payment done on same year therefore no subsequent interest
                    $createdAt = $previousPayment['createdAt'];
                    $newInterest = 0;
                    $newLoanBal = $previousPayment['loanCF'];
                    $newLoanCF = (float)($newLoanBal - $amount);
                } else if($year2 > $year1){

                    $newInterest = self::calculateInterest($loanType, $previousLoanCF);
                    $newLoanBal = $previousLoanCF + $newInterest;
                    $newLoanCF = (float)($newLoanBal - $amount);
                }

                $datePaid = date("Y-m-d h:i:s");

                if ($newLoanCF == 0) {
                    self::markLoanCleared($clientId, $clientLoanId);
                }

                //create new row for the payment

                $stmt = $conn->prepare("INSERT INTO long_term_loan_servicing(
                                                                            principal,
                                                                            clientId,
                                                                            clientLoanId,
                                                                            loanInterest,
                                                                            loanBal,
                                                                            amountPaid,
                                                                            loanCF,
                                                                            datePaid,
                                                                            createdAt
                                                                        )
                                                                VALUES (
                                                                            :principal,
                                                                            :clientId,
                                                                            :clientLoanId,
                                                                            :loanInterest,
                                                                            :loanBal,
                                                                            :amountPaid,
                                                                            :loanCF,
                                                                            :datePaid,
                                                                            :createdAt
                                                                        )");
                $stmt->bindParam(":principal", $previousLoanCF);
                $stmt->bindParam(":clientId", $clientId);
                $stmt->bindParam(":clientLoanId", $clientLoanId);
                $stmt->bindParam(":loanInterest", $newInterest);
                $stmt->bindParam(":loanBal", $newLoanBal);
                $stmt->bindParam(":amountPaid", $amount);
                $stmt->bindParam(":loanCF", $newLoanCF);
                $stmt->bindParam(":datePaid", $datePaid);
                $stmt->bindParam(":createdAt", $createdAt);

                if ($stmt->execute()) {
                    ClientController::createTransactionLog(array(
                        "amount" => $amount,
                        "details" => "Repayment of Loan",
                        "clientId" => $clientId
                    ));
                    return true;
                } else {
                    return false;
                }
            }

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }

    }

    public static function getPreviousLongTermLoan($prevClientLoanId){
        $db = new DB();
        $conn = $db->connect();
        try{
            $stmt = $conn->prepare("SELECT * FROM long_term_loan_servicing WHERE clientLoanId=:clientLoanId AND loanCF > 0 
                                    ORDER BY datePaid DESC LIMIT 1");
            $stmt->bindParam(":clientLoanId", $prevClientLoanId);
            if($stmt->execute() && $stmt->rowCount() == 1){
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $db->closeConnection();
                return $row;
            }else{
                return ['error'=>"Internal Server Error"];
            }
        } catch (\PDOException $exception){
            return [
                "error"=>$exception->getMessage()
            ];
        }
    }
    public static function clearLoanCF($id){
        $db = new DB();
        $conn = $db->connect();
        try{

        } catch (\PDOException $exception) {

        }
    }

    public static function createTopUpLoan($prevClientLoanId, $topUpAmt, $years){

        $prevLongTermLoan = self::getPreviousLongTermLoan($prevClientLoanId);
        if(!isset($prevLongTermLoan['error'])){
            $loanCF = $prevClientLoanId['loanCF'];
            if((float)$topUpAmt > $loanCF){
                //clear previous loan and create
                //new loan record
                $amountToClearWith = $loanCF;
                $newTopUpAmt = $topUpAmt - $amountToClearWith;
                $loan = self::getLoanId("long_term");

               $exc =  self::lendLongTermLoan($prevLongTermLoan['clientId'], $loan['id'], $newTopUpAmt, $years);

               if($exc) {

                   self::serviceLongTermLoan(
                       $prevLongTermLoan['clientId'],
                       $prevLongTermLoan['clientLoanId'],
                       $newTopUpAmt
                   );
                   ClientController::createTransactionLog(array(
                       "amount" => $newTopUpAmt,
                       "details" => "Took A Top up loan of {$newTopUpAmt}",
                       "clientId" => $prevLongTermLoan['clientId']
                   ));
                   return true;
               } else{
                   return ['error'=> "Error occurred errorinfo=>[{$exc['error']}]'"];
               }

            }else{
                return ['error'=> "Top up amount insufficient to clear current loan"];
            }
        }else{
            return ['error'=> "Error occurred errorinfo=>[{$prevLongTermLoan['error']}]'"];
        }

    }
    public static function getLoanId($loanType){
       $db = new DB();
       $conn  = $db->connect();
       try{
          $stmt = $conn->prepare("SELECT * FROM loans WHERE loanType='{$loanType}' LIMIT 1");
          return $stmt->execute() ? $stmt->fetch(\PDO::FETCH_ASSOC) : [];

       }catch (\PDOException $exception){
           return [];
       }
    }

}