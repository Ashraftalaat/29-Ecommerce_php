<?php

include "../../connect.php";

$deliveryname   = filterRequest("deliveryname");
$password   = sha1($_POST['password']);
$email      = filterRequest("email");
$phone      = filterRequest("phone");
// rand لانشاء رقم عشوائي مكون من 5 ارقام ثم نقوم بحفظه في قاعدة البيانات
$verfiycode =  rand(10000,99999);


$stmt = $con->prepare("SELECT * FROM delivery WHERE delivery_email = ? OR delivery_phone = ? ");
$stmt->execute(array($email , $phone));
// التحقق من خلال count 
$count = $stmt->rowCount();
if ($count > 0) {
     printFailure("EMAIL OR PHONE");
}else {
    $data = array (
        "delivery_name" => $deliveryname,
        "delivery_password" => $password,
        "delivery_email" => $email,
        "delivery_phone" => $phone,
        "delivery_verfiycode" => $verfiycode,  
    ) ;
    // sendEmail($email,"Verfiy Code Commmerce","Verfiy Code $verfiycode" );
     insertData("delivery",$data);
}
