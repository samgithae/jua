<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 00:25
 */
require_once __DIR__.'/../vendor/autoload.php';
include __DIR__.'/includes/login.inc.php';
?>
<!DOCTYPE html>
<html>
<head>


    <link href= "../public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/assets/css/custom.css " rel="stylesheet">
    <script src="../public/assets/js/respond.js"></script>
    <script src="../public/assets/js/custom.js"></script>
</head>
<?php
include_once 'head_views.php';

?>
<body style=" margin-bottom: 15%;height: 100%;background-repeat: no-repeat; background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));">
<div class="container" >
    <div>

    </div>
    <div class="card card-container">
        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <p id="profile-name" class="profile-name-card"><h3 style="text-align: center">Rep Management System</h3></p>
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

            ?>
        </div>
        <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" METHOD="post">
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div id="remember" class="checkbox">

            </div>
            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-lg btn-block login-button"></input>

        </form><!-- /form -->

    </div><!-- /card-container -->
</div><!-- /container -->
<script src="../public/assets/js/jquery-3.2.0.slim.min.js"></script>
<script src="../public/assets/js/custom.js"></script>
<script src="../public/assets/js/bootstrap.js"></script>
</body>
</html>
