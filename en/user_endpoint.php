<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 13/07/2017
 * Time: 10:31
 */
require_once __DIR__ . '/../vendor/autoload.php';
use \Hudutech\Controller\UserController;

$data = json_decode(file_get_contents('php://input'), true);
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'DELETE') {
    global $data;
    $deleted = \Hudutech\Controller\UserController::delete($data['id']);
    if ($deleted) {
        print_r(json_encode(array(
            "statusCode" => 204,
            "message" => "Inventory Deleted!."
        )));
    } else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "Error occurred While Deleting.."
        )));
    }
}