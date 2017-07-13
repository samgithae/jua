<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 00:42
 */
require_once __DIR__.'/../vendor/autoload.php';
include __DIR__.'/includes/signup.inc.php';

 ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add website</title>

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
<body style="height: 100%; margin-bottom: 4%;
    background-repeat: no-repeat;
    background-image: linear-gradient(rgb(250,250,250), rgb(236, 236, 236));">



<div id="wrapper">
    <?php include_once 'right_menu.php'?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">REP KENYA</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sign up

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
                            <div class="main-login main-center">
                                <div>
                                    <?php
                                    if(empty($success_msg) && !empty($error_msg)){
                                        ?>
                                        <div class="alert alert-danger alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <?php echo $error_msg ?>
                                        </div>
                                        <?php
                                    }
                                    elseif(empty($error_msg) and !empty($success_msg)){
                                        ?>
                                        <div class="alert alert-success alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <?php echo $success_msg  ?>
                                        </div>

                                        <?php
                                    }
                                    else
                                    {
                                        echo "";
                                    }
                                    ?>


                                </div>
                                <div class="col-md-10 col-md-offset-1">
                                <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">

                                    <div class="form-group">
                                        <label for="name" class="cols-sm-2 control-label">Username</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                <input type="text" class="form-control" name="username" id="name"  placeholder="Enter your Name"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="cols-sm-2 control-label">Your Email</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                                <input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="username" class="cols-sm-2 control-label">Role</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-tasks fa" aria-hidden="true"></i></span>
                                                <select name="role" class="form-control">

                                                    <option value="admin">Admin</option>
                                                    <option value="manager">Manager</option>
                                                    <option value="employee">Employee</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="cols-sm-2 control-label">Password</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                                <input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                                <input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <input type="submit" name="submit" value="Create Account" class="btn btn-primary btn-lg btn-block login-button"></input>
                                    </div>
                                    <div class="login-register">
                                        <a href="login.php">Login</a>
                                    </div>
                                </form>
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
</body>
</html>
