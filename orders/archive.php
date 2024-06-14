<?php 
include "../connect.php";

$usersid = filterRequest("id");

getAllData("ordersview" , "orders_usersid = $usersid AND orders_status = 4");


// 0 ->  wait
// 1 ->  prepare
// 2 ->  delivery man
// 3 ->  on the way
// 4 ->  Archive