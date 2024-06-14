<?php

include "connect.php";
 //عشان البيانات اللي هترجع هتكون في صورة array = list اللى جواها map
$allData =array();

$allData['status']='success';

$settings = getAllData("settings","1 = 1",null, false);

$allData['settings'] = $settings;

$categories = getAllData("categories",null,null, false);
// يعني خزنل البيانات اللي مخزنة في $categories علي صورة array وسميها categories
$allData['categories'] = $categories;

$items = getAllData("itemstopsellingview","1 = 1 ORDER BY countitems DESC",null, false);

$allData['items'] = $items;

//لتحويلها  لmap تقرأها php
echo json_encode($allData);
