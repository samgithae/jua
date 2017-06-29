<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 03/05/2017
 * Time: 11:54
 */
require_once __DIR__.'/../vendor/autoload.php';
$counter=1;
$clientSavings=\Hudutech\Controller\SavingController::clientsTotalSavingsLog();
//print_r($clientSavings);
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
                <h1 class="page-header"> Client Savings</h1>
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
                                    <th>Total Saving</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($clientSavings as $clientSaving ): ?>
                                    <tr>
                                        <td><?php echo $counter++?></td>
                                        <td><?php echo $clientSaving['fullName']?></td>
                                        <td><?php echo $clientSaving['groupName']?></td>
                                        <td><?php echo $clientSaving['totalSaving']?></td>

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
