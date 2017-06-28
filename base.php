<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 26/04/2017
 * Time: 23:55
 */
require_once __DIR__.'/vendor/autoload.php';
$clients = \Hudutech\Controller\ClientController::all();
$employees  = \Hudutech\Controller\EmployeeController::all();
$groups = \Hudutech\Controller\GroupController::all();
$loans= \Hudutech\Controller\LoanController::all();


$clientsCounter = 0;
$employeesCounter = 1;
$groupsCounter = 0;
$loansCounter = 1;
foreach ($clients as $client ):
    $clientsCounter++;
 endforeach;

foreach ($employees as $employee ):
    $employeesCounter++;
endforeach;

foreach ($groups as $group ):
    $groupsCounter++;
endforeach;

foreach ($loans as $loan ):
    $loansCounter++;
endforeach;


?>
<!doctype html>
<html>
<head>
    <?php
    include __DIR__.'/views/head.php';
    ?>
</head>
<body>
<!--start of menu-->
<?php
include __DIR__.'/views/right_menu.php';
?>
<!--stop of menu-->

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row" id="main" >
                <div class="col-sm-12 col-md-12 well" id="content">
                    <div class="col-md-10 col-sm-10 col-lg-offset-2" >
                        <h1>Welcome to Rep Kenya Management System</h1>

                    </div>

                </div>
                <div class="col-sm-5 col-md-5 well col-sm-offset-1" id="content">
                    <div class="col-md-6 col-sm-6">
                        <h2>Registered Clients</h2>
                        <h1><?php echo $clientsCounter?></h1>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 well " style="margin-left: 15px;" id="content"  >

                    <div class="col-md-6 col-sm-6">
                        <h2>Registered Groups</h2>
                        <h1><?php echo $groupsCounter?></h1>
                    </div>
                </div>
            </div>

            <div class="row" id="main" >

                <div class="col-sm-5 col-md-5 well col-sm-offset-1" id="content">
                    <div class="col-md-6 col-sm-6">
                        <h2>Employees</h2>
                        <h1><?php echo $employeesCounter?></h1>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 well" style="margin-left: 15px;" id="content"  >

                    <div class="col-md-6 col-sm-6">
                        <h2>Loan Types</h2>
                        <h1><?php echo $loansCounter?></h1>
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div><!-- /#wrapper -->
<!--javascript-->
<script src="public/assets/js/jquery-3.2.0.slim.min.js"></script>
<script src="public/assets/js/bootstrap.min.js"></script>
</body>
</html>