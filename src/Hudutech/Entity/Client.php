<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 11:59 AM
 */

namespace Hudutech\Entity;


class Client
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $groupRefNo;
    /**
     * @var string
     */
    private $fullName;
    /**
     * @var string
     */
    private $membershipNo;
    /**
     * @var integer
     */
    private $idNo;

    /**
     * @var string
     */
    private $kraPin;
    /**
     * @var \DateTime
     */
    private $dob;
    /**
     * @var string
     */
    private $occupation;
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
    private $county;
    /**
     * @var string
     */
    private $subCounty;
    /**
     * @var string
     */
    private $location;
    /**
     * @var string
     */
    private $subLocation;
    /**
     * @var string
     */
    private $village;
    /**
     * @var string
     */
    private $emergencyContact;
    /**
     * @var string
     */
    private $memberOfOtherOrg;
    /**
     * @var string
     */
    private $expectation;
    /**
     * @var string
     */
    private $nokName;
    /**
     * @var string
     */
    private $nokRelationShip;
    /**
     * @var string
     */
    private $nokContact;

    /**
     * @var string
     */
    private $dateEnrolled;
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
    public function getGroupRefNo()
    {
        return $this->groupRefNo;
    }

    /**
     * @param string $groupRefNo
     */
    public function setGroupRefNo($groupRefNo)
    {
        $this->groupRefNo = $groupRefNo;
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
    public function getMembershipNo()
    {
        return $this->membershipNo;
    }

    /**
     * @param string $membershipNo
     */
    public function setMembershipNo($membershipNo)
    {
        $this->membershipNo = $membershipNo;
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
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param string $dob
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
    }

    /**
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param string $occupation
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
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
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @param string $county
     */
    public function setCounty($county)
    {
        $this->county = $county;
    }

    /**
     * @return string
     */
    public function getSubCounty()
    {
        return $this->subCounty;
    }

    /**
     * @param string $subCounty
     */
    public function setSubCounty($subCounty)
    {
        $this->subCounty = $subCounty;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getSubLocation()
    {
        return $this->subLocation;
    }

    /**
     * @param string $subLocation
     */
    public function setSubLocation($subLocation)
    {
        $this->subLocation = $subLocation;
    }

    /**
     * @return string
     */
    public function getVillage()
    {
        return $this->village;
    }

    /**
     * @param string $village
     */
    public function setVillage($village)
    {
        $this->village = $village;
    }

    /**
     * @return string
     */
    public function getEmergencyContact()
    {
        return $this->emergencyContact;
    }

    /**
     * @param string $emergencyContact
     */
    public function setEmergencyContact($emergencyContact)
    {
        $this->emergencyContact = $emergencyContact;
    }

    /**
     * @return string
     */
    public function getMemberOfOtherOrg()
    {
        return $this->memberOfOtherOrg;
    }

    /**
     * @param string $memberOfOtherOrg
     */
    public function setMemberOfOtherOrg($memberOfOtherOrg)
    {
        $this->memberOfOtherOrg = $memberOfOtherOrg;
    }

    /**
     * @return string
     */
    public function getExpectation()
    {
        return $this->expectation;
    }

    /**
     * @param string $expectation
     */
    public function setExpectation($expectation)
    {
        $this->expectation = $expectation;
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
    public function getNokRelationShip()
    {
        return $this->nokRelationShip;
    }

    /**
     * @param string $nokRelationShip
     */
    public function setNokRelationShip($nokRelationShip)
    {
        $this->nokRelationShip = $nokRelationShip;
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
     * @return \DateTime
     */
    public function getDateEnrolled()
    {
        return $this->dateEnrolled;
    }

    /**
     * @param \DateTime $dateEnrolled
     */
    public function setDateEnrolled($dateEnrolled)
    {
        $this->dateEnrolled = $dateEnrolled;
    }

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
}
