<?php

include "connect.php";
 //عشان البيانات اللي هترجع هتكون في صورة array = list اللى جواها map
$allData =array();

$allData['status']='success';

$categories = getAllData("categories",null,null, false);
// يعني خزنل البيانات اللي مخزنة في $categories علي صورة array وسميها categories
$allData['categories'] = $categories;

$items = getAllData("itemsview","items_discount > 0",null, false);

$allData['items'] = $items;

//لتحويلها  لmap تقرأها php
echo json_encode($allData);
