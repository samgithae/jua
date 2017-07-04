<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 04/05/2017
 * Time: 13:58
 */
require_once __DIR__ . '/../vendor/autoload.php';
use Hudutech\DBManager\ComplexQuery;
use Hudutech\Controller\SavingController;
use Hudutech\Entity\Saving;

$contributions = SavingController::getTodaySaving();
$successMsg = '';
$errorMsg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['clientIdNo']) && !empty($_POST['contribution'])) {
        $table = "clients";
        $tableColumn = ["id", "groupRefNo"];
        $options = ["idNo" => $_POST['clientIdNo'], "limit" => 1];
        $client = ComplexQuery::customFilter($table, $tableColumn, $options);
        $clientId = $client[0]['id'];
        $groupRefNo = $client[0]['groupRefNo'];
        $table2 = "sacco_group";
        $tableColumn2 = ['id'];
        $options2 = ["refNo" => $groupRefNo, "limit" => 1];
        $group = ComplexQuery::customFilter($table2, $tableColumn2, $options2);
        $groupId = $group[0]['id'];
        $datePaid = date("Y-m-d h:i:s");

        $saving = new Saving();
        $saving->setGroupId($groupId);
        $saving->setClientId($clientId);
        $saving->setCashRecieved($_POST['contribution']);
        $saving->setPaymentMethod("Cash");
        $saving->setDatePaid($datePaid);

        $savingCtrl = new SavingController();
        $created = $savingCtrl->createSingle($saving);

        if ($created === true) {
            $successMsg .= "Contribution Received Successfully";
            header("Refresh:0");
        } elseif(isset($created['error'])) {
           // $errorMsg .= "Error Occurred Contribution not recorded. Try again later";
            $errorMsg .= "Error Occurred  {$created['error']}";
        }
    } else {
        $errorMsg .= "All fields required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Record Savings</title>

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
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Record Savings</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Record saving for a client
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col col-md-12">
                                <div class="col col-md-10 col-md-offset-1">
                                    <div>
                                        <div>
                                            <?php
                                            if (empty($successMsg) && !empty($errorMsg)) {
                                                ?>
                                                <div class="alert alert-danger alert-dismissable">
                                                    <a href="#" class="close" data-dismiss="alert"
                                                       aria-label="close">&times;</a>
                                                    <?php echo $errorMsg ?>
                                                </div>
                                                <?php
                                            } elseif (empty($errorMsg) and !empty($successMsg)) {
                                                ?>
                                                <div class="alert alert-success alert-dismissable">
                                                    <a href="#" class="close" data-dismiss="alert"
                                                       aria-label="close">&times;</a>
                                                    <?php echo $successMsg ?>
                                                </div>

                                                <?php
                                            }

                                            ?>
                                        </div>
                                        <div class="col-md-6">

                                        <form class="form-group" action="record_saving.php" method="post">
                                            <label for="clientIdNo">National Id:</label>
                                            <input type="number" class="form-control" name="clientIdNo" id="clientIdNo"
                                                   required>

                                            <label for="contribution">Contribution:</label>
                                            <input type="number" class="form-control" name="contribution"
                                                   id="contribution" required>
                                            <input type="submit" value="submit" class="btn btn-primary btn-block"
                                                   onclick="return confirm('Are you sure you want to continue and record to savings?"
                                            style="margin-top: 10px;">
                                        </form>
                                    </div>
                                    <?php if(sizeof($contributions) > 0):?>
                                    <div class="col-md-10 table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>FullName</th>
                                                <th>Group</th>
                                                <th>Today Contribution</th
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($contributions as $contribution): ?>
                                                <tr>
                                                    <td><?php echo $contribution['fullName'] ?></td>
                                                    <td><?php echo $contribution['groupName'] ?></td>
                                                    <td><?php echo $contribution['contribution'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--start menu-->
<?php
include 'footer.php';

?>

</body>
</html>
