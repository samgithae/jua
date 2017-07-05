<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 12:03 PM
 */

namespace Hudutech\Controller;


use Hudutech\AppInterface\EmployeeInterface;
use Hudutech\DBManager\DB;
use Hudutech\Entity\Employee;

class EmployeeController implements EmployeeInterface
{
    public function create(Employee $employee)
    {
        $db = new DB();
        $conn = $db->connect();

        $pfNo = $employee->getPfNo();
        $fullName = $employee->getFullName();
        $jobTitle = $employee->getJobTitle();
        $jobGrade = $employee->getJobGrade();
        $idNo = $employee->getIdNo();
        $nssfNo = $employee->getNssfNo();
        $nhifNo = $employee->getNhifNo();
        $kraPin = $employee->getKraPin();
        $remuneration = $employee->getRemuneration();
        $jobDescription = $employee->getJobDescription();
        $qualification = $employee->getQualification();
        $testimonial = $employee->getTestimonial();
        $bankName = $employee->getBankName();
        $bankAccountNo = $employee->getBankAccountNo();
        $postalAddress = $employee->getPostalAddress();
        $email = $employee->getEmail();
        $phoneNumber = $employee->getPhoneNumber();
        $nokName = $employee->getNokName();
        $nokRelationship = $employee->getNokRelationship();
        $nokContact = $employee->getNokContact();
        $dateOfHire = $employee->getDateOfHire();
        $idAttachment = $employee->getIdAttachment();
        $passport=$employee->getPassport();

        try {

            $sql = "INSERT INTO employees(
                                            pfNo,
                                            fullName,
                                            jobTitle,
                                                                                      idNo, 
                                            nssfNo, 
                                            nhifNo,
                                            kraPin,
                                            remuneration,
                                            jobDescription,
                                             jobGrade,
                                            qualification,
                                            testimonial,
                                            bankName,
                                            bankAccountNo,
                                            postalAddress,
                                            email, 
                                            phoneNumber,
                                            nokName, 
                                            nokRelationship,
                                            nokContact,
                                            dateOfHire,
                                            idAttachment,
                                            passport
                                            ) 
                                      VALUES(
                                            :pfNo,
                                            :fullName,
                                            :jobTitle,
                                            
                                            :idNo, 
                                            :nssfNo, 
                                            :nhifNo,
                                            :kraPin,
                                            :remuneration,
                                            :jobDescription,
                                            :jobGrade,
                                            :qualification,
                                            :testimonial,
                                            :bankName,
                                            :bankAccountNo,
                                            :postalAddress,
                                            :email, 
                                            :phoneNumber,
                                            :nokName, 
                                            :nokRelationship,
                                            :nokContact,
                                            :dateOfHire,
                                            :idAttachment,
                                            :passport
                                         )";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":pfNo", $pfNo);
            $stmt->bindParam(":fullName", $fullName);
            $stmt->bindParam(":jobTitle", $jobTitle);
            $stmt->bindParam(":idNo", $idNo);
            $stmt->bindParam(":nssfNo", $nssfNo);
            $stmt->bindParam(":nhifNo", $nhifNo);
            $stmt->bindParam(":kraPin", $kraPin);
            $stmt->bindParam(":remuneration", $remuneration);
            $stmt->bindParam(":jobDescription", $jobDescription);
            $stmt->bindParam(":jobGrade", $jobGrade);
            $stmt->bindParam(":qualification", $qualification);
            $stmt->bindParam(":testimonial", $testimonial);
            $stmt->bindParam(":bankName", $bankName);
            $stmt->bindParam(":bankAccountNo", $bankAccountNo);
            $stmt->bindParam(":postalAddress", $postalAddress);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phoneNumber", $phoneNumber);
            $stmt->bindParam(":nokName", $nokName);
            $stmt->bindParam(":nokRelationship", $nokRelationship);
            $stmt->bindParam(":nokContact", $nokContact);
            $stmt->bindParam(":dateOfHire", $dateOfHire);
            $stmt->bindParam(":idAttachment", $idAttachment);
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

    public function update(Employee $employee, $id)
    {
        $db = new DB();
        $conn = $db->connect();

        $pfNo = $employee->getPfNo();
        $fullName = $employee->getFullName();
        $jobTitle = $employee->getJobTitle();
        $idNo = $employee->getIdNo();
        $nssfNo = $employee->getNssfNo();
        $nhifNo = $employee->getNhifNo();
        $kraPin = $employee->getKraPin();
        $remuneration = $employee->getRemuneration();
        $jobDescription = $employee->getJobDescription();
        $jobGrade = $employee->getJobGrade();
        $qualification = $employee->getQualification();
        $testimonial = $employee->getTestimonial();
        $bankName = $employee->getBankName();
        $bankAccountNo = $employee->getBankAccountNo();
        $postalAddress = $employee->getPostalAddress();
        $email = $employee->getEmail();
        $phoneNumber = $employee->getPhoneNumber();
        $nokName = $employee->getNokName();
        $nokRelationship = $employee->getNokRelationship();
        $nokContact = $employee->getNokContact();
        $dateOfHire = $employee->getDateOfHire();
        $idAttachment = $employee->getIdAttachment();

        try {

            $sql = "UPDATE employees SET
                                        pfNo=:pfNo,
                                        fullName=:fullName,
                                        jobTitle=:jobTitle,
                                        idNo=:idNo, 
                                        nssfNo=:nssfNo, 
                                        nhifNo=:nssfNo,
                                        kraPin=:kraPin,
                                        remuneration=:remuneration,
                                        jobDescription=:jobDescription,
                                        jobGrade=:jobGrade,
                                        qualification=:qualification,
                                        testimonial=:testimonial,
                                        bankName=:bankName,
                                        bankAccountNo=:bankAccountNo,
                                        postalAddress=:postalAddress,
                                        email=:email, 
                                        phoneNumber=:phoneNumber,
                                        nokName=:nokName, 
                                        nokRelationship=:nokRelationship,
                                        nokContact=:nokContact,
                                        dateOfHire=:dateOfHire,
                                        idAttachment=:idAttachment
                                    WHERE 
                                        id=:id
                                    ";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":pfNo", $pfNo);
            $stmt->bindParam(":fullName", $fullName);
            $stmt->bindParam(":jobTitle", $jobTitle);
            $stmt->bindParam(":idNo", $idNo);
            $stmt->bindParam(":nssfNo", $nssfNo);
            $stmt->bindParam(":nhifNo", $nhifNo);
            $stmt->bindParam(":kraPin", $kraPin);
            $stmt->bindParam(":remuneration", $remuneration);
            $stmt->bindParam(":jobDescription", $jobDescription);
            $stmt->bindParam(":jobGrade", $jobGrade);
            $stmt->bindParam(":qualification", $qualification);
            $stmt->bindParam(":testimonial", $testimonial);
            $stmt->bindParam(":bankName", $bankName);
            $stmt->bindParam(":bankAccountNo", $bankAccountNo);
            $stmt->bindParam(":postalAddress", $postalAddress);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phoneNumber", $phoneNumber);
            $stmt->bindParam(":nokName", $nokName);
            $stmt->bindParam(":nokRelationship", $nokRelationship);
            $stmt->bindParam(":nokContact", $nokContact);
            $stmt->bindParam(":dateOfHire", $dateOfHire);
            $stmt->bindParam(":idAttachment", $idAttachment);

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
            $stmt = $conn->prepare("DELETE FROM employees WHERE id=:id");
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
            $stmt = $conn->prepare("DELETE FROM employees");

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

    public static function getEmployeeObject($id)
    {
        $db = new DB();
        $conn = $db->connect();
        try {
            $stmt = $conn->prepare("SELECT e.* FROM employees e WHERE e.id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Employee::class);
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
            $stmt = $conn->prepare("SELECT e.* FROM employees e WHERE 1");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $employees = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $employees;
            }
            else{
                return [];
            }
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    public static function getId($clientId)
    {
        $db = new DB();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("SELECT t.* FROM employees t WHERE t.id=:id");
            $stmt->bindParam(":id", $clientId);
            return $stmt->execute() && $stmt->rowCount() == 1 ? $stmt->fetch(\PDO::FETCH_ASSOC) : [];
        } catch (\PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

}