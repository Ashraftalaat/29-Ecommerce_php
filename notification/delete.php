<?php

include "../connect.php";

$usersid = filterRequest("usersid");
$notificationid = filterRequest("notificationid");


deleteData("notification","notification_userid = $usersid AND notification_id  = $notificationid ");