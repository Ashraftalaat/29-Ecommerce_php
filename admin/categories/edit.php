<?php

include "../../connect.php";

$table = "categories";
$name =filterRequest("name");
$namear =filterRequest("namear");
$catid =filterRequest("id");
// هنحصل عليها من frontend
$imageold =filterRequest("imageold");


$imagename = imageUpload("../../upload/categories" , "files");

if ($imagename == "empty") {
    $data = array(
        "categories_name"     =>  $name,
        "categories_name_ar"  =>  $namear
    );
}else {
    // لازم نحذف الصورة القديمة الاول ثم نضيف الجديدة
    deleteFile("../../upload/categories" , $imageold);
    $data = array(
        "categories_name"     =>  $name,
        "categories_name_ar"  =>  $namear,
        "categories_image"    =>  $imagename
    );
}

updateData($table , $data,"categories_id = $catid");
