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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Employees</title>

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
    <script>
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>





</body>
</html>
