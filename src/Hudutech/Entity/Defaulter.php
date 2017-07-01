<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 11:59 AM
 */

namespace Hudutech\Entity;


class Defaulter
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
    private $amountDefaulted;

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
     * @param mixed $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return float
     */
    public function getAmountDefaulted()
    {
        return $this->amountDefaulted;
    }

    /**
     * @param float $amountDefulted
     */
    public function setAmountDefaulted($amountDefulted)
    {
        $this->amountDefaulted = $amountDefulted;
    }

}