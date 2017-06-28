<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 03/05/2017
 * Time: 20:33
 */
require_once __DIR__ . '/../vendor/autoload.php';
$counter = 1;
$client = \Hudutech\Controller\ClientController::getId($_GET['id']);
$groups = \Hudutech\Controller\GroupController::all();
$savings = \Hudutech\Controller\SavingController::getClientTotalSavings($_GET['id']);
$singleClientSavings = \Hudutech\Controller\SavingController::showClientSavingsLog($_GET['id']);
//print_r($client);
foreach ($groups as $group):

    if ($group['refNo'] == $client['groupRefNo']) {
        $groupName = $group['groupName'];

    }
endforeach;
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
                                <img align="left" class="fb-image-profile thumbnail " height="150px" width="150px"
                                     src="../public/assets/img/profile_default.jpg" alt="Profile image example"/>
                                </div>
                                <div class="col-md-8">
                                <h2><b>Name:</b> <?php echo $client['fullName'] ?></h2>
                                <h3><b>Group:</b> <?php echo $groupName ?></h3>
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
                                                    Expectation Details</a>
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
                                                            <p><?php echo $client['fullName'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Membership Number:</label>
                                                            <p> <?php echo $client['membershipNo'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Identity card number:</label>
                                                            <p> <?php echo $client['idNo'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">KRA Pin Number:</label>
                                                            <p> <?php echo $client['kraPin'] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Date Of Birth:</label>
                                                            <p> <?php echo $client['dob'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Date of enrollment:</label>
                                                            <p> <?php echo $client['dateEnrolled'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Occupation:</label>
                                                            <p> <?php echo $client['occupation'] ?></p>
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
                                                            <p> <?php echo $client['phoneNumber'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email:</label>
                                                            <p> <?php echo $client['email'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Postal Address:</label>
                                                            <p> <?php echo $client['postalAddress'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Emergency contacts:</label>
                                                            <p> <?php echo $client['emergencyContact'] ?></p>
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                            <div class="tab-pane" id="tab_default_3">
                                                <p>
                                                    Resident Information Details
                                                </p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">County:</label>
                                                            <p><?php echo $client['county'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Sub County:</label>
                                                            <p> <?php echo $client['subCounty'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Location:</label>
                                                            <p> <?php echo $client['location'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Sub Location:</label>
                                                            <p><?php echo $client['subLocation'] ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Village/Estate:</label>
                                                            <p> <?php echo $client['village'] ?></p>
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
                                                            <p> <?php echo $client['nokName'] ?></p>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="email">Contact:</label>
                                                            <p> <?php echo $client['nokContact'] ?></p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Relationship:</label>
                                                            <p> <?php echo $client['nokRelationship'] ?></p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_default_5">
                                                <p>
                                                    Expectation Details

                                                </p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="email">Expectation:</label>
                                                            <p> <?php echo $client['expectation'] ?></p>
                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col col-md-12" style="margin: 5px;">
                                        <!--                <div class="table-responsive">-->
                                        <!---->
                                        <!--                    <table class="table">-->
                                        <!--                        <h3>Saving Log</h3>-->
                                        <!--                        <thead>-->
                                        <!--                        <tr class="bg-primary">-->
                                        <!--                            <th>#</th>-->
                                        <!--                            <th>Full Name</th>-->
                                        <!--                            <th>Contribution</th>-->
                                        <!--                            <th>Payment Method</th>-->
                                        <!--                            <th>Date Paid</th>-->
                                        <!--                        </tr>-->
                                        <!--                        </thead>-->
                                        <!--                        <tbody>-->
                                        <!--                        --><?php //foreach ($singleClientSavings as $clientSaving): ?>
                                        <!--                            <tr>-->
                                        <!--                                <td>--><?php //echo $counter++ ?><!--</td>-->
                                        <!--                                <td>--><?php //echo $clientSaving['fullName'] ?><!--</td>-->
                                        <!--                                <td>--><?php //echo $clientSaving['contribution'] ?><!--</td>-->
                                        <!--                                <td>--><?php //echo $clientSaving['paymentMethod'] ?><!--</td>-->
                                        <!--                                <td>--><?php //echo $clientSaving['datePaid'] ?><!--</td>-->
                                        <!---->
                                        <!--                            </tr>-->
                                        <!--                        --><?php //endforeach; ?>
                                        <!--                        </tbody>-->
                                        <!--                    </table>-->
                                        <!--                </div>-->
                                        <div class="jumbotron">
                                            <h3>Total Savings <?php echo $savings['totalSavings'] ?></h3>
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
