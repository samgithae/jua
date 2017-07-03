<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 12:03 PM
 */

namespace Hudutech\Controller;


use Hudutech\AppInterface\ClientInterface;
use Hudutech\DBManager\ComplexQuery;
use Hudutech\DBManager\DB;
use Hudutech\Entity\Client;

class ClientController extends ComplexQuery implements ClientInterface
{
    public function create(Client $client)
    {
        $db = new DB();
        $conn = $db->connect();
        $groupRefNo = $client->getGroupRefNo();
        $fullName = $client->getFullName();
        $membershipNo = $client->getMembershipNo();
        $idNo = $client->getIdNo();
        $kraPin = $client->getKraPin();
        $dob = $client->getDob();
        $occupation = $client->getOccupation();
        $postalAddress = $client->getPostalAddress();
        $email = $client->getEmail();
        $phoneNumber = $client->getPhoneNumber();
        $county = $client->getCounty();
        $subCounty = $client->getSubCounty();
        $location = $client->getLocation();
        $subLocation = $client->getSubLocation();
        $village = $client->getVillage();
        $emergencyContact = $client->getEmergencyContact();
        $isMemberOfOtherOrg = $client->getMemberOfOtherOrg();
        $expectation = $client->getExpectation();
        $nokName = $client->getNokName();
        $nokRelationship = $client->getNokRelationShip();
        $nokContact = $client->getNokContact();
        $dateEnrolled = $client->getDateEnrolled();
        $passport =  $client->getPassport();

        try {

            $sql = "INSERT INTO clients(
                                            groupRefNo,
                                            fullName,
                                            membershipNo,
                                            idNo,
                                            kraPin,
                                            dob,
                                            occupation,
                                            postalAddress,
                                            email,
                                            phoneNumber,
                                            county,
                                            subCounty,
                                            location,
                                            subLocation,
                                            village,
                                            emergencyContact,
                                            isMemberOfOtherOrg,
                                            expectation,
                                            nokName,
                                            nokRelationship,
                                            dateEnrolled,
                                            nokContact,
                                            passport
                                        )
                                    VALUES (
                                            :groupRefNo,
                                            :fullName,
                                            :membershipNo,
                                            :idNo,
                                            :kraPin,
                                            :dob,
                                            :occupation,
                                            :postalAddress,
                                            :email,
                                            :phoneNumber,
                                            :county,
                                            :subCounty,
                                            :location,
                                            :subLocation,
                                            :village,
                                            :emergencyContact,
                                            :isMemberOfOtherOrg,
                                            :expectation,
                                            :nokName,
                                            :nokRelationship,
                                            :dateEnrolled,
                                            :nokContact,
                                            :passport
                                        )";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":groupRefNo", $groupRefNo);
            $stmt->bindParam(":fullName", $fullName);
            $stmt->bindParam(":membershipNo", $membershipNo);
            $stmt->bindParam(":idNo", $idNo);
            $stmt->bindParam(":kraPin", $kraPin);
            $stmt->bindParam(":dob", $dob);
            $stmt->bindParam(":occupation", $occupation);
            $stmt->bindParam(":postalAddress", $postalAddress);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phoneNumber", $phoneNumber);
            $stmt->bindParam(":county", $county);
            $stmt->bindParam(":subCounty", $subCounty);
            $stmt->bindParam(":location", $location);
            $stmt->bindParam(":subLocation", $subLocation);
            $stmt->bindParam(":village", $village);
            $stmt->bindParam(":emergencyContact", $emergencyContact);
            $stmt->bindParam(":isMemberOfOtherOrg", $isMemberOfOtherOrg);
            $stmt->bindParam(":expectation", $expectation);
            $stmt->bindParam(":nokName", $nokName);
            $stmt->bindParam(":nokRelationship", $nokRelationship);
            $stmt->bindParam(":dateEnrolled", $dateEnrolled);
            $stmt->bindParam(":nokContact", $nokContact);
            $stmt->bindParam(":passport", $passport);

            if($stmt->execute()){

                SavingController::createBalance($conn->lastInsertId());
                $db->closeConnection();
                return true;
            }else{
                $db->closeConnection();
                return [
                    "error"=>"Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                ];
            }
        } catch (\PDOException $exception) {
            print_r($exception->getMessage());
            return [
                'error'=>$exception->getMessage()
            ];
        }
    }

