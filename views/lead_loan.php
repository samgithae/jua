<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 00:42
 */
require_once __DIR__.'/../vendor/autoload.php';
use \Hudutech\Controller\ClientController;
use \Hudutech\Controller\LoanController;

$clients = ClientController::all();
$loans= LoanController::all();

include  __DIR__.'/includes/lead_loan.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>



    <title>Lead Loan</title>

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

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

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
                <h1 class="page-header">Loan Leading</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Lead Loan
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
                                    <label for="clientId" class="cols-sm-2 control-label">Client Name</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                            <select name="clientId" id="clientId" class="form-control" onkeyup="checkHasActiveLoan()" onchange="checkHasActiveLoan()">
                                                <option>--Select Client here--</option>
                                                <?php foreach ($clients as $client): ?>
                                                    <option value="<?php echo $client['id']?>"><?php echo $client['fullName']?></option>
                                                <?php endforeach ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="loanId" class="cols-sm-2 control-label">Loan Type</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-cog fa" aria-hidden="true"></i></span>
                                            <select name="loanId" id="loanId" class="form-control" onkeyup="checkHasActiveLoan()" onchange="checkHasActiveLoan()">
                                                <option>--Select Loan type--</option>
                                                <?php foreach ($loans as $loan): ?>
                                                    <option value="<?php echo $loan['id']?>"><?php echo $loan['loanType']?></option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div  id="feedBack" style="color: red;"></div>
                                <div class="form-group">
                                    <label for="amount" class="cols-sm-2 control-label">Amount</label>
                                    <div class="cols-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-money fa" aria-hidden="true"></i></span>
                                            <input type="number" class="form-control" name="amount" id="amount"  placeholder="Loan amount" />

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <input type="submit" name="submit" value="Lend Out Loan" class="btn btn-primary btn-lg btn-block login-button">
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

<?php include_once 'footer.php'?>
<script>
    $(document).ready(function (e) {
      e.preventDefault;
    });
</script>
<script>

    function checkHasActiveLoan() {
        var url = 'check_has_loan_endpoint.php';
        var clientId = $('#clientId').val();
        $('#feedBack').text('');
        $(':input[type="submit"]').prop('disabled', false);
        console.log({clientId: clientId});
        $.ajax(
            {
                type: 'POST',
                url: url,
                data:JSON.stringify({clientId: clientId}),
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                traditional: true,
                success: function (response) {
                    console.log(response);
                    if(response.statusCode == 200){
                        jQuery(':input[type="submit"]').prop('disabled', false);
                        if(response['loanType'] == 'long_term') {
                            $('#feedBack').text('You already have a loan not settled. However you can take a TopUP Loan' +
                                ' click lend loan button to continue');
                        }
                        else if(response['loanType'] !='long_term'){
                            $(':input[type="submit"]').prop('disabled', true);
                            jQuery('#feedBack').text('');
                            $('#feedBack').text('You already have an active loan please pay the loan and try again');

                        }

                    }
                    else{
                        console.log(response);
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            }
        )
    }
</script>
</body>
</html>
