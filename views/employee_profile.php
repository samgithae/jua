<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 03/05/2017
 * Time: 20:33
 */
require_once __DIR__ . '/../vendor/autoload.php';
$counter = 1;
$employee = \Hudutech\Controller\EmployeeController::getId($_GET['id']);


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Profile</title>

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

        <!-- Navigation -->
        <?php
        include 'right_menu.php';
        ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Profile</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="row">
                        <div class="fb-profile">

                            <div class="fb-profile-text">
                                <div class="col-md-2">


                                    <?php
                                    if(!empty($employee['passport']))
                                    {
                                        ?>
                                        <img align="left" class="fb-image-profile thumbnail " height="150px" width="150px"
                                             src=" <?php echo $employee['passport'] ?>" alt="Profile image example"/>


                                        <?php

                                   }

                                    else{
                                        ?>
                                    <img align="left" class="fb-image-profile thumbnail " height="150px" width="150px"
                                         src="../public/assets/img/profile_default.jpg  ?>" alt="Profile image example"/>
                                    <?php

                                    }


                                    ?>
                                </div>
                                <div class="col-md-8">
                                <h2><b>Name:</b> <?php echo $employee['fullName'] ?></h2>
                                    <h3><b>Job Title:</b> <?php echo $employee['jobTitle'] ?></h3>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container">
                            <div class="col-sm-10">

                                <div data-spy="scroll" class="tabbable-panel">
                                    <div class="tabbable-line">
                                        <ul class="nav nav-tabs ">
                                            <li class="active">
                                                <a href="#tab_default_1" data-toggle="tab">
                                                    Personal Information </a>
                                            </li>
                                            <li>
                                                <a href="#tab_default_2" data-toggle="tab">
                                                    Contact Information</a>
                                            </li>
                                            <li>
                                                <a href="#tab_default_3" data-toggle="tab">
                                                    Resident Information</a>
                                            </li>
                                            <li>
                                                <a href="#tab_default_4" data-toggle="tab">
                                                    Next of kin Information</a>
                                            </li>
                                            <li>
                                                <a href="#tab_default_5" data-toggle="tab">
                                                    Bank Details</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_default_1">

                                                <p>
                                                    Personal Information
                                                </p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="name">Full Name:</label>
                                                            <p><?php echo $employee['fullName'] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Job Title:</label>
                                                            <p> <?php echo $employee['jobTitle'] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Identity card number:</label>
                                                            <p> <?php echo $employee['idNo'] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">NHIF Number:</label>
                                                            <p> <?php echo $employee['nhifNo'] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">NSSF Number:</label>
                                                            <p> <?php echo $employee['nssfNo'] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">KRA Pin Number:</label>
                                                            <p> <?php echo $employee['kraPin'] ?></p>
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Date Of Hire:</label>
                                                            <p> <?php echo $employee['dateOfHire'] ?></p>
                                                        </div>




                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane" id="tab_default_2">
                                                <p>
                                                    Contact Information
                                                </p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Phone Number:</label>
                                                            <p> <?php echo $employee['phoneNumber'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email:</label>
                                                            <p> <?php echo $employee['email'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Postal Address:</label>
                                                            <p> <?php echo $employee['postalAddress'] ?></p>
                                                        </div>

                                                    </div>

                                                </div>


                                            </div>
                                            <div class="tab-pane" id="tab_default_3">
                                                <p>
                                                    Job Information Details
                                                </p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Job Description:</label>
                                                            <p><?php echo $employee['jobDescription'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Qualification:</label>
                                                            <p> <?php echo $employee['qualification'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Testimonial:</label>
                                                            <p> <?php echo $employee['testimonial'] ?></p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_default_4">
                                                <p>
                                                    Next of kin Information

                                                </p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Full Name:</label>
                                                            <p> <?php echo $employee['nokName'] ?></p>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="email">Contact:</label>
                                                            <p> <?php echo $employee['nokContact'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Relationship:</label>
                                                            <p> <?php echo $employee['nokRelationship'] ?></p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_default_5">
                                                <p>
                                                    Bank Details

                                                </p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Bank:</label>
                                                            <p> <?php echo $employee['bankName'] ?></p>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Bank Account No:</label>
                                                            <p> <?php echo $employee['bankAccountNo'] ?></p>
                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
