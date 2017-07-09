<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 00:42
 */
require_once __DIR__.'/../vendor/autoload.php';

use Hudutech\Controller\ClientController;
use Hudutech\Controller\LoanController;

$clients = ClientController::all();
$loans= LoanController::all();

?>
<!DOCTYPE html>
<html lang="en">

<head>



    <title>Loan Repayment</title>
    <?php include_once 'head_views.php' ?>
</head>

<body>


<div id="wrapper">
    <?php include_once 'right_menu.php'?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loan Repayment</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Repay Loan
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-offset-3">
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
                                    <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">

                                        <div class="form-group">
                                            <label for="clientName" class="cols-sm-2 control-label">Client Name</label>
                                            <div class="cols-sm-10">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                    <input type="text" value="<?php echo isset($_GET['name']) ? $_GET['name']: ''?>" class="form-control" id="clientName" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="loanType" class="cols-sm-2 control-label">Loan Type</label>
                                            <div class="cols-sm-10">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-cog fa" aria-hidden="true"></i></span>
                                                    <input type="text" value="<?php echo isset($_GET['type']) ? $_GET['type'] : ''; ?>" class="form-control" id="loanType"disabled>
                                                </div>
                                            </div>
                                        </div>
<!---->
                                        <div class="form-group">
                                            <label for="loanBal" class="cols-sm-2 control-label">Current Loan Balance</label>
                                            <div class="cols-sm-10">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                    <input type="number" class="form-control" name="loanBal" id="loanBal" value="<?php echo isset($_GET['amt']) ? $_GET['amt'] : ''; ?>" disabled/>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="amount" class="cols-sm-2 control-label">Amount RePaid</label>
                                            <div class="cols-sm-10">
                                                <div class="input-group">
                                                    <input type="hidden" name="clientLoanId" value="<?php echo isset($_GET['lid'])? $_GET['lid']: '' ?>">
                                                    <input type="hidden" name="clientId" value="<?php echo isset($_GET['id'])? $_GET['id']: '' ?>">
                                                    <span class="input-group-addon"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                    <input type="number" class="form-control" name="amount" id="amount"  placeholder="Enter Amount to repay"/>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <input type="submit" name="submit" value="Repay Loan" class="btn btn-primary btn-lg btn-block login-button">
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
<script src="../public/assets/js/jquery-1.11.3.min.js"></script>

<script>
   $(document).ready(function (e) {
       e.preventDefault;


   })
</script>


</body>
</html>
