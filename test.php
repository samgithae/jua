<?php
require_once __DIR__.'/vendor/autoload.php';

<<<<<<< HEAD

use Hudutech\Controller\ClientController;

$client = ClientController::getClientObject(1);
$client->setPassport('uploads/se.jpg');
print_r($client);

$ctrl = new ClientController();
if($ctrl->update($client, 1)){
    echo "did well";
}

//echo $client->getPassport();



=======
print_r(Hudutech\Controller\ClientController::getClientObject(56));
>>>>>>> 0f00284e7c6af27f78d54df4cd667845d3da7dd0
