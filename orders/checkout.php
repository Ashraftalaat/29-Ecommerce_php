<?php 

include "../connect.php";

$usersid = filterRequest("usersid");
$addressid = filterRequest("addressid");
$orderstype = filterRequest("orderstype");
$pricedelivery = filterRequest("pricedelivery");
$ordersprice = filterRequest("ordersprice");
$couponid = filterRequest("couponid");
$coupondiscount = filterRequest("coupondiscount");
$paymentmethod = filterRequest("paymentmethod");



if ($orderstype == "1") {
  $pricedelivery = 0;
}

$totalprice = $ordersprice + $pricedelivery;
// Check Coupon
$now = date("Y-m-d H:i:s");

$checkcoupon =  getData("coupon" , "coupon_id = '$couponid' AND coupon_expiredate > '$now' AND coupon_count > 0",null,false);



if($checkcoupon > 0){
    //لو هنخصم $coupondiscount من اجمالي $totalprice بعد اضافة $pricedelivery  هنغيرها بال $totalprice
  $totalprice = $totalprice - ($ordersprice * $coupondiscount / 100) ;
  $stmt = $con->prepare("UPDATE `coupon` SET `coupon_count` = `coupon_count` - 1 WHERE `coupon_id` = $couponid");
  $stmt->execute();
}

$data =array(
"orders_usersid"           => $usersid ,
"orders_address"           => $addressid ,
"orders_type"              => $orderstype ,
"orders_pricedelivery"     => $pricedelivery ,
"orders_price"             => $ordersprice ,
"orders_totalprice"        => $totalprice ,
"orders_coupon"            => $couponid ,
"coupondiscount"           => $coupondiscount ,
"orders_paymentmethod"     => $paymentmethod ,
) ;

// تم جعلها false لاننا مش عايزين نطبع البيانات
$count = insertData("orders" , $data , false);

if ($count > 0) {
    $stmt = $con->prepare("SELECT MAX(orders_id) FROM orders");
    $stmt->execute();
    $maxid = $stmt->fetchColumn();

    $data = array("cart_orders" => $maxid);

    updateData("cart" , $data , "cart_usersid = $usersid AND cart_orders = 0");
}
   

