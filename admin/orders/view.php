<?php 
include "../../connect.php";

getAllData("ordersview" , " 1 = 1 AND orders_status != 4");

// 0 ->  wait
// 1 ->  prepare
// 2 ->  delivery man
// 3 ->  on the way
// 4 ->  Archive