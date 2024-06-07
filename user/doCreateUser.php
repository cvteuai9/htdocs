<?php

require_once("../db_connect.php");
// 接收create-user的資料

session_start();
if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}


$name = $_POST["name"];
$email = $_POST["email"];
$account = $_POST["account"];
$password = $_POST["password"];
$phone = $_POST["phone"];
// $location = $_POST["location"];
$location = $_POST['location']; // 同样假设 'location' 是 POST 数据中的正确字段名
$gender = $_POST["gender"];
// $date = $_POST["birthday"];
$year = $_POST["birthday-y"];
$month = $_POST["birthday-m"];
$day = $_POST["birthday-d"];

$date = $year . '-' . $month . '-' . $day;

// if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($gender) || empty($date) || empty($location)) {
//     echo "請填入必要欄位";
//     exit;
// }
if (empty($name)) {
    $errorMsg = "請輸入姓名";
    $_SESSION["errorMsg"] = $errorMsg;
    // echo   $errorMsg;
    header("location: create-user.php");
    exit;
}
if (empty($email)) {
    $errorMsg = "請輸入Email";
    $_SESSION["errorMsg"] = $errorMsg;
    // echo   $errorMsg;
    header("location: create-user.php");
    exit;
}
if (empty($password)) {
    $errorMsg = "請輸入密碼";
    $_SESSION["errorMsg"] = $errorMsg;
    // echo   $errorMsg;
    header("location: create-user.php");
    exit;
}
if (empty($gender)) {
    $errorMsg = "請選擇性別";
    $_SESSION["errorMsg"] = $errorMsg;
    // echo   $errorMsg;
    header("location: create-user.php");
    exit;
}
if (empty($phone)) {
    $errorMsg = "請輸入電話";
    $_SESSION["errorMsg"] = $errorMsg;
    // echo   $errorMsg;
    header("location: create-user.php");
    exit;
}
if (empty($date)) {
    $errorMsg = "請選擇生日";
    $_SESSION["errorMsg"] = $errorMsg;
    // echo   $errorMsg;
    header("location: create-user.php");
    exit;
}
if ($_FILES["image"]["size"] == 0) {
    $filename = "user.png";
} else {
    $image = $_FILES["image"];
    // 上傳圖片至目標資料夾
    if ($_FILES["image"]["error"] == 0) {
        // move_uploaded_file({上傳文件在服務器上的臨時文件名稱}, {你希望文件移動到的位置(包含文件名稱)})
        if (move_uploaded_file($_FILES["image"]["tmp_name"], "../user_images/" . $_FILES["image"]["name"])) {
            echo "upload success";
        } else {
            echo "upload FAIL";
        }
    }
    // 寫入products_images資料表
    $filename = $_FILES["image"]["name"];
}
$password = md5($password);
$now = date('Y-m-d H:i:s');
// echo $name, $email,$password,$phone,$location,$gender ,$date,$account,$now;
$sql = "INSERT INTO users (name, images_name, email, password, phone, location, gender, birthday, account, created_at)
	VALUES ('$name', '$filename','$email','$password','$phone','$location','$gender ','$date','$account','$now')";








if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
 
    // $errorMsg = "新資料輸入完成, id 為". $last_id ;
    $errorMsg = "註冊成功！";
    $_SESSION["errorMsg"] = $errorMsg;
    
} else {
    
    $errorMsg = "註冊失敗,請重新填寫資訊！";
    $_SESSION["errorMsg"] = $errorMsg;
    // echo "Error" . $sql . "<br>" . $conn->error;
}

$conn->close();
// header("location: users.php");
header("location: create-user.php");
//送出資料後維持再送出的畫面
