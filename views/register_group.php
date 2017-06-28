<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 25/04/2017
 * Time: 11:19
 */
require_once __DIR__.'/../vendor/autoload.php';
include  __DIR__.'/includes/register_group.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register Group</title>

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
                <h1 class="page-header">Register Group</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Group Information

                        <?php
                        if (empty($success_msg) && !empty($error_msg)) {
                            ?>
                            <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $error_msg ?>
                            </div>
                            <?php
                        } elseif (empty($error_msg) and !empty($success_msg)) {
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $success_msg ?>
                            </div>

                            <?php
                        } else {
                            echo "";
                        }
                        ?>

                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div>
                                <?php if($errorMsg == '' and $successMsg != '') {?>
                                    <div class="alert alert-success">
                                        <?php echo $successMsg; ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="col-md-12 ">
                                <div class="container-fluid">
                                    <!-- Page Heading -->
                                    <div class="row" id="main" >

                                        <div class="col-md-10 ">
                                            <form class="form-horizontal col-md-offset-2" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" METHOD="post">
                                                <fieldset>

                                                    <!-- Form Name -->


                                                    <!-- Text input-->
                                                    <div class="form-group">
                                                        <div class="col-sm-5">
                                                            <label for="group_name">Name of group</label>
                                                            <input type="text" name="group_name" id="group_name" placeholder="Name of group" class="form-control">
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <label for="ref_no">Reference number</label>
                                                            <input type="text" name="ref_no" id="ref_no" placeholder="Reference number" class="form-control">
                                                        </div>

                                                    </div>


                                                    <!-- Text input-->
                                                    <div class="form-group">
                                                        <div class="col-sm-5">
                                                            <label for="number_of_members">Number of members</label>
                                                            <input type="text" name="number_of_members" id="number_of_members" placeholder="Number of members" class="form-control">
                                                        </div>

                                                        <div class="col-sm-5">
                                                            <label for="region">Region of location</label>
                                                            <input type="text" name="region" id="region" placeholder="Region of location" class="form-control">
                                                        </div>

                                                    </div>



                                                    <!-- Text input-->
                                                    <div class="form-group">
                                                        <div class="col-sm-5">
                                                            <label for="official_contact">Group officials’ contact</label>
                                                            <input type="text" name="official_contact" id="official_contact" placeholder="Group officials’ contact" class="form-control">
                                                        </div>

                                                        <div class="col-sm-5">
                                                            <label for="monthly_meeting_schedule">Monthly meeting schedules</label>
                                                            <input type="text" name="monthly_meeting_schedule" id="monthly_meeting_schedule" placeholder="Monthly meeting schedules" class="form-control">
                                                        </div>

                                                    </div>




                                                    <div class="form-group">
                                                        <div class="col-sm-5">
                                                            <label for="date_formed">Date of formation</label>

                                                            <input placeholder="Date of formation" name="date_formed" id="date_formed" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" >
                                                        </div>
                                                    </div>


                                                    <!-- Command -->
                                                    <div class="form-group">
                                                        <div class="col-sm-5 col-sm-offset-1">
                                                            <div class="pull-left">
                                                                <button type="submit" class="btn btn-danger  ">Cancel</button>
                                                                <input type="submit" class="btn btn-primary" value="Save">
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
        </div>
    </div>
</div>



<?php
include 'footer.php';
?>
<!-- Name Section -->
</body>
</html>