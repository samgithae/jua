<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 03/05/2017
 * Time: 11:54
 */
require_once __DIR__.'/../vendor/autoload.php';
$counter=1;
$groupSavings=\Hudutech\Controller\SavingController::showGroupSavingsLog();
//print_r($groupSaving);
?>


<!DOCTYPE html>
<html lang="en">

<head>



    <title>Group Member</title>
    <?php include_once 'head_views.php' ?>

</head>
<body>
<div id="wrapper">
    <?php include_once 'right_menu.php' ?>
    <!--stop menu-->
    <!--stop menu-->






    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Group Savings</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Recorded group savings
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">



                            <table width="100%" class="table table-striped table-bordered table-hover"
                                   id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>GroupName</th>
                                    <th>GroupSaving</th>
                                    <th>Shares</th>
                                    <th>Advance</th>
                                    <th>Loans</th>
                                    <th>Banking</th>
                                    <th>TRF</th>
                                    <th>Interest</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($groupSavings as $groupSaving ): ?>
                                    <tr>
                                        <td><?php echo $counter++?></td>
                                        <td><?php echo $groupSaving['groupName']?></td>
                                        <td><?php echo $groupSaving['total_group_savings']?></td>



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
