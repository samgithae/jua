<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/27/17
 * Time: 7:18 AM
 */
require_once __DIR__ . '/../vendor/autoload.php';
use \Hudutech\Controller\DefaulterController;
use \Hudutech\Controller\ClientController;
use \Hudutech\Controller\GroupController;
use \Hudutech\Controller\SavingController;

$defaulters = DefaulterController::all();

//print_r($clients);
$counter = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>


    <title>Defaulters</title>

    <?php include_once 'head_views.php'; ?>

</head>
<body>
<div id="wrapper">
    <?php include_once 'right_menu.php' ?>
    <!--stop menu-->


    <div id="wrapper">
        <?php include_once 'right_menu.php' ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Defaulters</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Clients that have defaulted loans
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover"
                                       id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Group</th>
                                        <th>Shares</th>
                                        <th>Reason for default</th>

                                        <th>Amount defaulted</th>

                                        <th>Guarantors</th>

                                        <th>Action taken</th>


                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach ($defaulters as $defaulter): ?>
                                        <tr>
                                            <?php

                                            $client = ClientController::getId($defaulter['clientId']);
                                            $group = GroupController::groupMembers($client['groupRefNo']);
                                            $saving = SavingController::checkBalance($defaulter['clientId']);
                                            ?>
                                            <td><?php echo $counter++ ?></td>
                                            <td><?php echo $client['fullName'] ?></td>
                                            <td><?php echo $group[0]['groupName'] ?></td>
                                            <td><?php echo $saving ?></td>
                                            <td><?php echo 'reason' ?></td>

                                            <td><?php echo $defaulter['amountDefaulted'] ?></td>

                                            <td><?php echo 'none' ?></td>
                                            <td><?php echo 'none' ?></td>


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
        <?php include_once 'footer.php' ?>


</body>
</html>



