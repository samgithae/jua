<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 8/7/17
 * Time: 5:08 AM
 */
require_once __DIR__.'/../vendor/autoload.php';
use Hudutech\Controller\LoanController;
$active_loans = LoanController::showLoanBalances();
$counter = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>


    <title>Client Savings</title>

    <?php include_once 'head_views.php';?>
</head>
<body>
<div id="wrapper">
    <?php include_once 'right_menu.php'?>




    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Clients Active Loans</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Recorded Savings
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Group Name</th>
                                    <th>Current Loan Balance</th>
                                    <th>Date Borrowed</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($active_loans as $active_loan ): ?>
                                    <tr>
                                        <td><?php echo $counter++?></td>
                                        <td><?php echo $active_loan['fullName']?></td>
                                        <td><?php echo $active_loan['groupName']?></td>
                                        <td><?php echo $active_loan['loanBal']?></td>
                                        <td><?php echo $active_loan['dateBorrowed']?></td>

                                        <td> <a class="btn btn-primary" href="loan_repayment.php?id=<?php echo $active_loan['clientId']?>&
                                        lid=<?php echo $active_loan['clientLoanId']?>
                                        &amt=<?php echo $active_loan['loanBal']?>&type=<?php echo LoanController::getId($active_loan['clientLoanId'])['loanType']?>">
                                                RepayLoan</a></td>

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
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
