<?php 

include "../connect.php";

$deliveryid = filterRequest("id");

getAllData("delivery" , "delivery_id  = $deliveryid");