<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 5/2/17
 * Time: 7:35 AM
 */

namespace Hudutech\Controller;

use Hudutech\AppInterface\LoanInterface;
use Hudutech\DBManager\ComplexQuery;
use Hudutech\DBManager\DB;
use Hudutech\Entity\Loan;

class LoanController extends ComplexQuery implements LoanInterface
{
    /**
     * @var null|\PDO
     */
    private $conn;

    /**
     * LoanController constructor.
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        $this->conn = $db->connect();
    }

    /**
     * @param Loan $loan
     * @return bool
     */
    public function create(Loan $loan)
    {
        $loanType = $loan->getLoanType();
        $interestRate = $loan->getInterestRate();
        $defaulterFine = $loan->getDefaulterFine();

        try {
            $stmt = $this->conn->prepare("INSERT INTO loans(loanType, interestRate, defaulterFine) VALUES (:loanType, :interestRate, :defaulterFine)");
            $stmt->bindParam(":loanType", $loanType);
            $stmt->bindParam(":interestRate", $interestRate);
            $stmt->bindParam(":defaulterFine", $defaulterFine);
            return $stmt->execute() ? true : false;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    /**
     * @param Loan $loan
     * @param $id
     * @return bool
     */
    public function update(Loan $loan, $id)
    {
        $loanType = $loan->getLoanType();
        $interestRate = $loan->getInterestRate();
        $defaulterFine = $loan->getDefaulterFine();

        try {
            $stmt = $this->conn->prepare("UPDATE loans SET loanType=:loanType, interestRate=:interestRate, defaulterFine=:defaulterFine
                                          WHERE id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":loanType", $loanType);
            $stmt->bindParam(":interestRate", $interestRate);
            $stmt->bindParam(":defaulterFine", $defaulterFine);
            return $stmt->execute() ? true : false;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }


    /**
     * @param $id
     * @return array|mixed
     */
    public static function getId($id)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT t.* FROM loans t WHERE t.id=:id");
            $stmt->bindParam(":id", $id);
            return $stmt->execute() && $stmt->rowCount() == 1 ? $stmt->fetch(\PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    /**
     * @return array
     */
    public static function all()
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT t.* FROM loans t WHERE 1");
            $stmt->bindParam(":id", $id);
            return $stmt->execute() && $stmt->rowCount() > 0 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public static function getLoanObject($id)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("SELECT t.* FROM loans t WHERE t.id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Loan::class);
            return $stmt->execute() && $stmt->rowCount() > 0 ? $stmt->fetch() : null;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return null;
        }
    }

    /**
     * @param array $config
     * @return bool
     */
    public static function createLoanServicing(array $config)
    {

        $clientId = $config['clientId'];
        $principal = $config['principal'];
        $loanInterest = $config['loanInterest'];
        $loanBal = $config['loanBal'];
        $clientLoanId = $config['clientLoanId'];
        $createdAt = date("Y-m-d h:i:s");

        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("INSERT INTO monthly_loan_servicing(principal, clientId, clientLoanId, loanInterest, loanBal,createdAt)
                                  VALUES (:principal, :clientId, :clientLoanId, :loanInterest, :loanBal, :createdAt)");
            $stmt->bindParam(":principal", $principal);
            $stmt->bindParam(":clientId", $clientId);
            $stmt->bindParam(":clientLoanId", $clientLoanId);
            $stmt->bindParam(":loanInterest", $loanInterest);
            $stmt->bindParam(":loanBal", $loanBal);
            $stmt->bindParam(":createdAt", $createdAt);
            return $stmt->execute() ? true : false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    /**
     * @param $clientId
     * @param $loanType
     * @return bool
     */
    public static function createRepaymentDates($clientId, $loanType)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $currentDate = date('Y-m-d');
            $monthOne = null;
            $monthTwo = null;
            $monthThree = null;
            if ($loanType == 'monthly') {
                $monthOne = date('Y-m-d', strtotime($currentDate . ' + 30 days'));
            } elseif ($loanType == 'trimester') {
                $monthOne = date('Y-m-d', strtotime($currentDate . ' + 30 days'));
                $monthTwo = date('Y-m-d', strtotime($monthOne . ' + 30 days'));
                $monthThree = date('Y-m-d', strtotime($monthTwo . ' + 30 days'));
            }
            $stmt = $conn->prepare("INSERT INTO loan_repayment_dates(clientId, monthOne, monthTwo, monthThree, loanType, loanDate)
                                     VALUES (:clientId, :monthOne, :monthTwo, :monthThree, :loanType, :loanDate)");

            $stmt->bindParam(":clientId", $clientId);
            $stmt->bindParam(":monthOne", $monthOne);
            $stmt->bindParam(":monthTwo", $monthTwo);
            $stmt->bindParam(":monthThree", $monthThree);
            $stmt->bindParam(":loanType", $loanType);
            $stmt->bindParam(":loanDate", $currentDate);
            return $stmt->execute() ? true : false;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    /**
     * @param $loanType
     * @param $amount
     * @return float
     */
    public static function calculateInterest($loanType, $amount)
    {
        $table = 'loans';
        $tableColumn = array();
        $options = array("loanType" => $loanType, "limit" => 1);
        $loan = self::customFilter($table, $tableColumn, $options);
        $interestRate = $loan[0]['interestRate'];
        return (float)($amount * $interestRate);
    }

    /**
     * @param $clientId
     * @param $loanType
     * @return bool
     */
    public static function createLoanStatus($clientId, $loanType)
    {
        $db = new DB;
        $conn = $db->connect();

        $currentDate = date('Y-m-d');
        try {
            $status = 'not_defaulted';
            if ($loanType == 'monthly') {
                $monthOne = date('Y-m-d', strtotime($currentDate . ' + 30 days'));
                $sql = "INSERT INTO loan_status(clientId, deadline, status, loanType, loanDate)
                          VALUES (:clientId, :deadline, :status, :loanType, :loanDate)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":clientId", $clientId);
                $stmt->bindParam(":deadline", $monthOne);
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":loanType", $loanType);
                $stmt->bindParam(":loanDate", $currentDate);
                $stmt->execute();
                return true;

            } elseif ($loanType == 'trimester') {

                $monthOne = date('Y-m-d', strtotime($currentDate . ' + 30 days'));
                $monthTwo = date('Y-m-d', strtotime($monthOne . ' + 30 days'));
                $monthThree = date('Y-m-d', strtotime($monthTwo . ' + 30 days'));
                $months = array($monthOne, $monthTwo, $monthThree);
                $sql = "INSERT INTO loan_status(clientId, deadline, status, loanType, loanDate) VALUES (:clientId, :deadline, :status, :loanType, :loanDate)";
                $stmt = $conn->prepare($sql);

                foreach ($months as $month) {
                    $stmt->bindParam(":clientId", $clientId);
                    $stmt->bindParam(":deadline", $month);
                    $stmt->bindParam(":status", $status);
                    $stmt->bindParam(":loanType", $loanType);
                    $stmt->bindParam(":loanDate", $currentDate);
                    $stmt->execute();
                }
                return true;
            }
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    /**
     * @param $clientId
     * @param $loanId
     * @param $amount
     * @return bool
     */
    public static function lendLoan($clientId, $loanId, $amount)
    {

        // check if the client can be given amount requested
        $loanLimit = ClientController::getLoanLimit($clientId);
        $loanDate = date('Y-m-d');
        if ($amount <= $loanLimit) {

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
                        "clientLoanId" => $conn->lastInsertId()
                    );
                    self::createRepaymentDates($clientId, $loanType);
                    self::createLoanStatus($clientId, $loanType);
                    self::createLoanServicing($config);
                    ClientController::createTransactionLog(array(
                        "amount" => $amount,
                        "details" => "Received Loan of Ksh " . $amount . " To be repaid in " . $loanType . " Plan",
                        "clientId" => $clientId
                    ));
                    return true;
                } else {
                    return false;
                }

            } catch (\PDOException $exception) {
                print_r(array("error" => $exception->getMessage()));
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * @param $clientId
     * @param $clientLoanId
     * @return array|mixed
     */
    public static function getPreviousRepayment($clientId, $clientLoanId)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT * FROM monthly_loan_servicing 
                                    WHERE clientId='{$clientId}' AND
                                     clientLoanId='{$clientLoanId}'
                                      ORDER BY id DESC LIMIT 1");
            return $stmt->execute() && $stmt->rowCount() == 1 ? $stmt->fetch(\PDO::FETCH_ASSOC) : [];


        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    /**
     * @param $clientId
     * @param $clientLoanId
     * @return bool
     */
    public static function markLoanCleared($clientId, $clientLoanId)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("UPDATE client_loans SET `status`='repaid'
            WHERE id='{$clientLoanId}' AND clientId='{$clientId}'");
            return $stmt->execute() ? true : false;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }


    /**
     * @param $clientId
     * @param $clientLoanId
     * @param $amount
     * @return bool
     */
    public static function serviceLoan($clientId, $clientLoanId, $amount)
    {
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

        $table2 = "monthly_loan_servicing";
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
            $previousPayment = self::getPreviousRepayment($clientId, $clientLoanId);

            if (sizeof($loanServicing) == 1 &&
                empty($loanServicing[0]['loanCF']) &&
                empty($loanServicing[0]['amountPaid'])
            ) {

                $loanCF = (float)($loanServicing[0]['loanBal'] - $amount);
                $id = $previousPayment['id'];
                if ($loanCF == 0) {
                    self::markLoanCleared($clientId, $clientLoanId);
                }

                $stmt = $conn->prepare("UPDATE monthly_loan_servicing SET amountPaid=:amountPaid, loanCF=:loanCF
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

                $stmt = $conn->prepare("INSERT INTO monthly_loan_servicing(
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
                $createdAt = $previousPayment['createdAt'];
                $newInterest = self::calculateInterest($loanType, $previousLoanCF);
                $newLoanBal = $previousLoanCF + $newInterest;
                $newLoanCF = (float)($newLoanBal - $amount);
                $datePaid = date("Y-m-d h:i:s");

                if ($newLoanCF == 0) {
                    self::markLoanCleared($clientId, $clientLoanId);
                }

                //create new row for the payment

                $stmt = $conn->prepare("INSERT INTO monthly_loan_servicing(
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

    public static function getLoan()
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT * FROM client_loans WHERE  status='active'");
            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                $db->closeConnection();
                return $rows;

            } else {
                $db->closeConnection();
                return [
                    "error" => "Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                ];
            }
        } catch (\PDOException $exception) {
            print_r($exception->getMessage());
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    public static function getAmountDefaulted()
    {

    }

    public static function getLatestLoanCF($clientId)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT clientLoanId, loanCF FROM monthly_loan_servicing
                                    WHERE clientId=:clientId ORDER BY datePaid DESC  LIMIT 1");
            $stmt->bindParam(":clientId", $clientId);
            if ($stmt->execute() && $stmt->rowCount() == 1) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $db->closeConnection();
                return $row;
            } else {
                $db->closeConnection();
                return [
                    "error" => "Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                ];
            }
        } catch (\PDOException $exception) {
            print_r($exception->getMessage());
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    public static function getRepaymentsDeadlines($clientId, $loanDate)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT * FROM loan_repayment_dates WHERE clientId=:clientId AND loanDate=:loanDate");
            $stmt->bindParam(":clientId", $clientId);
            $stmt->bindParam(":loanDate", $loanDate);
            if ($stmt->execute() && $stmt->rowCount() == 1) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $db->closeConnection();
                return $row;
            } else {
                $db->closeConnection();
                return [
                    "error" => "Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                ];
            }
        } catch (\PDOException $exception) {
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    public static function totalMonthRepayment($date){
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT SUM(amountPaid) as totalPaid FROM monthly_loan_servicing
                                    WHERE date(datePaid)='{$date}'");
            if ($stmt->execute() && $stmt->rowCount() == 1) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $db->closeConnection();
                return (float)$row['amountPaid'];
            } else {
                $db->closeConnection();
                return [
                    "error" => "Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                ];
            }
        } catch (\PDOException $exception) {
            print_r($exception->getMessage());
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    public static function checkIfDefaulted()
    {
        $loans = self::getLoan();
        if (!array_key_exists('error', $loans) && sizeof($loans) > 0) {
            foreach ($loans as $loan) {
                if ($loan['loanType'] == 'trimester') {
                    // get repayment dates
                    $dates = self::getRepaymentsDeadlines($loan['clientId'], $loan['loanDate']);
                    $today = new \DateTime(date('Y-m-d'));
                    $monthOne = new \DateTime($dates['monthOne']);
                    $monthTwo = new \DateTime($dates['monthTwo']);
                    $monthThree = new \DateTime($dates['monthThree']);
                    $monthOneRepayment = 0;
                    $monthTwoRepayment = 0;
                    $monthThreeRepayment = 0;
                    $m1 = self::totalMonthRepayment($dates['monthOne']);
                    $m2 = self::totalMonthRepayment($dates['monthTwo']);
                    $m3 = self::totalMonthRepayment($dates['monthThree']);
                    if(!array_key_exists('error', $m1)){
                       $monthOneRepayment = $m1;
                    }
                    if(!array_key_exists('error', $m2)){
                        $monthTwoRepayment = $m2;
                    }
                    if(!array_key_exists('error', $m3)){
                        $monthThreeRepayment = $m3;
                    }

                    $monthOnePayable = self::calculateInterest('trimester', $loan['loanAmount']) - $loan['loanAmount'];
                    $nextMonthAmt = self::getLatestLoanCF($loan['clientId'])['loanCF'];
                    $nextMonthPayable = self::calculateInterest('trimester', $nextMonthAmt) - $nextMonthAmt;


                    if ($monthOne > $today && $today < $monthTwo && (float)$monthOneRepayment< $monthOnePayable) {
                        //defaulted for month one
                        //check the latest loanCF


                        //compute the new loan balance which includes the fine.
                        //update defaulters table and create instance of defaulters

                    } elseif ($monthTwo > $today && $today < $monthThree && $monthTwoRepayment < $nextMonthPayable) {
                        //defaulted for month two
                    } elseif ($monthThree > $today && $monthThreeRepayment < $nextMonthPayable) {
                        //defaulted for month three
                    }


                }
            }
        }
    }

    public static function markAsDefaulted()
    {

    }


}