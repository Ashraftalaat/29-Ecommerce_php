<?php 
include "../../connect.php";

// $id = delivery id
$id =filterRequest("id");
//  الطلبات التي استلمها  مندوب التوصيل واصبحت  =3 مع اخذ في الاعتبار انها تخصه هو فقط
getAllData("ordersview" , " 1 = 1 AND orders_status = 3 AND orders_delivery = $id ");

// 0 ->  wait
// 1 ->  prepare
// 2 ->  delivery man
// 3 ->  on the way
// 4 ->  Archive