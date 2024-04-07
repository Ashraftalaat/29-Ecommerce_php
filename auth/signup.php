<?php

include "../connect.php";

$username   = filterRequest("username");
$password   = sha1($_POST['password']);
$email      = filterRequest("email");
$phone      = filterRequest("phone");
// rand لانشاء رقم عشوائي مكون من 5 ارقام ثم نقوم بحفظه في قاعدة البيانات
$verfiycode =  rand(10000,99999);


$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? OR users_phone = ? ");
$stmt->execute(array($email , $phone));
// التحقق من خلال count 
$count = $stmt->rowCount();
if ($count > 0) {
     printFailure("EMAIL OR PHONE");
}else {
    $data = array (
        "users_name" => $username,
        "users_password" => $password,
        "users_email" => $email,
        "users_phone" => $phone,
        "users_verfiycode" => $verfiycode,  
    ) ;
    // sendEmail($email,"Verfiy Code Commmerce","Verfiy Code $verfiycode" );
     insertData("users",$data);
}
