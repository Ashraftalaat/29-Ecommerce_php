<?php

include "../../connect.php";

$ordersid =filterRequest("ordersid");
$usersid =filterRequest("usersid");

$data =array(
    "orders_status"  => 4
);
updateData("orders", $data,"orders_id = $ordersid AND orders_status = 3" );

//  sendGCM("Success" , "The Order Has been Approved" ,"users$usersid", "none" , "refreshorderpending");

//تم عمل فينكشن واحدة لارسال الاشعار وحفظه
inserNotify("Success" , "Your order has been deliverd" ,$usersid,"users$usersid", "none" , "refreshorderpending");

sendGCM("Warning" , "the order has been deliverd to The Customer" ,"services", "none" , "none");
