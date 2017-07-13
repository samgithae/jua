<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 25/04/2017
 * Time: 11:19
 */
require_once __DIR__ . '/../vendor/autoload.php';
include 'includes/register_user.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register User</title>

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
                <h1 class="page-header">Register User</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        User Information

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


                            <div class="col-md-12 ">
                                <div class="container-fluid">
                                    <!-- Page Heading -->
                                    <div class="row" id="main" >

                                        <div class="col-md-10 ">
                                            <form role="form" class="form-horizontal form-groups-bordered" method="post"
                                                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">





                                                <div class="form-group">
                                                    <label for="userName" class="col-sm-3 control-label">UserName</label>

                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" name="username" placeholder="Username"
                                                               required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="email" class="col-sm-3 control-label">Email</label>

                                                    <div class="col-sm-5">
                                                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <label for="password" class="col-sm-3 control-label">Password</label>

                                                    <div class="col-sm-5">
                                                        <input type="password" class="form-control" name="password" placeholder="Password"
                                                               required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="confirmpassword" class="col-sm-3 control-label">Confirm Password</label>

                                                    <div class="col-sm-5">
                                                        <input type="password" class="form-control" name="confirm"
                                                               placeholder="Confirm Password" required>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-5">

                                                        <input type="submit" name="submit" value="Register User"
                                                               class="btn btn-primary btn-lg btn-block "/>
                                                    </div>
                                                </div>

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