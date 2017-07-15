<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 03/05/2017
 * Time: 11:54
 */
require_once __DIR__.'/../vendor/autoload.php';
use Hudutech\Controller\GroupController;
$counter=1;
$groupSavings = GroupController::showStats();

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
                <h3 class="page-header"> Group Savings and Statistics</h3>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Group Saving Statistics
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
                                    <th>Shares</th>
                                    <th>Advance</th>
                                    <th>Loans</th>
                                    <th>Banking</th>
                                    <th>TRF</th>
                                    <th>Interest</th>
                                    <th>Office Debt</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($groupSavings as $groupSaving ): ?>
                                    <tr>
                                        <td><?php echo $counter++?></td>
                                        <td><?php echo $groupSaving['groupName']?></td>
                                        <td><?php echo $groupSaving['shares']?></td>
                                        <td><?php echo $groupSaving['advance']?></td>
                                        <td><?php echo $groupSaving['loans']?></td>
                                        <td><?php echo $groupSaving['banking']?></td>
                                        <td><?php echo $groupSaving['groupTRF']?></td>
                                        <td><?php echo $groupSaving['interest']?></td>
                                        <td><?php echo $groupSaving['officeDebt']?></td>



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
