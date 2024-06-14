<?php

include "../../connect.php";

$email  = filterRequest("email");

$verfiy = filterRequest("verfiycode");

// استعلم حيث الايميل اللي دخله في فرونت بيساوي الايميل الموجود في قاعدة البيانات
$stmt = $con->prepare("SELECT * FROM delivery WHERE delivery_email = '$email' AND delivery_verfiycode = '$verfiy'");
//نفذ
$stmt->execute();
//count = lenght
$count = $stmt->rowCount();

if ($count > 0) {
    //هنعدل approve بيساوي 1 بدل 0 في حالة ادخال verfiycode صح
    $data = array("delivery_approve" => "1");
    //هنفذ فينكشن التعديل 
    updateData("delivery", $data , "delivery_email = '$email'");
}else {
 printFailure("Verfiy code not correct");
}




