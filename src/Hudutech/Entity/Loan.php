<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 5/1/17
 * Time: 11:05 PM
 */

namespace Hudutech\Entity;


class Loan
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $loanType;
    /**
     * @var float
     */
    private $interestRate;
    /**
     * @var float
     */
    private $defaulterFine;
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
    public function getLoanType()
    {
        return $this->loanType;
    }

    /**
     * @param string $loanType
     */
    public function setLoanType($loanType)
    {
        $this->loanType = $loanType;
    }

    /**
     * @return float
     */
    public function getInterestRate()
    {
        return $this->interestRate;
    }

    /**
     * @param float $interestRate
     */
    public function setInterestRate($interestRate)
    {
        $this->interestRate = $interestRate;
    }

    /**
     * @return float
     */
    public function getDefaulterFine()
    {
        return $this->defaulterFine;
    }

    /**
     * @param float $defaulterFine
     */
    public function setDefaulterFine($defaulterFine)
    {
        $this->defaulterFine = $defaulterFine;
    }
}