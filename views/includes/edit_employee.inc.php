<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 26/04/2017
 * Time: 12:49
 */

use Hudutech\Services\FileUploader;

$successMsg = '';
$errorMsg = '';
if($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['first_name'], $_POST['middle_name'], $_POST['last_name'])) {
        $employee = new \Hudutech\Entity\Employee();
        $fullName = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
        $employee->setPfNo($_POST['pf_no']);
        $employee->setFullName($fullName);
        $employee->setJobTitle($_POST['job_title']);
        $employee->setIdNo($_POST['id_no']);
        $employee->setKraPin($_POST['kra_pin']);
        $employee->setNssfNo($_POST['nssf_no']);
        $employee->setNhifNo($_POST['nhif_no']);
        $employee->setRemuneration($_POST['remuneration']);
        $employee->setJobDescription($_POST['job_description']);
        $employee->setJobGrade($_POST['job_grade']);
        $employee->setQualification($_POST['qualification']);
        $employee->setTestimonial($_POST['testimonial']);
        $employee->setBankName($_POST['bank_name']);
        $employee->setBankAccountNo($_POST['bank_account_no']);
        $employee->setPostalAddress($_POST['postal_address']);
        $employee->setEmail($_POST['email']);
        $employee->setPhoneNumber($_POST['phone_number']);
        $employee->setNokName($_POST['nok_name']);
        $employee->setNokRelationship($_POST['nok_relationship']);
        $employee->setNokContact($_POST['nok_contact']);
        $employee->setDateOfHire($_POST['dateOfHire']);

        if (isset($_FILES['passport'])) {
            $uploader = new FileUploader('image');
            $target_dir = 'uploads/passports/';
            // $target_dir = 'uploads/';


//name of the form input
            $form_name = 'passport';
            $fileUploaded = $uploader->uploadFile($target_dir, $form_name);
            if ($fileUploaded) {
//retrieve the file path
                $file_url = $uploader->getFilePath();
//use the file_url to set the value for db column
                $employee->setPassport($file_url);

            }
        } else {
            //$client->setPassport(null);
            $errorMsg .= "passport not uploaded";
        }

        if (isset($_FILES['idAttachment'])) {
            $uploader = new FileUploader('image');
            $target_dir = 'uploads/ids/';
            // $target_dir = 'uploads/';


//name of the form input
            $form_name = 'idAttachment';
            $fileUploaded = $uploader->uploadFile($target_dir, $form_name);
            if ($fileUploaded) {
//retrive the file path
                $file_url = $uploader->getFilePath();
//use the file_url to set the value for db column
                $employee->setIdAttachment($file_url);

            }
        } else {
            //$client->setPassport(null);
            $errorMsg .= "Id attachment not uploaded";
        }


        $employeeControl = new \Hudutech\Controller\EmployeeController();

        $created = $employeeControl->update($employee,$_POST['id']);


        if ($created === true) {
           // $successMsg .= "Client details saved successfully";
            echo "<script type='text/javascript'>
              alert('updated successfully!');
              window.location.href='employee.php';
              
              </script>";
        } elseif (array_key_exists('error', $created)) {
           // $errorMsg .= "{$created['error']}";
            echo "<script type='text/javascript'>
              alert('Error occured please try again later');
              window.location.href='employee.php';
              
              </script>";
        }


    } else {
        $errorMsg .= "KEY  FIELDS REQUIERED";
    }

}
?>
