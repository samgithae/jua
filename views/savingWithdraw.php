<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 00:42
 */
require_once __DIR__.'/../vendor/autoload.php';

$client = \Hudutech\Controller\ClientController::getId($_GET['id']);
$loans= \Hudutech\Controller\LoanController::all();

include  __DIR__.'/includes/lead_loan.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Saving Withdraw</title>
<?php include_once 'head_views.php';?>
    <link href="../public/assets/select/jquery-editable-select.min.css" rel="stylesheet">
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

                                <form class="form-horizontal" name="form1" id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">

                                    <div class="form-group">

                                        <div class="cols-sm-10">
                                            <label for="name" class="cols-sm-2 control-label">Select Client</label>

                                            <div class="input-group">
                                                 <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                <select name="clientId" id="clientId" class="form-control" onkeyup="calculateBal()" onchange="calculateBal()">
                                                    <option>--Select Client here--</option>
                                                    <?php foreach ($clients as $client): ?>
                                                        <option value="<?php echo $client['id']?>"><?php echo $client['fullName'].' - '.$client['idNo']?></option>
                                                    <?php endforeach ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="balance" class="cols-sm-2 control-label">Current Balance</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                <input type="number" class="form-control" name="balance" id="balance" disabled/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="username" class="cols-sm-2 control-label">Amount to withdraw</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                <input type="number" class="form-control" name="amount"   placeholder="amount e.g 1000" />

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

<script src="../public/assets/select/jquery-editable-select.js"></script>
<script>
   $('#clientId').editableSelect();
</script>
<script>
    function calculateBal() {
        var url = 'check_balance_endpoint.php';
        var clientId = jQuery('#clientId').val()


        jQuery.ajax(
            {
                type: 'POST',
                url: url,
                data: JSON.stringify({clientId :clientId}),
                dataType: 'json',
                contentType: 'application/json; charset=utf-8;',
                traditional: true,
                success:function (response) {
                    jQuery('#balance').val(response.balance);
                    console.log(response);
                }
            }
        )
    }
</script>
</body>
</html>
