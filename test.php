<?php
require_once __DIR__.'/vendor/autoload.php';


use Hudutech\Controller\ClientController;

$client = ClientController::getClientObject(1);
$client->setPassport('uploads/se.jpg');
print_r($client);

$ctrl = new ClientController();
if($ctrl->update($client, 1)){
    echo "did well";
}

//echo $client->getPassport();



