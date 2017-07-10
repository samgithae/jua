<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 25/04/2017
 * Time: 11:19
 */
require_once __DIR__.'/../vendor/autoload.php';
include  __DIR__.'/includes/register_client.inc.php';

$groups = \Hudutech\Controller\GroupController::all();


//Todo add default values in the form to avoid retyping during form resubmission on error
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register Client</title>

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
                <h1 class="page-header">Register New Client</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Client Information

                    </div>
                    <div class="panel-body">
                        <div class="row">
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
                            <div class="col-md-10 col-md-offset-1">
                                <form class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" METHOD="post" enctype="multipart/form-data">
                                    <fieldset>

                                        <!-- Form Name -->
                                        <legend>Personal Information Details</legend>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label for="first_name">First Name <span style="color: red">* <?php echo $firstNameErr?></span></label>
                                                <input type="text" name="first_name" id="first_name" value="<?php echo isset($_POST['first_name'])? $_POST['first_name'] : '' ?>" placeholder="First Name" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="middle_name">Middle Name <span style="color: red">* <?php echo $middleNameErr ?></span></label>
                                                <input type="text" name="middle_name" id="middle_name" placeholder="Middle Name" value="<?php echo isset($_POST['middle_name'])? $_POST['middle_name'] : ''?>" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="last_name">Last Name <span style="color: red">* <?php echo $lastNameErr?></span></label>
                                                <input type="text" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo isset($_POST['last_name'])? $_POST['last_name'] : ''?>" class="form-control">
                                            </div>
                                        </div>



                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label for="membership_no">Membership Number</label>
                                                <input type="text" name="membership_no" id="membership_no" placeholder="Membership Number" value="<?php echo isset($_POST['membership_no'])? $_POST['membership_no'] : ''?>" class="form-control">
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="id_no">Identity card number <span style="color: red">* <?php echo $idNoErr?></span></label>
                                                <input type="text" name="id_no" id="id_no" placeholder="Identity card number" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="kra_pin">KRA Pin Number <span style="color: red">* <?php echo $kraPinErr ?></span></label>
                                                <input type="text" name="kra_pin" id="kra_pin" placeholder="KRA Pin Number" class="form-control">
                                            </div>




                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label for="dob">Date Of Birth <span style="color: red">* <?php echo $dobErr?></span></label>

                                                <input placeholder="Date Of Birth" name="dob" id="dob"  class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo isset($_POST['dob'])? $_POST['dob'] : ''?>">
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="date_enrolled">Date of enrollment</label>
                                                <input placeholder="Date of enrollment" name="date_enrolled" id="date_enrolled" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo isset($_POST['date_enrolled'])? $_POST['date_enrolled'] : ''?>" >
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="occupation">Occupation <span style="color: red">* <?php echo $occupationErr?></span></label>
                                                <input type="text" name="occupation" id="occupation" placeholder="Occupation" value="<?php echo isset($_POST['occupation'])? $_POST['occupation'] : ''?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label for="passport">Passport <span style="color: red">*</span></label>
                                                <input type="file" name="passport" id="passport" class="form-control" accept="image/*">
                                            </div>
                                        </div>



                                        <legend>Contact Information Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">

                                            <div class="col-sm-4">
                                                <label for="phone_number">Phone Number <span style="color: red">* <?php echo $phoneNumberErr?></span></label>
                                                <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" value="<?php echo isset($_POST['phone_number'])? $_POST['phone_number'] : ''?>" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="email">Email</label>
                                                <input type="text" name="email" id="email" placeholder="Email" value="<?php echo isset($_POST['email'])? $_POST['email'] : ''?>" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="postal_address">Postal address</label>
                                                <input type="text" name="postal_address" id="postal_address" value="<?php echo isset($_POST['postal_address'])? $_POST['postal_address'] : ''?>" placeholder="Postal address" class="form-control">
                                            </div>
                                        </div>
                                        <!--                text input-->
                                        <div class="form-group">
                                            <div class="col-sm-8">
                                                <label for="emergency_contact">Emergency contacts <span style="color: red">* <?php echo $emergencyContactErr ?></span></label>
                                                <input type="text" name="emergency_contact" id="emergency_contact" value="<?php echo isset($_POST['emergency_contact'])? $_POST['emergency_contact'] : ''?>" placeholder="Emergency contacts (not group members)" class="form-control">
                                            </div>
                                        </div>

                                        <legend>Resident Information Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">

                                            <div class="col-sm-4">
                                                <label for="county">County <span style="color: red">* <?php echo $countyErr?></span></label>
                                                <input type="text" name="county" id="county" value="<?php echo isset($_POST['county'])? $_POST['county'] : ''?>" placeholder="County" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="sub_county">Sub County <span style="color: red">* <?php echo $subCountyErr?></span></label>
                                                <input type="text" name="sub_county" id="sub_county"  placeholder="Sub County" value="<?php echo isset($_POST['sub_county'])? $_POST['sub_county'] : ''?>" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="location">Location <span style="color: red">* <?php echo $locationErr?></span></label>
                                                <input type="text" name="location" id="location" placeholder="Location" value="<?php echo isset($_POST['location'])? $_POST['location'] : ''?>" class="form-control">
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">

                                            <div class="col-sm-4">
                                                <label for="sub_location">Sub Location <span style="color: red">* <?php echo $subCountyErr?></span></label>
                                                <input type="text" name="sub_location" id="sub_location" placeholder="Sub Location" value="<?php echo isset($_POST['sub_location'])? $_POST['sub_location'] : ''?>" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="village">village/estate</label>
                                                <input type="text" name="village" id="village" placeholder="village/estate" class="form-control">
                                            </div>

                                        </div>

                                        <!-- Form Name -->
                                        <legend>Next of kin  Information</legend>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label for="nok_name">Full Name</label>
                                                <input type="text" name="nok_name" id="nok_name" value="<?php echo isset($_POST['nok_name'])? $_POST['nok_name'] : ''?>"" placeholder="Full Name" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="nok_contact">Contact</label>
                                                <input type="text" name="nok_contact" id="nok_contact" value="<?php echo isset($_POST['nok_contact'])? $_POST['nok_contact'] : ''?>" placeholder="Contact" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="nok_relationship">Relationship</label>
                                                <input type="text" name="nok_relationship" id="nok_relationship" value="<?php echo isset($_POST['nok_relationship'])? $_POST['nok_relationship'] : ''?>" placeholder="Relationship" class="form-control">
                                            </div>

                                        </div>

                                        <!-- Address Section -->
                                        <!-- Form Name -->
                                        <legend>Expectation Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <label for="expectation">Expectation</label>
                                                <textarea placeholder="Expectation" cols="10" rows="3" class="form-control" id="expectation" name="expectation"></textarea>
                                            </div>
                                        </div>

                                        <!-- Parent/Guadian Contact Section -->
                                        <!-- Form Name -->
                                        <legend>Group Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-5">
                                                <label for="group_ref_no">Select Group</label>
                                                <select name="group_ref_no" id="group_ref_no" class="form-control">
                                                    <option>--Select Group here--</option>
                                                    <?php foreach ($groups as $group): ?>
                                                        <option value="<?php echo $group['refNo']?>"><?php echo $group['groupName']?></option>
                                                    <?php endforeach ?>

                                                </select>
                                            </div>


                                        </div>



                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" name="is_member_of_other_org" id="is_member_of_other_org" data-toggle="modal" data-target="#sibling"> Member of other organization ?
                                            </div>
                                        </div>



                                        <!-- Command -->
                                        <div class="form-group">
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="pull-right">
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                    <input type="reset" class="btn btn-danger" value="Cancel">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
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