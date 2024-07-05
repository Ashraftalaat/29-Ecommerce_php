<?php

include "../../connect.php";

$username   = filterRequest("username");
$password   = sha1($_POST['password']);
$email      = filterRequest("email");
$phone      = filterRequest("phone");
// rand لانشاء رقم عشوائي مكون من 5 ارقام ثم نقوم بحفظه في قاعدة البيانات
$verfiycode =  rand(10000,99999);


$stmt = $con->prepare("SELECT * FROM admin WHERE admin_email = ? OR admin_phone = ? ");
$stmt->execute(array($email , $phone));
// التحقق من خلال count 
$count = $stmt->rowCount();
if ($count > 0) {
     printFailure("EMAIL OR PHONE");
}else {
    $data = array (
        "admin_name" => $username,
        "admin_password" => $password,
        "admin_email" => $email,
        "admin_phone" => $phone,
        "admin_verfiycode" => $verfiycode,  
    ) ;
    // sendEmail($email,"Verfiy Code Commmerce","Verfiy Code $verfiycode" );
     insertData("admin",$data);
}