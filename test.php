<?php 

// include './connect.php';
// $table = "users";
// // $name = filterRequest("namerequest");
// $data = array( 
// "users_name" => "ashraf",
// "users_email" => "atslook@gmail.com",
// "users_phone" => "324234",
// "users_verfiycode" => "3243243",       
// );
// $count = insertData($table , $data);

include "connect.php" ; 

getAllData("users","1=1");

//sendEmail("atslook@gmail.com" ,"hi" , "from function send email"); 