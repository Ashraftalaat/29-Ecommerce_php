<?php

include "../../connect.php";

$catid = filterRequest("id");
$imagename =filterRequest("imagename");


deleteFile("../../upload/categories" ,$imagename);

deleteData("categories","categories_id = $catid");