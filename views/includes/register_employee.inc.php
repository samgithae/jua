<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 26/04/2017
 * Time: 12:49
 */


$successMsg = '';
$errorMsg = '';
if(isset($_POST['first_name'], $_POST['middle_name'], $_POST['last_name'])) {
    $employee = new \Hudutech\Entity\Employee();
    $fullName = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
    $employee-> setPfNo($_POST['pf_no']);
    $employee-> setFullName($fullName);
    $employee-> setJobTitle($_POST['job_title']);
    $employee-> setIdNo($_POST['id_no']);
    $employee-> setKraPin($_POST['kra_pin']);
    $employee-> setNssfNo($_POST['nssf_no']);
    $employee-> setNhifNo($_POST['nhif_no']);
    $employee-> setRemuneration($_POST['remuneration']);
    $employee-> setJobDescription($_POST['job_description']);
    $employee-> setQualification($_POST['qualification']);
    $employee-> setTestimonial($_POST['testimonial']);
    $employee-> setBankName($_POST['bank_name']);
    $employee-> setBankAccountNo($_POST['bank_account_no']);
    $employee-> setPostalAddress($_POST['postal_address']);
    $employee-> setEmail($_POST['email']);
    $employee-> setPhoneNumber($_POST['phone_number']);
    $employee-> setNokName($_POST['nok_name']);
    $employee-> setNokRelationship($_POST['nok_relationship']);
    $employee-> setNokContact($_POST['nok_contact']);


    $employeeControl= new \Hudutech\Controller\EmployeeController();
    $created= $employeeControl->create($employee);


    if ($created) {
        $successMsg .= "Employee details saved successfully";
    } else {
        $errorMsg .= "error occured";

    }







}
else{
    $errorMsg .= "KEY  FIELDS REQUIERED";
}



?>
