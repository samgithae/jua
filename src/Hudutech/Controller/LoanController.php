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
use Hudutech\Entity\Defaulter;
use Hudutech\Entity\Loan;

class LoanController extends ComplexQuery implements LoanInterface
{
    use LongTermLoan;
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
     * @param $clientId
     * @param $loanId
     * @param $amount
     * @return mixed
     */
    public static function lendShortTermLoan($clientId, $loanId, $amount)
    {

        // check if the client can be given amount requested
        $shortTermLoanLimit = ClientController::getShortTermLoanLimit($clientId);
        $loanDate = date('Y-m-d');
        if ($amount <= $shortTermLoanLimit) {

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
                        "loanType" => $loanType,
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
                "error" => "Amount More than your allowed limit of {$shortTermLoanLimit}"
            ];
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
     * @param $years
     * @return bool
     */
    public static function createRepaymentDates($clientId, $loanType, $years = 0)
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
            } elseif ($loanType == 'long_term') {
                $d = $years * 365;
                $days = '+' . $d . ' days';
                $monthOne = date('Y-m-d', strtotime($currentDate . $days));
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
     * @param $clientId
     * @param $loanType
     * @param $years
     * @return bool
     */
    public static function createLoanStatus($clientId, $loanType, $years = 0)
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
            } elseif ($loanType == 'long_term') {
                $days = $years * 365;
                $days = '+' . $days . ' days';
                $deadline = date('Y-m-d', strtotime($currentDate . $days));
                $sql = "INSERT INTO loan_status(clientId, deadline, status, loanType, loanDate)
                          VALUES (:clientId, :deadline, :status, :loanType, :loanDate)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":clientId", $clientId);
                $stmt->bindParam(":deadline", $deadline);
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":loanType", $loanType);
                $stmt->bindParam(":loanDate", $currentDate);
                $stmt->execute();
                return true;
            }
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
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

    public static function createLongTermLoanServing($config)
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
            $stmt = $conn->prepare("INSERT INTO long_term_loan_servicing(principal, clientId, clientLoanId, loanInterest, loanBal,createdAt)
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
     * @param $clientLoanId
     * @param $amount
     * @return bool
     */
    public static function serviceLoan($clientId, $clientLoanId, $amount)
    {
//        TODO: ensure no interest for repayment within the period
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

                $previousLoanCF = $loanServicing[0]['loanCF'];
                $newInterest = self::calculateInterest($loanType, $previousLoanCF);
                $newLoanBal = $previousLoanCF + $newInterest;
                $newLoanCF = (float)($newLoanBal - $amount);

                $createdAt = $loanServicing[0]['createdAt'];

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

                $time1 = strtotime($previousPayment['datePaid']);
                $month1 = date("m", $time1);
                $year1 = date("Y", $time1);

                $time2 = strtotime(date('Y-m-d'));
                $month2 = date("m", $time2);
                $year2 = date("Y", $time2);
                $newLoanCF = 0;
                if ($month1 == $month2 && $year1 == $year2) {
                    $newInterest = 0;
                    $newLoanBal = $previousLoanCF;
                    $newLoanCF = $newLoanBal - $amount;
                } elseif ($month2 > $month1 && $year1 == $year2) {
                    $newInterest = self::calculateInterest($loanType, $previousLoanCF);
                    $newLoanBal = $previousLoanCF + $newInterest;
                    $newLoanCF = (float)($newLoanBal - $amount);
                }


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

//    public static function getAmountDefaulted()
//    {
//
//    }

    public static function totalLongTermRepayment($clientLoanId)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT SUM(amountPaid) AS totalPaid FROM monthly_loan_servicing
                                    WHERE clientLoanId=:clientLoanId");
            $stmt->bindParam(":clientLoanId", $clientLoanId);
            if ($stmt->execute()) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                return (float)$row['totalPaid'];
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
                    $m1 = self::totalMonthRepayment($loan['clientId'], $dates['monthOne']);
                    $m2 = self::totalMonthRepayment($loan['clientId'], $dates['monthTwo']);
                    $m3 = self::totalMonthRepayment($loan['clientId'], $dates['monthThree']);
                    if (!isset($m1['error'])) {
                        $monthOneRepayment = $m1;
                    }
                    if (!isset($m2['error'])) {
                        $monthTwoRepayment = $m2;
                    }
                    if (!isset($m3['error'])) {
                        $monthThreeRepayment = $m3;
                    }


                    if ($monthOne > $today && $today < $monthTwo) {
                        //to get defaulted for month one we compare with latest interest


                        $loanInfo = self::getLatestLoanInfo($loan['id']);
                        if ($monthOneRepayment < (float)$loanInfo['loanInterest']) {
                            $fine = $newLoanBalance = $amountDefaulted = 0;

                            if ($monthOneRepayment > 0) {
                                $amountDefaulted = (float)$loanInfo['loanInterest'] - $monthOneRepayment;
                                $fine = 0.2 * $amountDefaulted;
                                $newLoanBalance = $loanInfo['loanBal'] + $fine;
                            } else {
                                $fine = 0.2 * (float)$loanInfo['loanInterest'];
                                $newLoanBalance = $loanInfo['loanBal'] + $fine;
                            }
                            //compute fine
                            $groupRefNo = ClientController::getId($loan['clientId'])['groupRefNo'];
                            $info = [
                                "fine" => $fine,
                                "newLoanBal" => $newLoanBalance,
                                "clientLoanId" => $loan['clientLoanId'],
                                "loanType" => $loan['loanType'],
                                "groupRefNo" => $groupRefNo,
                                "amountDefaulted" => $amountDefaulted,
                                "createdAt" => $loan['createdAt']
                            ];
                            self::executeDefaulterFine($loan['clientId'], $info);


                        }
                        //compute the new loan balance which includes the fine.
                        //update defaulters table and create instance of defaulters

                    } elseif ($monthTwo > $today && $today < $monthThree) {
                        $loanInfo = self::getLatestLoanInfo($loan['id']);
                        if ($monthTwoRepayment < (float)$loanInfo['loanInterest']) {
                            $fine = $newLoanBalance = $amountDefaulted = 0;

                            if ($monthTwoRepayment > 0) {
                                $amountDefaulted = (float)$loanInfo['loanInterest'] - $monthTwoRepayment;
                                $fine = 0.2 * $amountDefaulted;
                                if (!is_null($loanInfo['loanCF'])) {
                                    $newLoanBalance = $loanInfo['loanCF'] + $fine;
                                } else {
                                    $newLoanBalance = $loanInfo['loanBal'] + $fine;
                                }

                            } else {
                                $amountDefaulted = (float)$loanInfo['loanInterest'];
                                $fine = 0.2 * $amountDefaulted;
                                //check is loanCF Is null if not take balance
                                //since this will be the case where client was given loan and
                                //did not give any repayment at all.
                                if (!is_null($loanInfo['loanCF'])) {
                                    $newLoanBalance = $loanInfo['loanCF'] + $fine;
                                } else {
                                    $newLoanBalance = $loanInfo['loanBal'] + $fine;
                                }
                            }

                            //execute the code to create defaulter an update the loanservicing
                            //table with the new data

                            $groupRefNo = ClientController::getId($loan['clientId'])['groupRefNo'];
                            $info = [
                                "fine" => $fine,
                                "newLoanBal" => $newLoanBalance,
                                "clientLoanId" => $loan['clientLoanId'],
                                "loanType" => $loan['loanType'],
                                "groupRefNo" => $groupRefNo,
                                "amountDefaulted" => $amountDefaulted,
                                "createdAt" => $loan['createdAt']
                            ];
                            self::executeDefaulterFine($loan['clientId'], $info);

                        }
                    } elseif ($monthThree > $today) {
                        $loanInfo = self::getLatestLoanInfo($loan['id']);
                        if ($monthThreeRepayment < (float)$loanInfo['loanInterest']) {
                            //compute fine
                            $fine = $newLoanBalance = $amountDefaulted = 0;

                            if ($monthThreeRepayment > 0) {
                                $amountDefaulted = (float)$loanInfo['loanBal'] - $monthThreeRepayment;
                                $fine = 0.2 * $amountDefaulted;
                                $newLoanBalance = $loanInfo['loanBal'] + $fine;
                            } else {
                                $amountDefaulted = (float)$loanInfo['loanBal'];
                                $fine = 0.2 * $amountDefaulted;
                                $newLoanBalance = $loanInfo['loanBal'] + $fine;
                            }

                            $groupRefNo = ClientController::getId($loan['clientId'])['groupRefNo'];
                            $info = [
                                "fine" => $fine,
                                "newLoanBal" => $newLoanBalance,
                                "clientLoanId" => $loan['clientLoanId'],
                                "loanType" => $loan['loanType'],
                                "groupRefNo" => $groupRefNo,
                                "amountDefaulted" => $amountDefaulted,
                                "createdAt" => $loan['createdAt']
                            ];

                            self::executeDefaulterFine($loan['clientId'], $info);
                        }
                    }

                } elseif ($loan['loanType'] == 'monthly') {
                    $dates = self::getRepaymentsDeadlines($loan['clientId'], $loan['loanDate']);

                    $today = new \DateTime(date('Y-m-d'));
                    $monthOne = new \DateTime($dates['monthOne']);
                    $monthOneRepayment = 0;
                    $m1 = self::totalMonthRepayment($loan['clientId'], $dates['monthOne']);
                    if (!array_key_exists('error', $m1)) {
                        $monthOneRepayment = $m1;
                    }

                    if ($monthOne > $today) {
                        //to get defaulted for month one we compare with latest interest


                        $loanInfo = self::getLatestLoanInfo($loan['id']);
                        if ($monthOneRepayment < (float)$loanInfo['loanInterest']) {
                            $fine = $newLoanBalance = $amountDefaulted = 0;

                            if ($monthOneRepayment > 0) {
                                $amountDefaulted = (float)$loanInfo['loanInterest'] - $monthOneRepayment;
                                $fine = 0.2 * $amountDefaulted;
                                $newLoanBalance = $loanInfo['loanBal'] + $fine;
                            } else {
                                $fine = 0.2 * (float)$loanInfo['loanInterest'];
                                $newLoanBalance = $loanInfo['loanBal'] + $fine;
                            }
                            //compute fine
                            $groupRefNo = ClientController::getId($loan['clientId'])['groupRefNo'];
                            $info = [
                                "fine" => $fine,
                                "newLoanBal" => $newLoanBalance,
                                "clientLoanId" => $loan['clientLoanId'],
                                "loanType" => $loan['loanType'],
                                "groupRefNo" => $groupRefNo,
                                "amountDefaulted" => $amountDefaulted,
                                "createdAt" => $loan['createdAt']
                            ];
                            self::executeDefaulterFine($loan['clientId'], $info);


                        }
                        //compute the new loan balance which includes the fine.
                        //update defaulters table and create instance of defaulters

                    }


                } elseif ($loan['loanType'] == 'long_term') {
                    $dates = self::getRepaymentsDeadlines($loan['clientId'], $loan['loanDate']);

                    $today = new \DateTime(date('Y-m-d'));
                    $deadline = new \DateTime($dates['monthOne']);
                    $totalRepayment = 0;
                    $m1 = self::totalLongTermRepayment($loan['id']);
                    if (!isset($m1['error'])) {
                        $totalRepayment = $m1;
                    }

                    if ($deadline > $today) {
                        //to get defaulted for month one we compare with latest interest


                        $loanInfo = self::getLatestLoanInfo($loan['id']);
                        if ($totalRepayment < (float)$loanInfo['loanInterest']) {
                            $fine = $newLoanBalance = $amountDefaulted = 0;

                            if ($totalRepayment > 0) {
                                $amountDefaulted = (float)$loanInfo['loanInterest'] - $totalRepayment;
                                $fine = 0.2 * $amountDefaulted;
                                $newLoanBalance = $loanInfo['loanBal'] + $fine;
                            } else {
                                $fine = 0.2 * (float)$loanInfo['loanInterest'];
                                $newLoanBalance = $loanInfo['loanBal'] + $fine;
                            }
                            //compute fine
                            $groupRefNo = ClientController::getId($loan['clientId'])['groupRefNo'];
                            $info = [
                                "fine" => $fine,
                                "newLoanBal" => $newLoanBalance,
                                "clientLoanId" => $loan['clientLoanId'],
                                "loanType" => $loan['loanType'],
                                "groupRefNo" => $groupRefNo,
                                "amountDefaulted" => $amountDefaulted,
                                "createdAt" => $loan['createdAt']
                            ];
                            self::executeDefaulterFine($loan['clientId'], $info);


                        }
                    }
                }
            }
        }
    }

    public static function getLoan()
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT * FROM client_loans WHERE  `status`='active'");
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

    public static function totalMonthRepayment($clientId, $date)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            $stmt = $conn->prepare("SELECT SUM(amountPaid) as totalPaid FROM monthly_loan_servicing
                                    WHERE MONTH(datePaid) ='{$month}' AND YEAR(datePaid)='{$year}'
                                     AND clientId=:clientId");
            $stmt->bindParam(":clientId", $clientId);
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

    public static function getLatestLoanInfo($clientLoanId)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT * FROM monthly_loan_servicing
                                    WHERE clientLoanId=:clientLoanId ORDER BY datePaid DESC  LIMIT 1");
            $stmt->bindParam(":clientLoanId", $clientLoanId);
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

    /**
     * @param $clientId
     * @param array $info
     * $info = [
     *          "fine"=>value,
     *          "newLoanBal"=>value,
     *          "clientLoanId"=>"clientLoanId",
     *          "loanType"=>"type of loan",
     *          "groupRefNo"=>value,
     *          "amountDefaulted"=>value
     *          "createdAt"=>"value for created loan createdAt"
     *          ]
     *
     * @return mixed
     */
    public static function executeDefaulterFine($clientId, array $info)
    {
        $db = new DB();
        $conn = $db->connect();
        try {

            $withInterest = self::calculateInterest($info['loanType'], $info['newLoanBal']);
            $interest = $withInterest - $info['newLoanBal'];


            $fine = $info['fine'];
            $principal = $info['newLoanBal'];
            $clientLoanId = $info['clientLoanId'];
            $groupRefNo = $info['groupRefNo'];
            $amountDefaulted = $info['amountDefaulted'];

            $stmt = $conn->prepare("INSERT INTO monthly_loan_servicing(clientId, clientLoanId,
                                    principal,loanInterest, defaulterFine, loanBal, loanCF
                                    )VALUES(
                                    :clientId, :clientLoanId, :principal, :loanInterest,
                                     :defaulterFine, :loanBal, :loanCF)
                                     ");
            $stmt->bindParam(":clientId", $clientId);
            $stmt->bindParam(":clientLoanId", $clientLoanId);
            $stmt->bindParam(":principal", $principal);
            $stmt->bindParam(":loanInterest", $interest);
            $stmt->bindParam(":defaulterFine", $fine);
            $stmt->bindParam(":loanBal", $withInterest);
            $stmt->bindParam(":loanCF", $withInterest);
            if ($stmt->execute()) {
                $defaulter = new Defaulter();
                $defaulter->setClientId($clientId);
                $defaulter->setGroupId($groupRefNo);
                $defaulter->setAmountDefaulted($amountDefaulted);
                $defaulterCtrl = new DefaulterController();
                $created = $defaulterCtrl->create($defaulter);
                if ($created === true) {
                    ClientController::createTransactionLog(array(
                        "amount" => $amountDefaulted,
                        "details" => "Client Set to defaulters list for defaulting Ksh " . $amountDefaulted . " For A loan",
                        "clientId" => $clientId
                    ));
                }
            }
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
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

    public static function checkClientHasActiveLoan($clientId)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("SELECT * FROM client_loans  WHERE clientId=:clientId AND status='active' LIMIT 1");
            $stmt->bindParam(":clientId", $clientId);
            if ($stmt->execute() == 1) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $row;
            } else {
                return [
                    'error' => "Internal Server error"
                ];
            }
        } catch (\PDOException $exception) {
            $exception->getMessage();
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    /**
     * @return array
     * shows the list of clients with loan and their
     * loan balances
     */
    public static function showLoanBalances()
    {
        //Todo: implement logic for showing short term loan balances--completed on 7th Aug
        //todo:implement on the ui
        //todo : allow one to click on loan list and redirect to repayment page. the repayment
        //todo: form will show the current balance as computed from the logic below
        //todo: test this code if its returning correct array data;
        $loans = self::getLoan();
        $data = array();
        foreach ($loans as $loan) {
            $loanType = $loan['loanType'];
            $previousPayment = [];
            if ($loanType == 'long_term') {
                $previousPayment = self::getPreviousLongTermLoan($loan['id']);
                if (is_null($previousPayment['loanCF'])) {
                    $dataItem = array();
                    $dataItem['loanBal'] = $previousPayment['loanBal'];
                    $clientName = ClientController::getId($previousPayment['clientId'])['fullName'];
                    $clientGroup = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                    $dataItem['fullName'] = $clientName;
                    $dataItem['groupName'] = $clientGroup;
                    $dataItem['dateBorrowed'] = $previousPayment['createdAt'];

                    array_push($data, $dataItem);


                } elseif (!is_null($previousPayment['loanCF']) && (float)$previousPayment['loanCF'] > 0) {
                    $deadline = $previousPayment['createdAt'];
                    $previousPaymentDate = $previousPayment['datePaid'];
                    $currentDate = date('Y-m-d');

                    $year1 = date('Y', strtotime($deadline));
                    $year2 = date('Y', strtotime($currentDate));
                    $year3 = date('Y', strtotime($previousPaymentDate));
                    //deadline date not exceeded and repayment will be on the same
                    //year therefore should not attract interest since it was
                    // included in the previous payment.
                    //this will ensure we show correct loan balance.
                    if ($year3 == $year2 && $year2 < $year1) {
                        $dataItem = array();
                        $dataItem['loanBal'] = $previousPayment['loanCF'];
                        $clientName = ClientController::getId($previousPayment['clientId'])['fullName'];
                        $clientGroup = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                        $dataItem['fullName'] = $clientName;
                        $dataItem['groupName'] = $clientGroup;
                        $dataItem['dateBorrowed'] = $previousPayment['createdAt'];
                        array_push($data, $dataItem);
                    }

                    if (($year2 - $year3) == 1 && $year2 < $year1) {
                        //loanCF will include interest since this is new year
                        $interest = self::calculateInterest('long_term', $previousPayment['loanCF']);
                        $dataItem = array();
                        $dataItem['loanBal'] = $interest + $previousPayment['loanCF'];
                        $dataItem['fullName'] = ClientController::getId($previousPayment)['fullName'];
                        $dataItem['groupName'] = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                        $dataItem['dateBorrowed'] = $previousPayment['createdAt'];
                        array_push($data, $dataItem);
                    }
                    if ($year2 == $year1 && $year3 == $year2) {
                        $dataItem = array();
                        $dataItem['loanBal'] = $previousPayment['loanCF'];
                        $dataItem['fullName'] = ClientController::getId($previousPayment)['fullName'];
                        $dataItem['groupName'] = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                        $dataItem['dateBorrowed'] = $previousPayment['createdAt'];
                        array_push($data, $dataItem);
                    }

                }
            } elseif ($loanType == 'trimester') {
                $previousPayment = self::getPreviousRepayment($loan['clientId'], $loan['id']);
                //check if the previous payment loanCF is null, if null then this is the first repayment
                if (is_null($previousPayment['loanCF'])) {
                    $dataItem = array();
                    $dataItem['loanBal'] = $previousPayment['loanBal'];
                    $dataItem['fullName'] = ClientController::getId($previousPayment['clientId'])['fullName'];
                    $dataItem['groupName'] = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                    $dataItem['dateBorrowed'] = $previousPayment['createdAt'];
                    array_push($data, $dataItem);

                } elseif (!is_null($previousPayment['loanCF']) && (float)($previousPayment['loanCF']) > 0) {
                    $currentDate = date('Y-m-d');
                    $previousPaymentDate = $previousPayment['datePaid'];
                    //$repaymentDates = self::getRepaymentsDeadlines($loan['clientId'], $previousPayment['createdAt']);
//                    $deadline1 = date('m', strtotime($repaymentDates['monthOne']));
//                    $deadline2 = date('m', strtotime($repaymentDates['monthTwo']));
//                    $deadline3 = date('m', strtotime($repaymentDates['monthThree']));

                    $curMonth = date('m', strtotime($currentDate));
                    $prevPmtMonth = date('m', strtotime($previousPaymentDate));
                    $year1 = date('Y', strtotime($currentDate));
                    $year2 = date('Y', strtotime($previousPaymentDate));

                    if ($curMonth == $prevPmtMonth && $year1 == $year2) {
                        $dataItem = array();
                        $dataItem['loanBal'] = $previousPayment['loanCF'];
                        $dataItem['fullName'] = ClientController::getId($previousPayment['clientId'])['fullName'];
                        $dataItem['groupName'] = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                        $dataItem['dateBorrowed'] = $previousPayment['createdAt'];
                        array_push($data, $dataItem);

                    }
                    if ($curMonth > $prevPmtMonth && $year1 == $year2) {
                        $interest = self::calculateInterest('trimester', $previousPayment['loanCF']);
                        $dataItem = array();
                        $dataItem['loanBal'] = $interest + $previousPayment['loanCF'];
                        $dataItem['fullName'] = ClientController::getId($previousPayment['clientId'])['fullName'];
                        $dataItem['groupName'] = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                        $dataItem['dateBorrowed'] = $previousPayment['createdAt'];
                        array_push($data, $dataItem);
                    }
                }
            } elseif ($loanType == 'monthly') {
                $previousPayment = self::getPreviousRepayment($loan['clientId'], $loan['id']);
                //check if the previous payment loanCF is null, if null then this is the first repayment
                if (is_null($previousPayment['loanCF'])) {
                    $dataItem = array();
                    $dataItem['loanBal'] = $previousPayment['loanBal'];
                    $dataItem['fullName'] = ClientController::getId($previousPayment['clientId'])['fullName'];
                    $dataItem['groupName'] = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                    $dataItem['dateBorrowed'] = $previousPayment['createdAt'];
                    array_push($data, $dataItem);

                } elseif (!is_null($previousPayment['loanCF']) && (float)($previousPayment['loanCF']) > 0) {
                    $currentDate = date('Y-m-d');
                    $previousPaymentDate = $previousPayment['datePaid'];

                    $curMonth = date('m', strtotime($currentDate));
                    $prevPmtMonth = date('m', strtotime($previousPaymentDate));
                    $year1 = date('Y', strtotime($currentDate));
                    $year2 = date('Y', strtotime($previousPaymentDate));
                    if ($curMonth == $prevPmtMonth && $year1 == $year2) {
                        $dataItem = array();
                        $dataItem['loanBal'] = $previousPayment['loanCF'];
                        $dataItem['fullName'] = ClientController::getId($previousPayment['clientId'])['fullName'];
                        $dataItem['groupName'] = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                        $dataItem['dateBorrowed'] = $previousPayment['createdAt'];
                        array_push($data, $dataItem);

                    }
                    if ($curMonth > $prevPmtMonth && $year1 == $year2) {
                        $dataItem = array();
                        $interest = self::calculateInterest('monthly', $previousPayment['loanCF']);
                        $dataItem['loanBal'] = $interest + $previousPayment['loanCF'];
                        $dataItem['fullName'] = ClientController::getId($previousPayment['clientId'])['fullName'];
                        $dataItem['groupName'] = ClientController::getClientsGroup($previousPayment['clientId'])['groupName'];
                        $dataItem['dateBorrowed'] = $previousPayment['createdAt'];
                        array_push($data, $dataItem);
                    }
                }
            }

        }

        return $data;
    }

}