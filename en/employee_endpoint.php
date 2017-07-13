<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 05/07/2017
 * Time: 10:27
 */
include_once '../vendor/autoload.php';
$requestMethod = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);
if ($requestMethod == 'DELETE') {
if (!empty($data['id'])) {
$deleted= \Hudutech\Controller\EmployeeController::delete($data['id']);
if ($deleted) {
print_r(json_encode(array(
"statusCode" => 204,
"message" => "Client Deleted!"
)));
} else {
print_r(json_encode(
array(
"statusCode" => 500,
"message" => "error occurred while deleting the employee please try again later"
)
));
}
}
else{
print_r(json_encode(
array(
"statusCode" => 500,
"message" => "Failed to fetch patient info!"
)
));
}
}
?>
