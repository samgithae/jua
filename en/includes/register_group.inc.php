<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 26/04/2017
 * Time: 15:37
 */

$successMsg = '';
$errorMsg = '';
if(isset($_POST['group_name'],$_POST['ref_no'])) {
    $group = new \Hudutech\Entity\Group();
    $group->setGroupName($_POST['group_name']);
    $group->setRefNo($_POST['ref_no']);
    $group->setRegion($_POST['region']);
    $group->setOfficialContact($_POST['official_contact']);
    $group->setDateFormed($_POST['date_formed']);
    $group->setMonthlyMeetingSchedule($_POST['monthly_meeting_schedule']);
    $groupControl= new \Hudutech\Controller\GroupController();
    $created= $groupControl->create($group);


    if ($created) {
        $successMsg .= "Group details saved successfully";
    } else {
        $errorMsg .= "error occured";

    }

}
else{

    $errorMsg .= "KEY  FIELDS REQUIRED";
}