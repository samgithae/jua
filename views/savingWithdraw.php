<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 00:42
 */
require_once __DIR__.'/../vendor/autoload.php';

$clients = \Hudutech\Controller\ClientController::all();
$loans= \Hudutech\Controller\LoanController::all();

include  __DIR__.'/includes/lead_loan.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Saving Withdraw</title>
<?php include_once 'head_views.php';?>

</head>

<body>



<div id="wrapper">
    <?php include_once 'right_menu.php'?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Saving Withdraw</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->



        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Withdraw cash



                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-lg-6 col-md-offset-3">


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

                                <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">

                                    <div class="form-group">
                                        <label for="name" class="cols-sm-2 control-label">Client Name</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                <select name="clientId" class="form-control">
                                                    <option>--Select Client here--</option>
                                                    <?php foreach ($clients as $client): ?>
                                                        <option value="<?php echo $client['id']?>"><?php echo $client['fullName']?></option>
                                                    <?php endforeach ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="cols-sm-2 control-label">Loan Type</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-cog fa" aria-hidden="true"></i></span>
                                                <select name="loanId" class="form-control">
                                                    <option>--Select Loan type--</option>
                                                    <?php foreach ($loans as $loan): ?>
                                                        <option value="<?php echo $loan['id']?>"><?php echo $loan['loanType']?></option>
                                                    <?php endforeach ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="username" class="cols-sm-2 control-label">Amount</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                <input type="number" class="form-control" name="amount"   placeholder="Loan amount" />

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <input type="submit" name="submit" value="Save" class="btn btn-primary btn-lg btn-block login-button">
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





<?php  include_once 'footer.php'?>




</body>
</html>
