<?php 

include "connect.php";

$usersid = filterRequest("id");

getAllData("users" , "users_id = $usersid");