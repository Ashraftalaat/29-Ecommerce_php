<?php 
include "../../connect.php";

$id = filterRequest("id");

getAllData("ordersview" , " 1 = 1 AND orders_status = 4 AND orders_delivery = $id ");


// 0 ->  wait
// 1 ->  prepare
// 2 ->  delivery man
// 3 ->  on the way
// 4 ->  Archive