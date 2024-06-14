<?php


include "../connect.php";

$id = filterRequest("id");

// اذا كان هناك اكثر من متجر او مطعم او فرع يجب اضافت usersid بتاعه كمان في الشرط  where
getAllData("myfavorite","favorite_usersid = ?",array($id));