<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 00:42
 */
require_once __DIR__.'/../vendor/autoload.php';

$client = \Hudutech\Controller\ClientController::getId($_GET['id']);
//print_r($client);
use Hudutech\Controller\SavingController;
$loans= \Hudutech\Controller\LoanController::all();

include  __DIR__.'/includes/lead_loan.inc.php';
$balance= SavingController::checkBalance($_GET['id']);

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

                                <form class="form-horizontal" name="form1" id="form1" >
                                    <div class="form-group">

                                        <div class="cols-sm-10">
                                            <label for="fullName" class="cols-sm-2 control-label">Select Client</label>

                                            <div class="input-group">
                                                 <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                <input type="text" class="form-control" name="fullName" value="<?php echo $client['fullName']?>" id="fullName" disabled/>
                                                <input type="hidden" class="form-control" name="clientId" value="<?php echo $_GET['id']?>" id="clientId" disabled/>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="balance" class="cols-sm-2 control-label">Current Balance</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                <input type="number" class="form-control" name="balance"  value="<?php echo $balance?>" id="balance" disabled/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="amount" class="cols-sm-2 control-label">Amount to withdraw</label>
                                        <div class="cols-sm-10">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                <input type="number" class="form-control" name="amount" id="amount"  placeholder="amount e.g 1000" />

                                            </div>
                                        </div>
                                    </div>


                                </form>
                                <div class="form-group ">

                                    <button class="btn btn-primary btn-lg btn-block login-button"
                                            onclick="showWithdrawModal()">Withdraw
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="confirmWithdraw"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Withdraw</h4>
                <div id="confirmFeedback">

                </div>
            </div>
            <div class="modal-body"><p style="font-size: 16px;">Click to Confirm withdraw</p></div>
            <div class="modal-footer">
                <button type="button" id="btn-confirmWithdraw" class="btn btn-info">Continue</button>
                <button type="button" data-dismiss="modal" class="btn btn-info">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!--confirm withdraw module-->
<div class="modal fade" id="confirmWithdraw">
    <div class="modal-dialog">
        <div class="modal-header">
            <h4 class="modal-title">Confirm Withdraw</h4>
            <div id="feedback">

            </div>

        </div>
        <div class="modal-body">
            <p style="font-size: 16px;">Click to Confirm withdraw</p>
        </div>
        <div class="modal-footer">
            <button type="button" id="btn-confirmWithdraw" class="btn btn-info">Continue</button>
            <button type="button" data-dismiss="modal" class="btn btn-info">Cancel</button>
        </div>

    </div>
</div>
<!--end of modal-->



<?php  include_once 'footer.php'?>

<script src="../public/assets/select/jquery-editable-select.js"></script>





<script type="text/javascript">




    function getData() {
        return {
            clientId: $('#clientId').val(),
            amount: $('#amount').val()
        }

    }

    function showWithdrawModal() {
        $('#confirmWithdraw').modal('show');
        $('#btn-confirmWithdraw').on('click', function (e) {
            e.preventDefault();
            var url = 'withdraw_endpoint.php';
            var data = getData();
            console.log(data);
            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(data),
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function (response) {
                        console.log(response.statusCode);
                        if (response.statusCode == 200) {
                            $('#feedback').removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .text(response.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (response.statusCode == 500) {
                            $('#feedback').removeClass('alert alert-success')
                                .html('<div class="alert alert-danger alert-dismissable">' +
                                    '<a href="#" class="close"  data-dismiss="alert" aria-label="close">&times;</a>' +
                                    '<strong>Error! </strong> ' + response.message + '</div>')

                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }

                }
            )
        })
    }


</script>
</body>
</html>
