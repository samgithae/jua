<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/27/17
 * Time: 7:18 AM
 */
require_once __DIR__.'/../vendor/autoload.php';
$clients = \Hudutech\Controller\ClientController::all();

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

                                                <a href="edit_client.php?id=<?php echo urlencode($client['id'])?>" class="btn btn-xs btn-primary"> Edit</a>
                                                <a href="client_profile.php?id=<?php echo urlencode($client['id'])?>" class="btn btn-xs btn-primary"> Profile</a>
                                                <button class="btn btn-xs btn-danger  btn-red"
                                                        onclick="deletePatient('<?php echo $client['id'] ?>')"><i
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



        <!-- /.panel-heading -->


            <!-- Modal -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"  id="confirmTitle">Confirm Action</h4>
                        </div>
                        <div class="modal-body">
                           Are you sure you want to delete this client</div>
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
                $('#confirmTitle').text('Delete Patient');
                $('#confirmDeleteModal').modal('show');
                var url = 'client_endpoint.php';
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



