<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 5/1/17
 * Time: 11:10 PM
 */

namespace Hudutech\AppInterface;


use Hudutech\Entity\Loan;

interface LoanInterface
{
    public function create(Loan $loan);
    public function update(Loan $loan, $id);
    public static function getId($id);
    public static function all();
    public static function getLoanObject($id);
    public  static function lendShortTermLoan($clientId, $loanId, $amount);
    public static function getPreviousRepayment($clientId, $clientLoanId);
    public static function markLoanCleared($clientId, $clientLoanId);
    public static function serviceLoan($clientId, $clientLoanId, $amount);

}