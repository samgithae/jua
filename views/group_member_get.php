<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 02/05/2017
 * Time: 15:51
 */
require_once __DIR__.'/../vendor/autoload.php';

//print_r($clients);
$counter = 1;



$groups = \Hudutech\Controller\GroupController::groupMembers($_GET['k']);

//$groups = \Hudutech\Controller\GroupController::customFilter($table,$tableColumns,$options);
//$groups = \Hudutech\Controller\GroupController::search($table,$tableColumns,$searchText);
//print_r(json_encode($groups));


$refNo = isset($_GET['k']) ? $_GET['k'] : false;

if ($refNo) {
    $table= 'clients';
    $searchText = $refNo;
    $tableColumns= ['groupRefNo'];
    $options=array(
       // "groupName"=>'KAMAKWA GROUP',
        "refNo"=> $refNo
    );

    $clients = \Hudutech\Controller\ClientController::search($table,$tableColumns,$searchText);


} else {
    //$clients = \Hudutech\Controller\ClientController::all();

}

foreach ($groups as $group ):
    $groupName=$group['groupName'];
endforeach;
?>

<!DOCTYPE html>
<html lang="en">

<head>


    <title>Group Member</title>

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
<!--stop menu-->









    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php  echo $groupName?>  Members</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Registered Group Members
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">

                            <div class="col-md-12 pull-left">
                                <div class="col-sm-6 form-horizontal">
                             </div>
                            </div>

                            <table width="100%" class="table table-striped table-bordered table-hover"
                                   id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>FullName</th>
                                    <th>GroupRefNo</th>
                                    <th>MembershipNo</th>
                                    <th>ID</th>
                                    <th>KRA PIN</th>
                                    <th>PhoneNumber</th>
                                    <th>Email</th>
                                    <th>County</th>

                                    <td>Action</td>

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
                                        <td><?php echo $client['kraPin']?></td>
                                        <td><?php echo $client['phoneNumber']?></td>
                                        <td><?php echo $client['email']?></td>
                                        <td><?php echo $client['county']?></td>

                                        <td colspan="3">
                                            <button class="btn btn-xs btn-primary">Edit</button>
                                            \

                                            <a href="client_profile.php?id=<?php echo urlencode($client['id'])?>" class=" btn-xs btn-primary"> Profile</a>

                                            <button class="btn btn-xs btn-danger">Delete</button>
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




