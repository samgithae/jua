<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 26/04/2017
 * Time: 15:37
 */

$successMsg = '';
$errorMsg = '';
if(isset($_POST['ref_no'])) {

    $group = new \Hudutech\Entity\Group();
    $group->setGroupName($_POST['group_name']);

    $group->setRegion($_POST['region']);
    $group->setOfficialContact($_POST['official_contact']);
    $group->setDateFormed($_POST['date_formed']);
    $group->setMonthlyMeetingSchedule($_POST['monthly_meeting_schedule']);

    $groupControl= new \Hudutech\Controller\GroupController();

    $created= $groupControl->update($group,$_POST['id']);

print_r($created);
    if ($created) {

//        echo "<script type='text/javascript'>
//              alert('Group details saved successfully');
//              window.location.href='groups.php';
//
//              </script>";
    } else {

        echo "<script type='text/javascript'>
              alert('Error occured please try again later');
              window.location.href='groups.php';
              
              </script>";

    }


}
else{

    $errorMsg .= "KEY  FIELDS REQUIRED";
}