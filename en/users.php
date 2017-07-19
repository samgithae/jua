<?php

require_once __DIR__.'/../vendor/autoload.php';
$users = \Hudutech\Controller\UserController::all();
//print_r($users);
$counter=1;
?>


<!DOCTYPE html>
<html lang="en">

<head>



    <title>Users</title>

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
    <?php include_once 'right_menu.php'?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Users</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Registered Users
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>email</th>


                                    <td>Action</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $user ): ?>
                                    <tr>
                                        <td><?php echo $counter++ ?></td>
                                        <td><?php echo $user['username'] ?></td>
                                        <td><?php echo $user['email'] ?></td>
                                        <td>
                                            <a href="change_password.php?username=<?php echo urlencode($user['username'])?>" class="btn btn-default"><i class="entypo-lock-open"></i>Change Password</a>


                                            <button class="btn btn-xs btn-danger  btn-red"
                                                    onclick="deletePatient('<?php echo $user['id'] ?>')"><i
                                                        class="entypo-cancel"></i>Delete
                                            </button>
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


    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"  id="confirmTitle">Confirm Action</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button"  id='btnConfirmDelete' class="btn btn-danger">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        <
        <!-- /.modal -->
    </div>
    <!-- .panel-body -->


    <script>
        function deletePatient(id) {
            $('#confirmTitle').text('Delete User');
            $('#confirmDeleteModal').modal('show');
            var url = 'user_endpoint.php';
            $('#btnConfirmDelete').on('click', function (e) {
                e.preventDefault;
                $.ajax(
                    {
                        type: 'DELETE',
                        url: url,
                        data: JSON.stringify({'id': id}),
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8',
                        success: function (response) {
                            if (response.statusCode == 204) {
                                $('#confirmFeedback').removeClass('alert alert-danger')
                                    .addClass('alert alert-success')
                                    .text(response.message);
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            }
                            if (response.statusCode == 500) {
                                $('#confirmFeedback').removeClass('alert alert-success')
                                    .html('<div class="alert alert-danger alert-dismissable">' +
                                        '<a href="#" class="close"  data-dismiss="alert" aria-label="close">&times;</a>' +
                                        '<strong>Error! </strong> ' + response.message + '</div>')

                            }
                        }
                    }
                )
            });
        }
    </script>




</body>
</html>

