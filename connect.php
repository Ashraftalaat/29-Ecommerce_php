<?php
// $dsn = "mysql:host=sql304.infinityfree.com;dbname=if0_36246397_ecommerce";
// $user = "if0_36246397";
// $pass = "A1cCElByIoW6M";
$dsn = "mysql:host=localhost;dbname=ecommerce";
$user = "root";
$pass = "";
$option = array(
   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
);
$countrowinpage = 9;
try {
   $con = new PDO($dsn, $user, $pass, $option);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // السماحhttp request للوصول للباك اند بدون اي مشاكل
   // حتي لايستطيع اي شخص الدخول Api واخذالمعلومات
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Origin");
   header("Access-Control-Allow-Methods: POST, OPTIONS , GET");
   include "functions.php";
   if (!isset($notAuth)) {
      //مش مفعلين header الحماية
      // checkAuthenticate();
   }
} catch (PDOException $e) {
   echo $e->getMessage();
}
