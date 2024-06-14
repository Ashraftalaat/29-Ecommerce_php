<?php

include "../../connect.php";

$ordersid =filterRequest("ordersid");
$usersid =filterRequest("usersid");
$deliveryid =filterRequest("deliveryid");

$data =array(
    "orders_status"    => 3,
    "orders_delivery"  => $deliveryid 
);
updateData("orders", $data,"orders_id = $ordersid AND orders_status = 2" );

//  sendGCM("Success" , "The Order Has been Approved" ,"users$usersid", "none" , "refreshorderpending");

//تم عمل فينكشن واحدة لارسال الاشعار الي المستخدم بعد استلام مندوب التوصيل الالوردر وحفظه
inserNotify("Success" , "Your order is on  the Way" ,$usersid,"users$usersid", "none" , "refreshorderpending");

// عايزين نرسل الاشعار بدون حفظه
sendGCM("Warning" , "The orders has been approved by delivery","services", "none" , "none");


sendGCM("warning" , "The Order Has been Approved by delivery  " . $deliveryid , "delivery" , "none" , "none"); 