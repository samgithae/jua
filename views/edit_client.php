<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 25/04/2017
 * Time: 11:19
 */
require_once __DIR__.'/../vendor/autoload.php';
include  __DIR__.'/includes/edit_client.inc.php';
use \Hudutech\Controller\GroupController;
use \Hudutech\Controller\ClientController;
$groups = GroupController::all();
$client=ClientController::getId($_GET['id']);



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Client</title>

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
                <h1 class="page-header">Edit Client Information</h1>
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
                                <form class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" METHOD="post" enctype="multipart/form-data">
                                    <fieldset>

                                        <!-- Form Name -->
                                        <legend>Personal Information Details</legend>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <?php
                                            $tokens = explode(" ",trim($client['fullName']));

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


                                            <div class="col-sm-4">
                                                <label for="first_name">First Name</label>
                                                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="id">
                                                <input type="text" name="first_name" id="first_name" value="<?php echo  $first_name ?>" placeholder="First Name" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="middle_name">Middle Name</label>
                                                <input type="text" name="middle_name" id="middle_name" placeholder="Middle Name" value="<?php echo $middle_name ?>"class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $last_name ?>" class="form-control">
                                            </div>
                                        </div>



                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label for="membership_no">Membership Number</label>
                                                <input type="text" name="membership_no" value="<?php echo $client['membershipNo'] ?>" id="membership_no" placeholder="Membership Number" class="form-control">
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="id_no">Identity card number</label>
                                                <input type="text" name="id_no" id="id_no" value="<?php echo $client['idNo'] ?>" placeholder="Identity card number" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="kra_pin">KRA Pin Number</label>
                                                <input type="text" name="kra_pin" id="kra_pin" value="<?php echo $client['kraPin'] ?>" placeholder="KRA Pin Number" class="form-control">
                                            </div>




                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label for="dob">Date Of Birth</label>

                                                <input placeholder="Date Of Birth" name="dob" id="dob" value="<?php echo $client['dob']?>" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" >
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="date_enrolled">Date of enrollment</label>
                                                <input placeholder="Date of enrollment" name="date_enrolled" value="<?php echo $client['dateEnrolled'] ?>" id="date_enrolled" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" >
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="occupation">Occupation</label>
                                                <input type="text" name="occupation" id="occupation" value="<?php echo $client['occupation'] ?>" placeholder="Occupation" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label for="passport">Passport</label>
                                                <input type="file" name="passport" id="passport" value="<?php echo $client['passport'] ?>" class="form-control" accept="image/*">
                                            </div>
                                        </div>



                                        <legend>Contact Information Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">

                                            <div class="col-sm-4">
                                                <label for="phone_number">Phone Number</label>
                                                <input type="text" name="phone_number" id="phone_number" value="<?php echo $client['phoneNumber'] ?>" placeholder="Phone Number" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="email">Email</label>
                                                <input type="text" name="email" id="email" value="<?php echo  $client['email']?>" placeholder="Email" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="postal_address">Postal address</label>
                                                <input type="text" name="postal_address" id="postal_address" value="<?php echo $client['postalAddress']?>" placeholder="Postal address" class="form-control">
                                            </div>
                                        </div>
                                        <!--                text input-->
                                        <div class="form-group">
                                            <div class="col-sm-8">
                                                <label for="emergency_contact">Emergency contacts</label>
                                                <input type="text" name="emergency_contact" id="emergency_contact" value="<?php echo $client['emergencyContact']?>" placeholder="Emergency contacts (not group members)" class="form-control">
                                            </div>
                                        </div>

                                        <legend>Resident Information Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">

                                            <div class="col-sm-4">
                                                <label for="county">County</label>
                                                <input type="text" name="county" id="county" value="<?php echo $client['county'] ?>" placeholder="County" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="sub_county">Sub County</label>
                                                <input type="text" name="sub_county" id="sub_county" value="<?php echo $client['subCounty']?>" placeholder="Sub County" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="location">Location</label>
                                                <input type="text" name="location" id="location" value="<?php echo $client['location']?>" placeholder="Location" class="form-control">
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group">

                                            <div class="col-sm-4">
                                                <label for="sub_location">Sub Location</label>
                                                <input type="text" name="sub_location" id="sub_location" value="<?php echo $client['subLocation']?>" placeholder="Sub Location" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="village">village/estate</label>
                                                <input type="text" name="village" id="village" value="<?php echo $client['village']?>" placeholder="village/estate" class="form-control">
                                            </div>

                                        </div>

                                        <!-- Form Name -->
                                        <legend>Next of kin  Information</legend>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-4">
                                                <label for="nok_name">Full Name</label>
                                                <input type="text" name="nok_name" id="nok_name" value="<?php echo $client['nokName'] ?>" placeholder="Full Name" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="nok_contact">Contact</label>
                                                <input type="text" name="nok_contact" id="nok_contact" value="<?php echo $client['nokContact'] ?>" placeholder="Contact" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="nok_relationship">Relationship</label>
                                                <input type="text" name="nok_relationship" id="nok_relationship" value="<?php echo $client['nokRelationship'] ?>" placeholder="Relationship" class="form-control">
                                            </div>

                                        </div>

                                        <!-- Address Section -->
                                        <!-- Form Name -->
                                        <legend>Expectation Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <label for="expectation">Expectation</label>
                                                <textarea placeholder="Expectation" cols="10" rows="3" class="form-control"  id="expectation" name="expectation" ><?php echo $client['expectation']?></textarea>
                                            </div>
                                        </div>

                                        <!-- Parent/Guadian Contact Section -->
                                        <!-- Form Name -->
                                        <legend>Group Details</legend>
                                        <!-- Text input-->
                                        <div class="form-group">
                                            <div class="col-sm-5">



                                                <label for="group_ref_no">Select Group</label>
                                                <select name="group_ref_no" id=="group_ref_no" class="form-control">
                                                    <option selected="selected">--Select Group here--</option>

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
                                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                                    <input type="submit" class="btn btn-primary" value="Update">
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