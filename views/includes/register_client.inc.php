<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 26/04/2017
 * Time: 10:22
 */

require_once __DIR__.'/../../vendor/autoload.php';

$successMsg = '';
$errorMsg = '';
if(isset($_POST['first_name'], $_POST['middle_name'], $_POST['last_name'])) {
    $client = new \Hudutech\Entity\Client();
    $fullName = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
    $client->setGroupRefNo($_POST['group_ref_no']);
    $client->setFullName($fullName);
    $client->setMembershipNo($_POST['membership_no']);
    $client-> setIdNo($_POST['id_no']);
    $client-> setKraPin($_POST['kra_pin']);
    $client-> setDob($_POST['dob']);
    $client-> setOccupation($_POST['occupation']);
    $client-> setPostalAddress($_POST['postal_address']);
    $client-> setEmail($_POST['email']);
    $client-> setPhoneNumber($_POST['phone_number']);
    $client-> setCounty($_POST['county']);
    $client-> setSubCounty($_POST['sub_county']);
    $client-> setLocation($_POST['location']);
    $client-> setSubLocation($_POST['sub_location']);
    $client-> setVillage($_POST['village']);
    $client-> setEmergencyContact($_POST['emergency_contact']);
    if(isset($_POST['is_member_of_other_org'])){
        $client-> setMemberOfOtherOrg('YES');
    }else{
        $client-> setMemberOfOtherOrg('NO');
    }


    $client-> setExpectation($_POST['expectation']);
    $client-> setNokName($_POST['nok_name']);
    $client-> setDateEnrolled($_POST['date_enrolled']);
    $client-> setNokContact($_POST['nok_contact']);
    $client-> setNokRelationShip($_POST['nok_relationship']);



    $clientCtrl = new \Hudutech\Controller\ClientController();
    $created = $clientCtrl->create($client);

    if ($created) {
        $successMsg .= "Client details saved successfully";
    } else {
        $errorMsg .= "error occured";

    }
}
else{
    $errorMsg .= "KEY  FIELDS REQUIERED";
}
?>