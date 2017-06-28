<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 9:21 PM
 */

namespace Hudutech\Entity;


class Saving
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var integer
     */
    private $clientId;
    /**
     * @var integer
     */
    private $groupId;
    /**
     * @var float
     */
    private $cashRecieved;
    /**
     * @var float
     */
    private $contribution;
    /**
     * @var string
     */
    private $paymentMethod;
    /**
     * @var mixed
     */
    private $datePaid;

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
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return float
     */
    public function getCashRecieved()
    {
        return $this->cashRecieved;
    }

    /**
     * @param float $cashRecieved
     */
    public function setCashRecieved($cashRecieved)
    {
        $this->cashRecieved = $cashRecieved;
    }

    /**
     * @return float
     */
    public function getContribution()
    {
        return $this->contribution;
    }

    /**
     * @param float $contribution
     */
    public function setContribution($contribution)
    {
        $this->contribution = $contribution;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return \DateTime
     */
    public function getDatePaid()
    {
        return $this->datePaid;
    }

    /**
     * @param  $datePaid
     */
    public function setDatePaid($datePaid)
    {
        $this->datePaid = $datePaid;
    }
}