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
                        Repay Loan <p class="pull-right"><a href="active_loans.php" class="btn-link" style="color: red">Back to Active loan List</a> </p>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-offset-3">
                                <div class="main-login main-center">

                                    <form class="form-horizontal">

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
                                                    <input type="text" value="<?php echo isset($_GET['type']) ? $_GET['type'] : ''; ?>" class="form-control" id="loanType" disabled>
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
                                                    <input type="hidden" name="clientLoanId" value="<?php echo isset($_GET['lid'])? $_GET['lid']: '' ?>" id="clientLoanId">
                                                    <input type="hidden" name="clientId" value="<?php echo isset($_GET['id'])? $_GET['id']: '' ?>" id="clientId">
                                                    <span class="input-group-addon"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                                    <input type="number" class="form-control" name="amount" id="amount"  placeholder="Enter Amount to repay"/>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="form-group ">
                                        <button onclick="submitRepayLoanFormData()" value="Repay Loan" class="btn btn-primary btn-lg btn-block login-button">Repay Loan</button>
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



<!-- Modal -->
<div class="modal fade" id="confirmRepay" tabindex="-1" role="dialog" aria-labelledby="confirmRepay"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="confirmTitle">Confirm Repayment </h4>
                <div id="confirmFeedback">

                </div>
            </div>
            <div class="modal-body" id="confirmMessage"></div>
            <div class="modal-footer">
                <button type="button" id="btn-confirmRepay" class="btn btn-info">Continue</button>
                <button type="button" data-dismiss="modal" class="btn btn-info">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
include 'footer.php';
?>
<script src="../public/assets/select/jquery-editable-select.js"></script>
<script>
    $(document).ready(function (e) {
        e.preventDefault;
    })
</script>
<script>
    function getData() {
        return {
            clientLoanId: $('#clientLoanId').val(),
            clientId: $('#clientId').val(),
            amount: $('#amount').val(),
            loanType: $('#loanType').val()
        };
    }
    function submitRepayLoanFormData() {
        var data = JSON.stringify(getData());
        var url = 'repay_loan_endpoint.php';

        $('#confirmMessage').html('<p>Confirm Repay Ksh  ' + $('#amount').val() +
            '  For Account Name:' + $('#clientName').val() + '</p>');

        $('#confirmRepay').modal('show');
        $('#btn-confirmRepay').on('click', function (e) {
            e.preventDefault;
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                dataType: 'json',
                contentType: 'application/json; charset=utf-8;',
                traditional: true,
                success: function (response) {

                    if (response.statusCode == 200) {
                        $('#confirmFeedback').removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .text(response.message);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    if (response.statusCode == 500) {
                        $('#confirmFeedback').removeClass('alert alert-success')
                            .html('<div class="alert alert-danger alert-dismissable">' +
                                '<a href="#" class="close"  data-dismiss="alert" aria-label="close">&times;</a>' +
                                '<strong>Error! </strong> ' + response.message + '</div>')

                    }
                },
                error: function (error) {
                    console.log(error);
                }

            })
        });


    }
</script>


</body>
</html>
