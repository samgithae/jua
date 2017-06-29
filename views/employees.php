<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/27/17
 * Time: 7:18 AM
 */
require_once __DIR__.'/../vendor/autoload.php';
$employees  = \Hudutech\Controller\EmployeeController::all();
$counter = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>Employees</title>

    <?php include_once 'head_views.php';?>
</head>
<body>
<div id="wrapper">
    <?php include_once 'right_menu.php' ?>
<!--stop menu-->



    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Employees</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Registered Employees
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover"
                                   id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>PF_No</th>
                                    <th>FullName</th>
                                    <th>JobTitle</th>
                                    <th>ID</th>
                                    <th>NSSF</th>
                                    <th>NHIF</th>
                                    <th>KRA PIN</th>
                                    <th>Remuneration</th>
                                    <th>BankName</th>
                                    <th>BankAccNo</th>
                                    <th>PhoneNumber</th>
                                    <th colspan="3"> Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($employees as $employee ): ?>
                                    <tr>
                                        <td><?php echo $counter++ ?></td>
                                        <td><?php echo $employee['pfNo'] ?></td>
                                        <td><?php echo $employee['fullName'] ?></td>
                                        <td><?php echo $employee['jobTitle'] ?></td>
                                        <td><?php echo $employee['idNo'] ?></td>
                                        <td><?php echo $employee['nssfNo'] ?></td>
                                        <td><?php echo $employee['nhifNo'] ?></td>
                                        <td><?php echo $employee['kraPin'] ?></td>
                                        <td><?php echo $employee['remuneration'] ?></td>
                                        <td><?php echo $employee['bankName'] ?></td>
                                        <td><?php echo $employee['bankAccountNo'] ?></td>
                                        <td><?php echo $employee['phoneNumber'] ?></td>
                                        <td colspan="3" class="btn-xs">
                                            <button class="btn-xs btn-primary">Edit</button>

                                            <button class="btn-xs btn-danger">Delete</button>
                                        </td>
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
