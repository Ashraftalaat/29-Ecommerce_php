<?php

include "../connect.php";

$usersid = filterRequest("usersid");

$data = getAllData("cartview" , "cart_usersid = $usersid " , null , $json = false);

$stmt = $con->prepare("SELECT SUM(cartview.itemsprice) AS totalprice , sum(cartview.countitems) as totalitems FROM cartview
WHERE cartview.cart_usersid = $usersid
GROUP BY cartview.cart_usersid ");
$stmt->execute();

// fetch(PDO::FETCH_ASSOC) عشان هيجيب عمودين اللي مستعلمين عنهم فقط
$datacountprice = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(array(
"status"     => "success" , 
"datacart"   => $data,
"countprice" => $datacountprice
));