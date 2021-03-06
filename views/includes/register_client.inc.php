<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 26/04/2017
 * Time: 10:22
 */

require_once __DIR__ . '/../../vendor/autoload.php';
use Hudutech\Services\FileUploader;

$successMsg = $errorMsg = $firstNameErr = $groupRefNoErr = $middleNameErr =
$lastNameErr = $idNoErr = $kraPinErr = $dobErr = $occupationErr =
$phoneNumberErr = $countyErr = $subCountyErr = $locationErr =
$subLocationErr = $emergencyContactErr =
$membershipNoErr= $dateEnrolledErr=$nokContactErr=$nokNameErr= '';

$firstName = $groupRefNo = $middleName =
$lastName = $idNo = $kraPin = $dob = $occupation =
$phoneNumber = $county = $subCounty = $location =
$subLocation = $emergencyContact = $membershipNo=
$dateEnrolled = $nokName=$nokContact='';


function cleanInput($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['first_name'] == '') {
        $firstNameErr = 'First Name  required';
    } else {
        $firstName = cleanInput($_POST['first_name']);
    }
    if ($_POST['middle_name'] == '') {
        $middleNameErr = 'Middle Name required';
    } else {
        $middleName = cleanInput($_POST['middle_name']);
    }
    if ($_POST['last_name'] == '') {
        $lastNameErr = 'Last Name  Required';
    }else{
        $lastName = cleanInput($_POST['last_name']);
    }

    if ($_POST['id_no'] == '') {
        $idNoErr = 'ID NO   required';
    } else {
        $idNo = cleanInput($_POST['id_no']);
    }

    if ($_POST['group_ref_no'] == '') {
        $groupRefNoErr = 'Group Ref Number  is required';
    } else {
        $groupRefNo = cleanInput($_POST['group_ref_no']);
    }
    if ($_POST['occupation'] == '') {
        $occupationErr = 'Occupation Required';
    } else {
        $occupation = cleanInput($_POST['occupation']);
    }
    if ($_POST['phone_number'] == '') {
        $phoneNumberErr = 'Phone Number required';
    } else {
        $phoneNumber = cleanInput($_POST['phone_number']);
    }
    if ($_POST['county'] == '') {
        $countyErr = 'County is required';
    } else {
        $county = cleanInput($_POST['county']);
    }
    if ($_POST['sub_county'] == '') {
        $subCountyErr = 'Sub County  required';
    } else {
        $subCounty = cleanInput($_POST['sub_county']);
    }
    if ($_POST['location'] == '') {
        $locationErr = 'Location  required';
    } else {
        $location = cleanInput($_POST['location']);
    }
    if ($_POST['sub_location'] == '') {
        $subLocationErr = 'Sub Location  Required';
    } else {
        $subLocation = cleanInput($_POST['sub_location']);
    }
    if ($_POST['emergency_contact'] == '') {
        $emergencyContactErr = 'Emergency Contact  is required';
    } else {
        $emergencyContact = cleanInput($_POST['emergency_contact']);
    }

    if($_POST['kra_pin'] == ''){
        $kraPinErr = "Kra Pin  Required";
    }
    else{
        $kraPin = cleanInput($_POST['kra_pin']);
    }

    if($_POST['membership_no'] == ''){
        $membershipNoErr = 'Membership Number Required';
    }else{
        $membershipNo = cleanInput($_POST['membership_no']);
    }

    if($_POST['dob'] == ''){
        $dobErr = "Date Of Birth Required";
    }else{
        $dob = cleanInput($_POST['dob']);
    }

    if($_POST['date_enrolled'] == ''){
        $dateEnrolledErr = 'Date Enrolled Required';
    }else{
        $dateEnrolled = cleanInput($_POST['date_enrolled']);
    }
    if($_POST['nok_name'] == ''){
        $nokNameErr = 'This field is required';
    }else{
        $nokName = cleanInput($_POST['nok_name']);
    }
    if($_POST['nok_contact'] == ''){
        $nokContactErr = 'This Field Is required';
    }else{
        $nokContact = cleanInput($_POST['nok_contact']);
    }




    if ($firstNameErr != '' && $groupRefNoErr != '' && $middleNameErr != '' &&
        $lastNameErr != '' && $idNoErr != '' && $kraPinErr != '' && $dobErr != '' &&
        $occupationErr != '' && $phoneNumberErr != '' && $countyErr != '' && $subCountyErr != ''
        && $locationErr != '' && $subLocationErr != '' && $emergencyContactErr != '' && $membershipNoErr!=''
        &&$nokNameErr !='' && $nokContactErr != '' && $dateEnrolledErr != ''
    ) {
        $client = new \Hudutech\Entity\Client();
        $fullName = $firstName . " " . $middleName . " " . $lastName;
        $client->setGroupRefNo($groupRefNo);
        $client->setFullName($fullName);
        $client->setMembershipNo(cleanInput($_POST['membership_no']));
        $client->setIdNo($idNo);
        $client->setKraPin($kraPin);
        $client->setDob($dob);
        $client->setOccupation($occupation);
        $client->setPostalAddress(cleanInput($_POST['postal_address']));
        $client->setEmail(cleanInput($_POST['email']));
        $client->setPhoneNumber($phoneNumber);
        $client->setCounty($county);
        $client->setSubCounty($subCounty);
        $client->setLocation($location);
        $client->setSubLocation($subLocation);
        $client->setVillage(cleanInput($_POST['village']));
        $client->setEmergencyContact($emergencyContact);
        if (isset($_POST['is_member_of_other_org'])) {
            $client->setMemberOfOtherOrg('YES');
        } else {
            $client->setMemberOfOtherOrg('NO');
        }


        if (isset($_FILES['passport'])) {
            $uploader = new FileUploader('image');
            $target_dir = 'uploads/passports/';
            // $target_dir = 'uploads/';


//name of the form input
            $form_name = 'passport';
            $fileUploaded = $uploader->uploadFile($target_dir, $form_name);
            if ($fileUploaded) {
//retrive the file path
                $file_url = $uploader->getFilePath();
//use the file_url to set the value for db column
                $client->setPassport($file_url);

            }
        } else {
            //$client->setPassport(null);
            $errorMsg .= "pic not uploaded";
        }

        $client->setExpectation($_POST['expectation']);
        $client->setNokName($_POST['nok_name']);
        $client->setDateEnrolled($_POST['date_enrolled']);
        $client->setNokContact($_POST['nok_contact']);
        $client->setNokRelationShip($_POST['nok_relationship']);


        $clientCtrl = new \Hudutech\Controller\ClientController();
        $created = $clientCtrl->create($client);

        if ($created === true) {
            $successMsg .= "Client details saved successfully";
        } elseif (array_key_exists('error', $created)) {
            $errorMsg .= "{$created['error']}";

        }
    } else {
        $errorMsg .= "Please Correct the Errors Below to Continue";
    }
}
?>