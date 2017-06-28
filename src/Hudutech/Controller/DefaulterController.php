<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 12:04 PM
 */

namespace Hudutech\Controller;

use Hudutech\AppInterface\DefaulterInterface;
use Hudutech\DBManager\DB;
use Hudutech\Entity\Defaulter;

class DefaulterController implements DefaulterInterface
{
    public function create(Defaulter $defaulter)
    {
        $db = new DB();
        $conn = $db->connect();
        $clientId = $defaulter->getClientId();
        $groupId = $defaulter->getGroupId();
        $amountDefaulted = $defaulter->getAmountDefaulted();

        try {
            $stmt = $conn->prepare("INSERT INTO defaulters(
                                                            clientId,
                                                            groupId,
                                                            amountDefaulted
                                                          ) 
                                                    VALUES
                                                     (
                                                        :clientId,
                                                        :groupId,
                                                        :amountDefaulted
                                                     )");
            $stmt->bindParam(":clientId", $clientId);
            $stmt->bindParam(":groupId", $groupId);
            $stmt->bindParam(":amountDefaulted", $amountDefaulted);

            return $stmt->execute() ? true : false;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }

    }

    public function update(Defaulter $defaulter, $id)
    {
        $db = new DB();
        $conn = $db->connect();
        $clientId = $defaulter->getClientId();
        $groupId = $defaulter->getGroupId();
        $amountDefaulted = $defaulter->getAmountDefaulted();

        try {
            $stmt = $conn->prepare("UPDATE defaulters SET  
                                                            clientId:=clientId,
                                                            groupId:=groupId,
                                                            amountDefaulted:=amountDefaulted
                                                      WHERE id=:id
                                  ");

            $stmt->bindParam(":clientId", $clientId);
            $stmt->bindParam(":groupId", $groupId);
            $stmt->bindParam(":amountDefaulted", $amountDefaulted);

            return $stmt->execute() ? true : false;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public static function delete($id)
    {
        $db = new DB();
        $conn = $db->connect();

        try {

            $stmt = $conn->prepare("DELETE FROM defaulters WHERE id=:id");
            $stmt->bindParam(":id", $id);
            return $stmt->execute() ? true : false;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public static function destroy()
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("DELETE FROM defaulters");
            return $stmt->execute() ? true : false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public static function getDefaulterObject($id)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("SELECT d.* FROM defaulters d WHERE d.id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Defaulter::class);
            return $stmt->execute() && $stmt->rowCount() == 1 ? $stmt->fetch() : null;

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return null;
        }

    }

    public static function all()
    {
        $db = new DB();
        $conn = $db->connect();

        try{
            $stmt = $conn->prepare("SELECT d.* FROM defaulters d WHERE  1");
            $stmt->execute();
            if ($stmt->rowCount() > 0){
               $defaulters = $stmt->fetchAll(\PDO::FETCH_ASSOC);
               $db->closeConnection();
               return $defaulters;
            }
            else{
                return [];
            }

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

}