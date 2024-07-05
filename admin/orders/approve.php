<?php

include "../../connect.php";

$ordersid = filterRequest("ordersid");
$usersid = filterRequest("usersid");

$data =array(
    "orders_status"  => "1"
);
updateData("orders", $data,"orders_id = $ordersid AND orders_status = 0" );

//  sendGCM("Success" , "The Order Has been Approved" ,"users$usersid", "none" , "refreshorderpending");

//تم عمل فينكشن واحدة لارسال الاشعار وحفظه
inserNotify("Success" , "The Order Has been Approved" ,$usersid,"users$usersid", "none" , "refreshorderpending");