<?php 
include "../../connect.php";

// هنعرض كل الطلبات التي لم يستلمها اي مندوب توصيل=2 
getAllData("ordersview" , " 1 = 1 AND orders_status = 2 ");

// 0 ->  wait
// 1 ->  prepare
// 2 ->  delivery man
// 3 ->  on the way
// 4 ->  Archive