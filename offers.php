<?php

include "./connect.php";


$stmt = $con->prepare("SELECT itemsview.* , 1 AS favorite , (items_price - (items_price * items_discount /100)) AS itemspricediscount FROM itemsview 
INNER JOIN favorite ON itemsview.items_id = favorite.favorite_itemsid 
WHERE items_discount != 0
UNION ALL
SELECT * , 0 AS favorite , (items_price - (items_price * items_discount /100)) AS itemspricediscount FROM itemsview 
WHERE items_discount != 0 AND items_id NOT IN (SELECT items_id FROM itemsview 
INNER JOIN favorite ON itemsview.items_id = favorite.favorite_itemsid )");

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count  = $stmt->rowCount();

if ($count > 0) {
   echo json_encode(array("status" => "success" , "data" => $data));
}else{
   echo json_encode(array("status" => "failure"));
}



