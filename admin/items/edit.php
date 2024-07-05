<?php

include "../../connect.php";

$table = "items";
$id=filterRequest("id");
$name =filterRequest("name");
$namear =filterRequest("namear");
$desc =filterRequest("desc");
$descar =filterRequest("descar");
$count =filterRequest("count");
$price =filterRequest("price");
$discount =filterRequest("discount");

$active =filterRequest("active");

//$datenow =date("Y-m-d H:i:s");

$catid =filterRequest("catid");
// هنحصل عليها من frontend
$imageold =filterRequest("imageold");


$imagename = imageUpload("../../upload/items" , "files");

if ($imagename == "empty") {
    $data = array(
    "items_name"      =>  $name,
    "items_name_ar"   =>  $namear,
    "items_desc"      =>  $desc,
    "items_desc_ar"   =>  $descar,
    "items_count"     =>  $count,
    "items_active"    =>  $active,
    "items_price"     =>  $price,
    "items_discount"  =>  $discount,
    "items_cat"       =>  $catid,
    );
}else {
    // لازم نحذف الصورة القديمة الاول ثم نضيف الجديدة
    deleteFile("../../upload/items" , $imageold);
    $data = array(
    "items_name"      =>  $name,
    "items_name_ar"   =>  $namear,
    "items_image"     =>  $imagename,
    "items_desc"      =>  $desc,
    "items_desc_ar"   =>  $descar,
    "items_count"     =>  $count,
    "items_active"    =>  $active,
    "items_price"     =>  $price,
    "items_discount"  =>  $discount,
    "items_cat"       =>  $catid,
    );
}

updateData($table , $data,"items_id = $id");
