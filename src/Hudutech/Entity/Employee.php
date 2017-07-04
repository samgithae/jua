<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 11:58 AM
 */
namespace Hudutech\Entity;


class Employee
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $pfNo;
    /**
     * @var string
     */
    private $fullName;
    /**
     * @var string
     */
    private $jobTitle;
    /**
     * @var integer
     */
    private $idNo;
    /**
     * @var string
     */
    private $nssfNo;
    /**
     * @var string
     */
    private $nhifNo;
    /**
     * @var string
     */
    private $kraPin;
    /**
     * @var float
     */
    private $remuneration;
    /**
     * @var string
     */
    private $jobDescription;
    /**
     * @var string
     */ private $jobGrade;

    /**
     * @return string
     */
    public function getJobGrade()
    {
        return $this->jobGrade;
    }

    /**
     * @param string $jobGrade
     */
    public function setJobGrade($jobGrade)
    {
        $this->jobGrade = $jobGrade;
    }
    /**
     * @var string
     */
    private $qualification;
    /**
     * @var string
     */
    private $testimonial;
    /**
     * @var string
     */
    private $bankName;
    /**
     * @var string
     */
    private $bankAccountNo;
    /**
     * @var string
     */
    private $postalAddress;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $phoneNumber;
    /**
     * @var string
     */
    private $nokName;
    /**
     * @var string
     */
    private $nokRelationship;
    /**
     * @var string
     */
    private $nokContact;
    /**
     * @var string
     */
    private $dateOfHire;
    /**
     * @var string
     */
    private $idAttachment;

    /**
     * @return string
     */
    public function getPassport()
    {
        return $this->passport;
    }

    /**
     * @param string $passport
     */
    public function setPassport($passport)
    {
        $this->passport = $passport;
    }
    /**
     * @var string
     */
    private $passport;
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPfNo()
    {
        return $this->pfNo;
    }

    /**
     * @param string $pfNo
     */
    public function setPfNo($pfNo)
    {
        $this->pfNo = $pfNo;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * @param string $jobTitle
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    /**
     * @return int
     */
    public function getIdNo()
    {
        return $this->idNo;
    }

    /**
     * @param int $idNo
     */
    public function setIdNo($idNo)
    {
        $this->idNo = $idNo;
    }

    /**
     * @return string
     */
    public function getNssfNo()
    {
        return $this->nssfNo;
    }

    /**
     * @param string $nssfNo
     */
    public function setNssfNo($nssfNo)
    {
        $this->nssfNo = $nssfNo;
    }

    /**
     * @return string
     */
    public function getNhifNo()
    {
        return $this->nhifNo;
    }

    /**
     * @param string $nhifNo
     */
    public function setNhifNo($nhifNo)
    {
        $this->nhifNo = $nhifNo;
    }

    /**
     * @return string
     */
    public function getKraPin()
    {
        return $this->kraPin;
    }

    /**
     * @param string $kraPin
     */
    public function setKraPin($kraPin)
    {
        $this->kraPin = $kraPin;
    }

    /**
     * @return float
     */
    public function getRemuneration()
    {
        return $this->remuneration;
    }

    /**
     * @param float $remuneration
     */
    public function setRemuneration($remuneration)
    {
        $this->remuneration = $remuneration;
    }

    /**
     * @return string
     */
    public function getJobDescription()
    {
        return $this->jobDescription;
    }

    /**
     * @param string $jobDescription
     */
    public function setJobDescription($jobDescription)
    {
        $this->jobDescription = $jobDescription;
    }

    /**
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * @param string $qualification
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;
    }

    /**
     * @return string
     */
    public function getTestimonial()
    {
        return $this->testimonial;
    }

    /**
     * @param string $testimonial
     */
    public function setTestimonial($testimonial)
    {
        $this->testimonial = $testimonial;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @param string $bankName
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
    }

    /**
     * @return string
     */
    public function getBankAccountNo()
    {
        return $this->bankAccountNo;
    }

    /**
     * @param string $bankAccountNo
     */
    public function setBankAccountNo($bankAccountNo)
    {
        $this->bankAccountNo = $bankAccountNo;
    }

    /**
     * @return string
     */
    public function getPostalAddress()
    {
        return $this->postalAddress;
    }

    /**
     * @param string $postalAddress
     */
    public function setPostalAddress($postalAddress)
    {
        $this->postalAddress = $postalAddress;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getNokName()
    {
        return $this->nokName;
    }

    /**
     * @param string $nokName
     */
    public function setNokName($nokName)
    {
        $this->nokName = $nokName;
    }

    /**
     * @return string
     */
    public function getNokRelationship()
    {
        return $this->nokRelationship;
    }

    /**
     * @param string $nokRelationship
     */
    public function setNokRelationship($nokRelationship)
    {
        $this->nokRelationship = $nokRelationship;
    }

    /**
     * @return string
     */
    public function getNokContact()
    {
        return $this->nokContact;
    }

    /**
     * @param string $nokContact
     */
    public function setNokContact($nokContact)
    {
        $this->nokContact = $nokContact;
    }


    /**
     * @return string
     */
    public function getDateOfHire()
    {
        return $this->dateOfHire;
    }

    /**
     * @param string $dateOfHire
     */
    public function setDateOfHire($dateOfHire)
    {
        $this->dateOfHire = $dateOfHire;
    }

    /**
     * @return string
     */
    public function getIdAttachment()
    {
        return $this->idAttachment;
    }

    /**
     * @param string $idAttachment
     */
    public function setIdAttachment($idAttachment)
    {
        $this->idAttachment = $idAttachment;
    }


}
