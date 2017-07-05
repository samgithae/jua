<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 05/07/2017
 * Time: 12:56
 */
namespace Hudutech\Controller;
use Hudutech\DBManager\DB;
use Hudutech\AppInterface\TransactionLogInterface;

class TransactionLogController implements TransactionLogInterface{

    public static function all(){

        $db= new DB();
        $conn=$db->connect();

        try{
            $stmt= $conn->prepare("select t.* , c.fullName,g.groupName from transactions_log t,clients c ,sacco_group g where 
             t.clientId=c.id AND g.refNo=c.groupRefNo");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $transactionLog = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $transactionLog;

            } else {
                return [];
            }
        }
        catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }


    public static function clientLog($clientId)
    {
        $db= new DB();
        $conn=$db->connect();

        try{
            $stmt= $conn->prepare("select t.* , c.fullName,g.groupName from transactions_log t,clients c ,sacco_group g where 
            t.clientId=:clientId AND t.clientId=c.id AND g.refNo=c.groupRefNo");
            $stmt->bindParam(":clientId", $clientId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $transactionLog = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $transactionLog;

            } else {
                return [];
            }
        }
        catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }
}