<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/27/17
 * Time: 7:18 AM
 */
require_once __DIR__.'/../vendor/autoload.php';
$clients = \Hudutech\Controller\ClientController::all();
//print_r($clients);
$counter = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>


    <title>Clients</title>

    <?php include_once 'head_views.php';?>

</head>
<body>
<div id="wrapper">
    <?php include_once 'right_menu.php'?>
<!--stop menu-->



    <div id="wrapper">
        <?php include_once 'right_menu.php'?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Clients</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Registered clients
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>FullName</th>
                                        <th>GroupRefNo</th>
                                        <th>MembershipNo</th>
                                        <th>ID</th>

                                        <th>PhoneNumber</th>

                                        <th>County</th>

                                        <th >Action</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($clients as $client ): ?>
                                        <tr>
                                            <td><?php echo $counter++?></td>
                                            <td><?php echo $client['fullName']?></td>
                                            <td><?php echo $client['groupRefNo']?></td>
                                            <td><?php echo $client['membershipNo']?></td>
                                            <td><?php echo $client['idNo']?></td>

                                            <td><?php echo $client['phoneNumber']?></td>

                                            <td><?php echo $client['county']?></td>

                                            <td colspan="3"class="btn-xs" >
                                                <button class=" btn-xs btn-primary">Edit</button>
                                                <a href="client_profile.php?id=<?php echo urlencode($client['id'])?>" class=" btn-xs btn-primary"> Profile</a>
                                                <button class=" btn-xs btn-danger">Delete</button>
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
        <?php include_once 'footer.php'?>





</body>
</html>



