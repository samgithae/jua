<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 7/11/17
 * Time: 4:09 PM
 */

namespace Hudutech\Controller;


use Hudutech\DBManager\DB;

trait GroupStats
{

    public static function getClientGroupId($clientId)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT g.id FROM sacco_group g, clients c
              INNER JOIN sacco_group sg  ON sg.refNo = c.groupRefNo WHERE
              c.groupRefNo=g.refNo AND c.id=:clientId;");
            $stmt->bindParam(":clientId", $clientId);

            if ($stmt->execute() && $stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC)['id'];
            } else {
                return [
                    'error' => "Internal Server Error Occurred"
                ];
            }
        } catch (\PDOException $e) {
            return [
                "error" => $e->getMessage()
            ];
        }
    }

    public static function getGroupShares($groupId)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT SUM(balance) AS savings FROM saving_balances WHERE groupId=:groupId");
            $stmt->bindParam(":groupId", $groupId);
            return $stmt->execute() && $stmt->rowCount() > 0 ? $stmt->fetch(\PDO::FETCH_ASSOC)['savings'] : null;
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function getAdvance($groupId)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT SUM(loanAmount) AS advance FROM client_loans WHERE MONTH(loanDate) = MONTH(CURDATE())-1 AND 
                                groupId=:groupId AND loanType='monthly' OR loanType='trimester' AND `status`='active'");
            $stmt->bindParam(":groupId", $groupId);
            if ($stmt->execute() && $stmt->rowCount() == 1) {
                $advance = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $advance['advance'];
            } else {
                return [
                    "error" => "Internal Server Error Occurred"
                ];
            }
        } catch (\PDOException $e) {
            return [
                "error" => $e->getMessage()
            ];
        }

    }

    public static function getLoans($groupId)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT SUM(loanAmount) AS total_loan FROM client_loans WHERE `status`='active'
                                    AND groupId=:groupId");
            $stmt->bindParam(":groupId", $groupId);

            if ($stmt->execute() && $stmt->rowCount() == 1) {
                return $stmt->fetch(\PDO::FETCH_ASSOC)['total_loan'];
            } else {
                return ['error' => "Internal Server Error Occurred"];
            }
        } catch (\PDOException $exception) {

            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    public static function getGroupBanking($groupId)
    {
        $loans = self::getLoans($groupId);
        $shares = self::getGroupShares($groupId);
        return (float)($shares - $loans);
    }

    public static function getGroupTRF($groupId)
    {
        $loans = self::getLoans($groupId);
        $banking = self::getGroupBanking($groupId);
        $trf = $loans + $banking;
        return (float)($trf);

    }

    public static function getGroupOfficeDebt($groupId)
    {
        $loans = self::getLoans($groupId);
        $shares = self::getGroupShares($groupId);
        $office_debt = 0;
        if ($loans > $shares) {
            $office_debt = $loans - $shares;
        }
        return $office_debt;
    }

    public static function getGroupInterest($groupId)
    {
        $groupTRF = self::getGroupTRF($groupId);
        $shares = self::getGroupShares($groupId);
        $office_debt = self::getGroupOfficeDebt($groupId);
        $interest = (float)($groupTRF - $shares - $office_debt);
        return $interest;
    }

    public static function showStats()
    {
        $groups = GroupController::all();
        $data = [];
        foreach ($groups as $group) {
            $dataItem = array(
                "groupName" => GroupController::getId($group['id'])['groupName'],
                "shares" => self::getGroupShares($group['id']),
                "advance"=>self::getAdvance($group['id']),
                "loans" => self::getLoans($group['id']),
                "groupTRF" => self::getGroupTRF($group['id']),
                "banking" => self::getGroupBanking($group['id']),
                "interest" => self::getGroupInterest($group['id']),
                "officeDebt" => self::getGroupOfficeDebt($group['id'])
            );
            array_push($data, $dataItem);
        }
        return $data;
    }

}