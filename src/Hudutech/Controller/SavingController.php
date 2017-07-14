<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 11:29 PM
 */

namespace Hudutech\Controller;


use Hudutech\AppInterface\SavingInterface;
use Hudutech\DBManager\DB;
use Hudutech\Entity\Saving;

class SavingController implements SavingInterface
{
    public static function getTotalMonthContribution($clientId)
    {
        $db = new DB();
        $conn = $db->connect();
        $time2 = strtotime(date('Y-m-d'));
        $month2 = date("m", $time2);
        $year2 = date("Y", $time2);
        try {
            $stmt = $conn->prepare("SELECT sum(contribution) as total_contribution FROM savings
                                    WHERE MONTH(datePaid)='{$month2}' AND YEAR(datePaid)='{$year2}'
                                    AND clientId='{$clientId}'");
            if ($stmt->execute()) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                return [];
            }
        } catch (\PDOException $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public static function clearPreviousDumpSaving($id){
        $db = new DB();
        $conn = $db->connect();
        try{
            $stmt = $conn->prepare("UPDATE savings SET dumpedSaving=0 WHERE id=:id");
            $stmt->bindParam(":id", $id);
            return $stmt->execute() ? true : false;
        }catch (\PDOException $exception){
            return['error'=>$exception->getMessage()];
        }
    }

    public function createSingle(Saving $saving)
    {
        $db = new DB();
        $conn = $db->connect();

        $clientId = $saving->getClientId();
        $groupId = $saving->getGroupId();
        $cashReceived = $saving->getCashRecieved();
        $paymentMethod = $saving->getPaymentMethod();
        $datePaid = $saving->getDatePaid();
        $contribution = null;
        $dumpedSaving = null;
        $fine = null;
        $previousSavings = self::getPreviousSavings($clientId);
        $totalMonthContrib = self::getTotalMonthContribution($clientId);
        $totalMonthAmt = 0;

        if (empty($previousSavings['dumpedSaving'])) {

            if ((float)$totalMonthContrib['total_contribution'] >= 0 && $totalMonthContrib['total_contribution'] <= 5000) {
                $totalMonthAmt = (float)$totalMonthContrib['total_contribution'];

                $compareFactor = 5000 - $totalMonthAmt;
                $dumpCompareFactor = $cashReceived - $compareFactor;
                if($dumpCompareFactor == 0 ){

                    $dumpedSaving = 0;
                    $contribution = $cashReceived;

                }elseif($dumpCompareFactor > 0){
                    $dumpedSaving = $dumpCompareFactor;
                    $contribution = $compareFactor;
                } elseif ($dumpCompareFactor< 0){
                    $contribution = $cashReceived;
                    $dumpedSaving = 0;
                }
            }

        } elseif (!empty($previousSavings['dumpedSaving'])) {
            $time1 = strtotime($previousSavings['datePaid']);
            $month1 = date("m", $time1);
            $year1 = date("Y", $time1);

            $time2 = strtotime(date('Y-m-d'));
            $month2 = date("m", $time2);
            $year2 = date("Y", $time2);
            if($year1==$year2 && $month2 > $month1){
                $newCash = $previousSavings['dumpedSaving'] + $cashReceived;
                if($newCash >=5000){
                    $dumpedSaving = $newCash - 5000;
                    $contribution = 5000;
                    //execute function to put previous dump saving to Zero
                    self::clearPreviousDumpSaving($previousSavings['id']);
                } elseif ($newCash<5000){
                    $dumpedSaving = 0;
                    $contribution = $cashReceived;
                }

            }elseif ($year1==$year2 && $month2 == $month1){
                $newCash = $previousSavings['dumpedSaving'] + $cashReceived;
                $dumpedSaving = $newCash;
               $contribution =0;
                self::clearPreviousDumpSaving($previousSavings['id']);
            }
        }


        try {

            $stmt = $conn->prepare("INSERT INTO savings(
                                                        clientId,
                                                        groupId,
                                                        cashReceived,
                                                        contribution,
                                                        paymentMethod,
                                                        datePaid, 
                                                        dumpedSaving,
                                                        fine
                                                        )
                                                VALUES (
                                                        :clientId,
                                                        :groupId,
                                                        :cashReceived,
                                                        :contribution,
                                                        :paymentMethod,
                                                        :datePaid, 
                                                        :dumpedSaving,
                                                        :fine
                                                        )");
            $stmt->bindParam(":clientId", $clientId);
            $stmt->bindParam(":groupId", $groupId);
            $stmt->bindParam(":cashReceived", $cashReceived);
            $stmt->bindParam(":contribution", $contribution);
            $stmt->bindParam(":dumpedSaving", $dumpedSaving);
            $stmt->bindParam(":fine", $fine);
            $stmt->bindParam(":paymentMethod", $paymentMethod);
            $stmt->bindParam(":datePaid", $datePaid);

            if ($stmt->execute()) {
                ClientController::createTransactionLog(
                    array(
                        "clientId" => $clientId,
                        "amount" => $cashReceived,
                        "details" => "Savings Payment"
                    )
                );
                self::updateBalance($clientId, $contribution);
                return true;
            } else {
                return [
                    "error" => "Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                ];
            }

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return ['error' => $exception->getMessage()];
        }
    }

    public function createMultiple(array $savings)
    {
        $db = new DB();
        $conn = $db->connect();

        try {

            $stmt = $conn->prepare("INSERT INTO savings(
                                                        clientId,
                                                        groupId,
                                                        cashReceived,
                                                        contribution,
                                                        dumpedSaving,
                                                        fine,
                                                        paymentMethod,
                                                        datePaid
                                                        )
                                                VALUES (
                                                        :clientId,
                                                        :groupId,
                                                        :cash_recieved,
                                                        :contribution,
                                                        :dumpedSaving,
                                                        :fine,
                                                        :paymentMethod,
                                                        :datePaid
                                                        )");

            foreach ($savings as $saving) {
                $clientId = $saving['clientId'];
                $groupId = $saving['groupId'];
                $cashReceived = (float)$saving['cashReceived'];
                $paymentMethod = $saving['paymentMethod'];
                $dumpedSaving = null;
                $contribution = $cashReceived;
                $fine = null;
                $datePaid = date("Y-m-d h:i:s");
                $previousSavings = self::getPreviousSavings($clientId);
                $totalMonthContrib = self::getTotalMonthContribution($clientId);
                $totalMonthAmt = 0;

                if (empty($previousSavings['dumpedSaving'])) {

                    if ((float)$totalMonthContrib['total_contribution'] >= 0 && $totalMonthContrib['total_contribution'] <= 5000) {
                        $totalMonthAmt = (float)$totalMonthContrib['total_contribution'];

                        $compareFactor = 5000 - $totalMonthAmt;
                        $dumpCompareFactor = $cashReceived - $compareFactor;
                        if($dumpCompareFactor == 0 ){

                            $dumpedSaving = 0;
                            $contribution = $cashReceived;

                        }elseif($dumpCompareFactor > 0){
                            $dumpedSaving = $dumpCompareFactor;
                            $contribution = $compareFactor;
                        } elseif ($dumpCompareFactor< 0){
                            $contribution = $cashReceived;
                            $dumpedSaving = 0;

                        }
                    }

                } elseif (!empty($previousSavings['dumpedSaving'])) {
                    $time1 = strtotime($previousSavings['datePaid']);
                    $month1 = date("m", $time1);
                    $year1 = date("Y", $time1);

                    $time2 = strtotime(date('Y-m-d'));
                    $month2 = date("m", $time2);
                    $year2 = date("Y", $time2);
                    if($year1==$year2 && $month2 > $month1){
                        $newCash = $previousSavings['dumpedSaving'] + $cashReceived;
                        if($newCash >=5000){
                            $dumpedSaving = $newCash - 5000;
                            $contribution = 5000;
                            //execute function to put previous dump saving to Zero
                            self::clearPreviousDumpSaving($previousSavings['id']);
                        } elseif ($newCash<5000){
                            $dumpedSaving = 0;
                            $contribution = $cashReceived;
                        }

                    }elseif ($year1==$year2 && $month2 == $month1){
                        $newCash = $previousSavings['dumpedSaving'] + $cashReceived;
                        $dumpedSaving = $newCash;
                        $contribution =0;
                        self::clearPreviousDumpSaving($previousSavings['id']);
                    }
                }

                $stmt->bindParam(":clientId", $clientId);
                $stmt->bindParam(":groupId", $groupId);
                $stmt->bindParam(":cashReceived", $newContribution);
                $stmt->bindParam(":contribution", $contribution);
                $stmt->bindParam(":dumpedSaving", $dumpedSaving);
                $stmt->bindParam(":fine", $fine);
                $stmt->bindParam(":paymentMethod", $paymentMethod);
                $stmt->bindParam(":datePaid", $datePaid);
                $stmt->execute();
                ClientController::createTransactionLog(
                    array(
                        "clientId" => $clientId,
                        "amount" => $newContribution,
                        "details" => "Savings Payment"
                    )
                );
                self::updateBalance($clientId, $contribution);
            }
            $db->closeConnection();
            return true;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public static function getPreviousSavings($clientId)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("SELECT * FROM savings WHERE clientId=:clientId ORDER BY id DESC LIMIT 1");
            $stmt->bindParam(":clientId", $clientId);
            return $stmt->execute() && $stmt->rowCount() == 1 ? $stmt->fetch(\PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }


    public static function getClientTotalSavings($id)
    {
        $db = new DB();
        $conn = $db->connect();

        try {

            $sql = "(SELECT c.fullName , g.groupName , SUM(s.contribution) as totalSavings FROM
                    clients c , sacco_group g , savings s
                    WHERE c.id = (SELECT s.clientId FROM savings s WHERE s.clientId=:id LIMIT 1)
                    AND g.id = (SELECT s.groupId FROM savings s WHERE c.id = s.clientId LIMIT 1)
                    AND c.id=s.clientId)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $total_saving = array();
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $total_saving = array(
                    "clientName" => $row['fullName'],
                    "groupName" => $row['groupName'],
                    "totalSavings" => $row['totalSavings']
                );
            }
            return $total_saving;
        } catch (\PDOException $exception) {
            return null;
        }
    }

    public static function getGroupTotalSavings($groupId)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $sql = "(SELECT g.groupName, SUM(s.contribution) as totalGroupSavings FROM savings s,
            sacco_group g WHERE s.groupId =(SELECT g.id from sacco_group g WHERE g.id=:groupId LIMIT 1)
            AND s.groupId=g.id)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":groupId", $groupId);

            if ($stmt->execute() && $stmt->rowCount() == 1) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $groupSavings = array(
                    "groupName" => $row['groupName'],
                    "totalGroupSavings" => $row['totalGroupSavings']
                );
                $db->closeConnection();
                return $groupSavings;
            } else {
                return [];
            }


        } catch (\PDOException $exception) {

            echo $exception->getMessage();
            return [];
        }
    }

    public static function showClientSavingsLog($clientId)
    {
        $db = new DB();
        $conn = $db->connect();

        try {

            $sql = "SELECT c.fullName, g.groupName, s.contribution,s.paymentMethod, s.datePaid
                    FROM clients c , sacco_group g, savings s
                    WHERE s.clientId=:clientId AND c.groupRefNo = g.refNo AND s.groupId=g.id ";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":clientId", $clientId);
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $savingsLog = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                $db->closeConnection();
                return $savingsLog;
            } else {
                return [];
            }

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    public static function showGroupSavingsLog()
    {
        $db = new DB();
        $conn = $db->connect();

        try {

            $sql = "((SELECT g.groupName, SUM(s.contribution) as total_group_savings, s.datePaid FROM savings s,
                    sacco_group g  WHERE g.id = s.groupId GROUP BY groupName))";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $groupSavingsLog = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                $db->closeConnection();
                return $groupSavingsLog;
            } else {
                return [];
            }

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    public static function all()
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $sql = "SELECT c.fullName, g.groupName, s.contribution,s.paymentMethod, s.datePaid
                    FROM clients c , sacco_group g, savings s
                    WHERE s.clientId=c.id AND s.groupId=g.id";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $savings = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                $db->closeConnection();
                return $savings;
            } else {
                return [];
            }

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    /**
     *shows total saving for every clients
     */
    public static function clientsTotalSavings()
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $sql = "SELECT  DISTINCT c.fullName, g.groupName, t.balance,t.clientId FROM saving_balances t, sacco_group g, clients c
                    INNER JOIN saving_balances sb ON sb.clientId= c.id WHERE  c.id=t.clientId AND c.groupRefNo=g.refNo";
            $stmt = $conn->prepare($sql);
            return $stmt->execute() && $stmt->rowCount() > 0 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }


    public static function getTodaySaving()
    {
        $db = new DB();
        $conn = $db->connect();
        $sql = "SELECT clientId, groupId, SUM(contribution) as contribution FROM savings WHERE date(datePaid)=CURDATE() GROUP BY clientId;";
        try {
            $stmt = $conn->prepare($sql);
            return $stmt->execute() && $stmt->rowCount() > 0 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];

        }
    }

    public static function updateBalance($clientId, $amount)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("UPDATE saving_balances SET balance = balance + '{$amount}'
                                   WHERE clientId=:clientId");
            $stmt->bindParam(":clientId", $clientId);

            if ($stmt->execute()) {
                $db->closeConnection();
                return true;
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

    public static function withdraw($clientId, $amount)
    {
        $db = new DB();
        $conn = $db->connect();
        $balance = self::checkBalance($clientId);

        try {

            if (!isset($balance['error'])) {

                if ($balance >= $amount && $amount > 0) {
                    $stmt = $conn->prepare("UPDATE saving_balances SET balance = balance - '{$amount}'
                                   WHERE clientId=:clientId");
                    $stmt->bindParam(":clientId", $clientId);

                    if ($stmt->execute()) {
                        $db->closeConnection();
                        ClientController::createTransactionLog(
                            array(
                                "clientId" => $clientId,
                                "amount" => $amount,
                                "details" => "Withdraw of Ksh {$amount} Savings Fund"
                            )
                        );
                        return true;
                    } else {
                        $db->closeConnection();
                        return [
                            "error" => "Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                        ];
                    }
                } else {
                    return ['error' => "Your account does not have sufficient savings"];
                }
            } else {
                return ['error' => "Error Occurred [{$balance['error']}]"];
            }
        } catch (\PDOException $exception) {
            print_r($exception->getMessage());
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    public static function checkBalance($clientId)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT balance FROM saving_balances WHERE clientId=:clientId LIMIT 1");
            $stmt->bindParam(":clientId", $clientId);
            $balance = 0;
            if ($stmt->execute() && $stmt->rowCount() == 1) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $balance = (float)$row['balance'];
                return $balance;

            } elseif ($stmt->rowCount() <= 0) {
                $db->closeConnection();
                return $balance;
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

    public static function createBalance($clientId)
    {
        $db = new DB();
        $conn = $db->connect();
        $groupId = GroupController::getClientGroupId($clientId);

        try {
            $stmt = $conn->prepare("INSERT INTO saving_balances(clientId, groupId) VALUES (:clientId, :groupId)");
            $stmt->bindParam(":clientId", $clientId);
            $stmt->bindParam(":groupId", $groupId);

            if ($stmt->execute()) {
                $db->closeConnection();
                return true;
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

}