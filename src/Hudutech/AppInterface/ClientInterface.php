<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/25/17
 * Time: 12:00 PM
 */

namespace Hudutech\AppInterface;


use Hudutech\Entity\Client;

interface ClientInterface
{
    /**
     * @param Client $client
     * @return mixed
     */
    public function create(Client $client);

    /**
     * @param Client $client
     * @param $id
     * @return boolean
     */
    public function update(Client $client, $id);

    /**
     * @param $id
     * @return boolean
     */
    public static function delete($id);

    /**
     * @return boolean
     */
    public static function destroy();

    /**
     * @param $id
     * @return object|null
     */
    public static function getClientObject($id);

    /**
     * @param $clientId
     * @return array
     */
    public static function getId($clientId);

    /**
     * @return array
     */
    public static function all();

    /**
     * @param $clientId
     * @return float
     */
    public static function getShortTermLoanLimit($clientId);
    
    /**
     * @param $clientId
     * @return float
     */
    public static function getLongTermLoanLimit($clientId);

    /**
     * @param array $config
     * @return boolean
     * $config => array("amount"=>val, "details"=>val, "clientId"=>val)
     *
     */
    public static function createTransactionLog(array $config);

    /**
     * @param $clientId
     * @return array
     */
    public static function getClientTransactionLog($clientId);


}