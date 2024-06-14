<?php

include "../connect.php";

$usersid = filterRequest("usersid");
$itemsid = filterRequest("itemsid");

$count = getData("cart","cart_usersid = $usersid AND cart_itemsid = $itemsid AND cart_orders = 0",null,false);

// هنعمل الشرط من خلال my sql من جدول view  لمعرفة عدد النتج اللي موجود بدل  php
//if ($count>0) {
    
//}else {
$data = array(
    "cart_usersid" => $usersid,
    "cart_itemsid" => $itemsid
);

insertData("cart",$data);

//}