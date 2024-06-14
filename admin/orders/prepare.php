<?php

include "../../connect.php";

$ordersid =filterRequest("ordersid");
$usersid =filterRequest("usersid");


$type =filterRequest("orderstype");
if ($type == "0") {
    $data =array(
        "orders_status"  => "2"
    );
}else {
    //يعني العميل هو اللي راح استلمةن 
    $data =array(
        "orders_status"  => "4"
    );

}


updateData("orders", $data,"orders_id = $ordersid AND orders_status = 1" );

//  sendGCM("Success" , "The Order Has been Approved" ,"users$usersid", "none" , "refreshorderpending");

//تم عمل فينكشن واحدة لارسال الاشعار وحفظه
inserNotify("Success" , "The Order Has been Approved" ,$usersid,"users$usersid", "none" , "refreshorderpending");

// لارسال اشعار لمندوب التوصيل انه في اوردر  
if ($type == "0") {
    sendGCM("Warning" , "there is a orders awaiting Approval" ,"delivery", "none" , "none");
}

//if ($type == "4") {
  //  inserNotify("Success" , "Thank uou for your trust in our store" ,$usersid,"users$usersid", "none" , "refreshorderpending");
//}
