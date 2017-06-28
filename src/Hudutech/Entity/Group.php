<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 11:59 AM
 */

namespace Hudutech\Entity;


class Group
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $groupName;
    /**
     * @var string
     */
    private $refNo;
    /**
     * @var string
     */
    private $region;
    /**
     * @var string
     */
    private $officialContact;
    /**
     * @var string
     */
    private $monthlyMeetingSchedule;
    /**
     * @var \DateTime
     */
    private $dateFormed;

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
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string
     */
    public function getRefNo()
    {
        return $this->refNo;
    }

    /**
     * @param string $refNo
     */
    public function setRefNo($refNo)
    {
        $this->refNo = $refNo;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getOfficialContact()
    {
        return $this->officialContact;
    }

    /**
     * @param string $officialContact
     */
    public function setOfficialContact($officialContact)
    {
        $this->officialContact = $officialContact;
    }

    /**
     * @return string
     */
    public function getMonthlyMeetingSchedule()
    {
        return $this->monthlyMeetingSchedule;
    }

    /**
     * @param string $monthlyMeetingSchedule
     */
    public function setMonthlyMeetingSchedule($monthlyMeetingSchedule)
    {
        $this->monthlyMeetingSchedule = $monthlyMeetingSchedule;
    }

    /**
     * @return \DateTime
     */
    public function getDateFormed()
    {
        return $this->dateFormed;
    }

    /**
     * @param \DateTime $dateFormed
     */
    public function setDateFormed($dateFormed)
    {
        $this->dateFormed = $dateFormed;
    }


}