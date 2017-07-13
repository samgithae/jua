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

                                    <th>Remuneration</th>

                                    <th>BankAccNo</th>
                                    <th>PhoneNumber</th>
                                    <th > Action</th>

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

                                        <td><?php echo $employee['remuneration'] ?></td>

                                        <td><?php echo $employee['bankAccountNo'] ?></td>
                                        <td><?php echo $employee['phoneNumber'] ?></td>
                                        <td colspan="3" class="btn-xs">
                                            <button class="btn-xs btn-primary">Edit</button>

                                            <a href="employee_profile.php?id=<?php echo urlencode($employee['id'])?>" class="btn btn-xs btn-primary"> Profile</a>


                                            <button class="btn btn-xs btn-danger  btn-red"
                                                    onclick="deleteEmployee('<?php echo $employee['id'] ?>')"><i
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

    <?php include_once 'footer.php' ?>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"  id="confirmTitle">Confirm Action</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Employee</div>
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
        function deleteEmployee(id) {
            $('#confirmTitle').text('Delete Patient');
            $('#confirmDeleteModal').modal('show');
            var url = 'employee_endpoint.php';
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