    public function update(Client $client, $id)
    {
        $db = new DB();
        $conn = $db->connect();
        $groupRefNo = $client->getGroupRefNo();
        $fullName = $client->getFullName();
        $membershipNo = $client->getMembershipNo();
        $idNo = $client->getIdNo();
        $kraPin = $client->getKraPin();
        $dob = $client->getDob();
        $occupation = $client->getOccupation();
        $postalAddress = $client->getPostalAddress();
        $email = $client->getEmail();
        $phoneNumber = $client->getPhoneNumber();
        $county = $client->getCounty();
        $subCounty = $client->getSubCounty();
        $location = $client->getLocation();
        $subLocation = $client->getSubLocation();
        $village = $client->getVillage();
        $emergencyContact = $client->getEmergencyContact();
        $isMemberOfOtherOrg = $client->getMemberOfOtherOrg();
        $expectation = $client->getExpectation();
        $nokName = $client->getNokName();
        $nokRelationship = $client->getNokRelationShip();
        $nokContact = $client->getNokContact();
        $dateEnrolled = $client->getDateEnrolled();
<<<<<<< HEAD
        $passport = $client->getPassport();
=======
        $passport=$client->getPassport();
>>>>>>> 0f00284e7c6af27f78d54df4cd667845d3da7dd0

        try {

            $sql = "UPDATE clients SET
                                    groupRefNo=:groupRefNo,
                                    fullName=:fullName,
                                    membershipNo=:membershipNo,
                                    idNo=:idNo,
                                    kraPin=:kraPin,
                                    dob=:dob,
                                    occupation=:occupation,
                                    postalAddress=:postalAddress,
                                    email=:email,
                                    phoneNumber=:phoneNumber,
                                    county=:county,
                                    subCounty=:subCounty,
                                    location=:location,
                                    subLocation=:subLocation,
                                    village=:village,
                                    emergencyContact=:emergencyContact,
                                    isMemberOfOtherOrg=:isMemberOfOtherOrg,
                                    expectation=:expectation,
                                    nokName=:nokName,
                                    nokRelationship=:nokRelationship,
                                    dateEnrolled=:dateEnrolled,
                                    nokContact=:nokContact,
                                    passport=:passport
                            WHERE
                                id=:id
                            ";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":groupRefNo", $groupRefNo);
            $stmt->bindParam(":fullName", $fullName);
            $stmt->bindParam(":membershipNo", $membershipNo);
            $stmt->bindParam(":idNo", $idNo);
            $stmt->bindParam(":kraPin", $kraPin);
            $stmt->bindParam(":dob", $dob);
            $stmt->bindParam(":occupation", $occupation);
            $stmt->bindParam(":postalAddress", $postalAddress);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phoneNumber", $phoneNumber);
            $stmt->bindParam(":county", $county);
            $stmt->bindParam(":subCounty", $subCounty);
            $stmt->bindParam(":location", $location);
            $stmt->bindParam(":subLocation", $subLocation);
            $stmt->bindParam(":village", $village);
            $stmt->bindParam(":emergencyContact", $emergencyContact);
            $stmt->bindParam(":isMemberOfOtherOrg", $isMemberOfOtherOrg);
            $stmt->bindParam(":expectation", $expectation);
            $stmt->bindParam(":nokName", $nokName);
            $stmt->bindParam(":nokRelationship", $nokRelationship);
            $stmt->bindParam(":dateEnrolled", $dateEnrolled);
            $stmt->bindParam(":nokContact", $nokContact);
            $stmt->bindParam(":passport", $passport);
            if($stmt->execute()){
                $db->closeConnection();
                return true;
            }else{
                $db->closeConnection();
                return [
                    "error"=>"Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                ];
            }
        } catch (\PDOException $exception) {
            print_r($exception->getMessage());
            return [
                'error'=>$exception->getMessage()
            ];
        }
    }

    public static function delete($id)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("DELETE FROM clients WHERE id=:id");
            $stmt->bindParam(":id", $id);
            if($stmt->execute()){
                $db->closeConnection();
                return true;
            }else{
                $db->closeConnection();
                return [
                    "error"=>"Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                ];
            }
        } catch (\PDOException $exception) {
            print_r($exception->getMessage());
            return [
                'error'=>$exception->getMessage()
            ];
        }
    }

    public static function destroy()
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("DELETE FROM clients");
            if($stmt->execute()){
                $db->closeConnection();
                return true;
            }else{
                $db->closeConnection();
                return [
                    "error"=>"Error Occurred:=> [{$stmt->errorInfo()[0]} {$stmt->errorInfo()[1]}  {$stmt->errorInfo()[2]}]"
                ];
            }
        } catch (\PDOException $exception) {
            print_r($exception->getMessage());
            return [
                'error'=>$exception->getMessage()
            ];
        }
    }

    public static function getId($clientId)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("SELECT t.* FROM clients t WHERE t.id=:id");
            $stmt->bindParam(":id", $clientId);
            return $stmt->execute() && $stmt->rowCount() == 1 ? $stmt->fetch(\PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }


    public static function getClientObject($id)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("SELECT c.* FROM clients c WHERE c.id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Client::class);
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

        try {
            $stmt = $conn->prepare("SELECT c.* FROM clients c WHERE 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $clients = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $clients;

            } else {
                return [];
            }

        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }

    }

    public static function getShortTermLoanLimit($clientId)
    {
        $savings = SavingController::checkBalance($clientId);

        $loanLimit = (float)($savings['totalSavings'] * 3);
        return $loanLimit;
    }

    public static function getLongTermLoanLimit($clientId)
    {
        $savings = SavingController::checkBalance($clientId);

        $loanLimit = (float)($savings['totalSavings'] * 2.5);
        return $loanLimit;
    }

    /**
     * @param array $config
     * @return boolean
     * $config => array("amount"=>val, "details"=>val, "clientId"=>val)
     */
    public static function createTransactionLog(array $config)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("INSERT INTO transactions_log(amount, details, clientId)
                                    VALUES(:amount, :details, :clientId)");
            $stmt->bindParam(":amount", $config['amount']);
            $stmt->bindParam(":details", $config['details']);
            $stmt->bindParam(":clientId", $config['clientId']);
            return $stmt->execute() ? true : false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return false;
        }
    }

    public static function getClientTransactionLog($clientId)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $sql = "SELECT c.fullName, l.amount, l.details, l.transaction_date
                      FROM clients c, transactions_log l
                      WHERE l.clientId=:clientId AND l.clientId=c.id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":clientId", $clientId);
            return $stmt->execute() ? true : false;
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];

        }
    }

}
