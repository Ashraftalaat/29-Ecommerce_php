<?php

include "../../connect.php";


$email  = filterRequest("email");

$verfiy = filterRequest("verfiycode");

// استعلم حيث الايميل اللي دخله في فرونت بيساوي الايميل الموجود في قاعدة البيانات
$stmt = $con->prepare("SELECT * FROM admin WHERE admin_email = '$email' AND admin_verfiycode = '$verfiy'");
//نفذ
$stmt->execute();
//count = lenght
$count = $stmt->rowCount();

if ($count > 0) {
    //هنعدل approve بيساوي 1 بدل 0 في حالة ادخال verfiycode صح
    $data = array("admin_approve" => "1");
    //هنفذ فينكشن التعديل 
    updateData("admin", $data , "admin_email = '$email'");
}else {
 printFailure("Verfiy code not correct");
}
