<?php

include "../connect.php";

$categoryId = filterRequest("id");
$userid = filterRequest("usersid");

// getAllData("itemsview" , " $categoryId = categories_id");

$stmt = $con->prepare("SELECT itemsview.* , 1 AS favorite FROM itemsview 
INNER JOIN favorite ON itemsview.items_id = favorite.favorite_itemsid AND favorite.favorite_usersid = $userid
WHERE categories_id = $categoryId
UNION ALL
SELECT * , 0 AS favorite FROM itemsview 
WHERE categories_id = $categoryId AND items_id NOT IN (SELECT items_id FROM itemsview 
INNER JOIN favorite ON itemsview.items_id = favorite.favorite_itemsid AND favorite.favorite_usersid = $userid)");

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count  = $stmt->rowCount();

if ($count > 0) {
   echo json_encode(array("status" => "success" , "data" => $data));
}else{
   echo json_encode(array("status" => "failure"));
}

