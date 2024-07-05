<?php

// ==========================================================
//  Copyright Reserved Wael Wael Abo Hamza (Course Ecommerce)
// ==========================================================

//date_default_timezone_set("Africa/Cairo");

define("MB", 1048576);
// define("MB", 1048576) يعني متغير ثابت مثل const فنضع define
function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null,$json =true)
{
    global $con;
    $data = array();
    if ($where == null) {
        $stmt = $con->prepare("SELECT  * FROM $table "); 
    }else {
        $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    }
    
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    //لاننا مش عايزين نطبع json مرتين
   if ($json == true) {
    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    return $count;
   }else {
    // لو json مش true يعني في تغيير في القيمة
    if ($count > 0) {
        //اطبعلي الداتا return
        return array("status" => "success" , "data" => $data);
    }else {
        // اما "status" :"failure"
        return array("status" => "failure");
    }
   }
}


function getData($table, $where = null, $values = null,$json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    //لاننا مش عايزين نطبع json مرتين
   if ($json == true) {
    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
}else{
    return $count;
}}



function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($dir , $imageRequest)
{
    //global $msgError لكي نعرفه في الصفحة اللي هنستخدم فيها الفينكشن
  global $msgError;
  //لو يوجد صورة
  if (isset($_FILES[$imageRequest])) {
    // حطينا بجوار الاسم رقم عشوائي حتي لاتتشابه الاسامي
    $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
    // المسار المؤقت اللي هنرفع منه الصورة
    $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
    $imagesize  = $_FILES[$imageRequest]['size'];
    // الامتدادات المسموح بها
    $allowExt   = array("jpg", "png", "gif", "mp3", "pdf" ,"svg");
    $strToArray = explode(".", $imagename);
    $ext        = end($strToArray);
    //لتحويل الامتداد الي احرف صغيرة
    $ext        = strtolower($ext);
  
    if (!empty($imagename) && !in_array($ext, $allowExt)) {
      $msgError = "EXT";
    }
    //يعني ليس اكبر من 2 ميجا حتي لاتظهر رسالة الخطاء
    if ($imagesize > 10 * MB) {
      $msgError = "size";
    }
    if (empty($msgError)) {
        //لرفع الصورة في المسار اللي هنحدده
      move_uploaded_file($imagetmp,  $dir . "/" . $imagename);
      return $imagename;
    } else {
      return "fail";
    }
  }else {
    return "empty";
  }


}



function deleteFile($dir, $imagename)
{
    //التحقق من وجود الملف قبل حذفهfile_exists
    if (file_exists($dir . "/" . $imagename)) {
        //unlink بتقوم بحذف الملف
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
   //لحماية Api باليوسرنام والباسورد
// هنضع الفينكشن في ملف connect.php
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "ats" ||  $_SERVER['PHP_AUTH_PW'] != "ats2024") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

    // End 
}

function printFailure($message = "none"){
    echo json_encode(array("status" => "failure","message"=> $message));
}

function printSuccess($message = "none"){
    echo json_encode(array("status" => "success","message"=> $message));
}

function result($count) {
    if ($count > 0) {
        printSuccess();
    }else{
        printFailure();
    }
}

function sendEmail($to , $title , $body){
    $header = "From: support@waelabohamza.com " . "\n" . "CC: hplanet5000@gmail.com" ; 
    mail($to , $title , $body , $header) ; 
    // تم حذفها لحدوث خطأ لانه
    //jsonDecode بتحول اللي علي هيئة map فقط
    //الموجودة في frontend
   // echo "Success=======================++++++++++++++++++++++" ; 
    }






// ارسال الاشعار من خلال topics
    function sendGCM($title, $message, $topic, $pageid, $pagename)
    {
    
    //هذاللينك خاص بارسال الاشعار من الفايربيز
        $url = 'https://fcm.googleapis.com/fcm/send';
    
        $fields = array(
            //'/topics/' يعني ارسال لكل المستخدمين او ارسال لشخص واحد واضافة usersid
            "to" => '/topics/' . $topic,
            'priority' => 'high',
            'content_available' => true,
    
            'notification' => array(
                "body" =>  $message,
                "title" =>  $title,
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "sound" => "default"
    
            ),
            'data' => array(
                "pageid" => $pageid,
                "pagename" => $pagename
            )
    
        );
    
    
        $fields = json_encode($fields);
        $headers = array(
            // اضافة key الربط مع firebase الموجودة  Cloud Messaging 
            'Authorization: key=' . "AAAAcxmO584:APA91bHW__f98gDStGpfVvykXd-lpK7kXx9hiJLX0OIvfsXKqn5ZwXOSEvmYodS4yGtlz2_HoRehFNwjoiAycqIONoogByO4OKG465iEGn8axqbSkSlC4RgSg17doMqDOFiYHfSO_Tca",
            'Content-Type: application/json'
        );
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    
        $result = curl_exec($ch);
        return $result;
        curl_close($ch);
    }

    //تم عمل فينكشن واحدة لارسال الاشعار وحفظه
    function inserNotify($title,$body,$userid,$topic,$pageid,$pagename){
        global $con;
        $stmt = $con->prepare("INSERT INTO `notification`(`notification_title`, `notification_body`, `notification_userid`) VALUES (?,?,?)");
        $stmt->execute(array($title , $body, $userid));
        sendGCM($title , $body ,$topic, $pageid , $pagename);
        $count = $stmt->rowCount();
    }
    
    