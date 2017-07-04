<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 25/04/2017
 * Time: 11:19
 */
require_once __DIR__.'/../vendor/autoload.php';
include  __DIR__.'/includes/edit_employee.inc.php';
use Hudutech\Controller\ EmployeeController;
$employee = EmployeeController::getId($_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Employee</title>

    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>




<div id="wrapper">
    <?php include_once 'right_menu.php'?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit Employee</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Fill Employee Details


                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-10 col-md-offset-1">
                                <div>
                                    <?php if($errorMsg == '' and $successMsg != '') {?>
                                        <div class="alert alert-success">
                                            <?php echo $successMsg; ?>
                                        </div>
                                    <?php }
                                    elseif($errorMsg != '' and $successMsg == '')
                                    {
                                        ?>
                                        <div class="alert alert-danger">
                                            <?php echo $errorMsg; ?>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                </div>
                                <form class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" METHOD="post" enctype="multipart/form-data">
                                    <fieldset>

                                        <?php
                                        $tokens = explode(" ",trim($employee['fullName']));

                                        if(!empty($tokens[0])) {
                                            $first_name = $tokens[0];
                                        }
                                        else
                                        {
                                            $first_name ="";
                                        }
                                        if(!empty($tokens[1])) {
                                            $middle_name = $tokens[1];
                                        }
                                        else
                                        {
                                            $middle_name ="";
                                        }
                                        if(!empty($tokens[2])) {
                                            $last_name = $tokens[2];
                                        }
                                        else
                                        {
                                            $last_name ="";
                                        }

                                        ?>

                                        <!-- Form Name -->
                                        <legend>Personal Information Details</legend>

                                        <!-- Text input-->
                                        <div class="form-group">

                                            <div class="col-sm-4">
                                                <label for="first_name">First Name</label>

                                                <input type="text" name="first_name" value="<?php echo $first_name ?> " placeholder="First Name" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="middle_name">Middle Name</label>
                                                <input type="text" name="middle_name" id="middle_name" value="<?php echo $middle_name ?> " placeholder="Middle Name" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" name="last_name" id="last_name" value="<?php echo $last_name ?> " placeholder="Last Name" class="form-control">
                                            </div>
                                            <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                                        </div>



                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label for="pf_no">Personal file number</label>
                                                <input type="text" name="pf_no" id="pf_no" value="<?php echo $employee['pfNo'] ?> " placeholder="Personal file number (PF No)" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="id_no">Identity card number</label>
                                                <input type="text" name="id_no" id="id_no" value="<?php echo $employee['idNo'] ?> " placeholder="Identity card number" class="form-control">
                                            </div>

                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">

                                            <div class="col-sm-4">
                                                <label for="kra_pin">KRA Pin Number</label>
                                                <input type="text" name="kra_pin" id="kra_pin" value="<?php echo $employee['kraPin'] ?> " placeholder="KRA Pin Number" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="">NSSF Number</label>
                                                <input type="text" name="nssf_no" id="nssf_no" value="<?php echo $employee['nssfNo'] ?> " placeholder="NSSF Number" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="nhif_no">NHIF Number</label>
                                                <input type="text" name="nhif_no" id="nhif_no" value="<?php echo $employee['nhifNo'] ?> " placeholder="NHIF Number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <div class="col-sm-6">
                                            <label for="idAttachment">Id Copy</label>
                                            <input type="file" name="idAttachment" id="idAttachment"  class="form-control" accept="image/*">
                                        </div>

                                            <div class="col-sm-6">
                                                <label for="passport">Passport Photo</label>
                                                <input type="file" name="passport" id="passport" class="form-control" accept="image/*">
                                            </div>
                                        </div>


                                        <legend>Contact Information Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">

                                            <div class="col-sm-4">
                                                <label for="phone_number">Phone Number</label>
                                                <input type="text" name="phone_number" value="<?php echo $employee['phoneNumber'] ?> " placeholder="Phone Number" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="email">Email</label>
                                                <input type="text" name="email" value="<?php echo $employee['email'] ?> " placeholder="Email" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="postal_address">Postal Address</label>
                                                <input type="text" name="postal_address" placeholder="Postal address" value="<?php echo $employee['postalAddress'] ?> " class="form-control">
                                            </div>
                                        </div>

                                        <!-- Address Section -->
                                        <!-- Form Name -->
                                        <legend>Job Details</legend>
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <label for="job_title">Job title</label>
                                                <input type="text" name="job_title" id="job_title" placeholder="Job title" value="<?php echo $employee['jobTitle'] ?> " class="form-control">
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="job_grade">Job Grade</label>
                                                <input type="text" name="job_grade" id="job_grade" placeholder="Job Grade" value="<?php echo $employee['jobGrade'] ?> " class="form-control">
                                            </div>
                                        </div>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <label for="dateOfHire">Date of Hire</label>
                                                <input placeholder="Date of Hire" name="dateOfHire" id="dateOfHire" value="<?php echo $employee['dateOfHire'] ?> " class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" >
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="remuneration">Remuneration</label>
                                                <input type="number" name="remuneration" id="remuneration" value="<?php echo $employee['remuneration'] ?> " placeholder="Remuneration" class="form-control">
                                            </div>
                                        </div>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <label for="">Job description</label>
                                                <textarea placeholder="Job description" cols="10" rows="2" class="form-control" id="job_description" name="job_description" ><?php echo $employee['jobDescription'] ?> </textarea>
                                            </div>
                                        </div>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <label for="">Qualifications</label>
                                                <textarea placeholder="Qualifications" cols="10" rows="2" class="form-control" id="qualification" name="qualification" ><?php echo $employee['qualification'] ?></textarea>
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <label for="testimonial">Testimonials</label>
                                                <textarea placeholder="Testimonials" cols="10" rows="2" class="form-control"  id="testimonial" name="testimonial" ><?php echo $employee['testimonial'] ?></textarea>
                                            </div>
                                        </div>

                                        <!-- Parent/Guadian Contact Section -->
                                        <!-- Form Name -->
                                        <legend>Bank Account Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <label for="bank_name">Bank Name</label>
                                                <input type="text" name="bank_name" id="bank_name" placeholder="Bank Name" value="<?php echo $employee['bankName'] ?> " class="form-control">
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="bank_account_no">Account Number</label>
                                                <input type="text" name="bank_account_no" id="bank_account_no" value="<?php echo $employee['bankAccountNo'] ?> " placeholder="Account Number" class="form-control">
                                            </div>

                                        </div>


                                        <!-- Emergency Contact Section -->
                                        <!-- Form Name -->
                                        <legend>Next of kin  Information</legend>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <label for="nok_name">Full Name</label>
                                                <input type="text" name="nok_name" id="nok_name" placeholder="Full Name" value="<?php echo $employee['nokName'] ?> " class="form-control">
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="">Relationship</label>
                                                <input type="text" name="nok_relationship" value="<?php echo $employee['nokRelationship'] ?> " placeholder="Relationship" class="form-control">
                                            </div>

                                        </div>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <label for="nok_contact">Contact</label>
                                                <input type="text" name="nok_contact" id="nok_contact" value="<?php echo $employee['nokContact'] ?> " placeholder="Contact" class="form-control">
                                            </div>


                                        </div>


                                        <!-- Command -->
                                        <div class="form-group">
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-danger">Cancel</button>

                                                    <input type="submit" class="btn btn-primary" value="Save">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            </div><!-- /.col-lg-12 -->
                        </div><!-- /.row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--start menu-->
<?php
include 'footer.php';
?>

</body>
</html>