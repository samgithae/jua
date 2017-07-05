<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 05/07/2017
 * Time: 13:19
 */

namespace Hudutech\AppInterface;



interface TransactionLogInterface
{

    public static function all();
    public static function clientLog($clientId);

}