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

    public static function getClientGroupId($clientId){
        $db = new DB();
        $conn = $db->connect();
        try{
            $stmt = $conn->prepare("SELECT g.id FROM sacco_group g, clients c
              INNER JOIN sacco_group sg  ON sg.refNo = c.groupRefNo WHERE
              c.groupRefNo=g.refNo AND c.id=:clientId;");
            $stmt->bindParam(":clientId", $clientId);

            if($stmt->execute() && $stmt->rowCount() > 0){
                return $stmt->fetch(\PDO::FETCH_ASSOC)['id'];
            }else{
                return [
                    'error'=>"Internal Server Error Occurred"
                ];
            }
        }catch (\PDOException $e){
            return [
                "error"=>$e->getMessage()
            ];
        }
    }
    public static function getGroupShares($groupId){
        $db = new DB();
        $conn = $db->connect();
        try{
            $stmt = $conn->prepare("SELECT SUM(balance) as savings FROM saving_balances WHERE groupId=:groupId");
            $stmt->bindParam(":groupId", $groupId);
            return $stmt->execute() && $stmt->rowCount() > 0  ? $stmt->fetch(\PDO::FETCH_ASSOC)['savings'] : null;
        }catch (\PDOException $e){
            return ['error'=>$e->getMessage()];
        }
    }
    public static function getAdvance($groupId){

    }
    public static function getGroupBanking($groupId){

    }
    public static function getGroupTRF($groupId){

    }
    public static function getGroupInterest($groupId){

    }
    public static function getGroupOfficeDebt($groupId){

    }
    public static function showStats(){

    }

}