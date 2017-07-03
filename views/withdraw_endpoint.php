<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 5/10/17
 * Time: 12:14 AM
 */

require_once __DIR__ . '/../vendor/autoload.php';
use  \Hudutech\Controller\SavingController;

$data = json_decode(file_get_contents('php://input'), true);


if (!empty($data)) {
    $withdrawn = SavingController::withdraw($data['clientId'], (float)$data['amount']);


    if (isset($withdrawn['error'])) {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "Internal Server Error Occurred {$withdrawn['error']}"
        )));
    } else {
        print_r(json_encode(array(
            "statusCode" => 200,
            "message" => "Amount Withdrawn successfully"
        )));
    }
} else {
    print_r(json_encode(array(
        "statusCode" => 500,
        "message" => "All fields required"
    )));
}
