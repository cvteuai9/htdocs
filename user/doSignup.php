<?php
require_once("../db_connect.php");
session_start();
if (!isset($_POST["account"])) {
    die("請循正常管道進入此頁");
}

$email = $_POST["email"];
$account = $_POST["account"];
$name = $_POST["name"];
$password = $_POST["password"];
$repassword = $_POST["repassword"];
$phone = $_POST["phone"];
$location = $_POST['location']; // 同样假设 'location' 是 POST 数据中的正确字段名
$gender = $_POST["gender"];
$year = $_POST["birthday-y"];
$month = $_POST["birthday-m"];
$day = $_POST["birthday-d"];

$date = $year . '-' . $month . '-' . $day;
// 檢查帳號是否重複
$sqlCheckUser = "SELECT * FROM users WHERE account='$account'";
$resultCheck = $conn->query($sqlCheckUser);
if ($resultCheck->num_rows > 0) {
    // echo "此帳號已經有人註冊";
    $errorMsg = "此帳號已經有人註冊";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: sign-up.php");
    exit;
}

// 確認使用者帳號輸入格式
if (empty($account)) {
    $errorMsg = "請輸入帳號";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: sign-up.php");

    exit;
}
$accountLength = strlen($account);
if ($accountLength < 4 || $accountLength > 20) {
    $errorMsg =  "請輸入4~20字元的帳號";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: sign-up.php");

    exit;
}
if (empty($name)) {
    $errorMsg = "請輸入姓名";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: sign-up.php");

    exit;
}
if (empty($password)) {

    $errorMsg = "請輸入密碼";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: sign-up.php");

    exit;
}
if ($password != $repassword) {
    $errorMsg = "前後密碼不一致";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: sign-up.php");

    exit;
}
if (empty($gender)) {

    $errorMsg =  "請選擇性別";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: sign-up.php");

    exit;
}
if (empty($date)) {
    $errorMsg = "請選擇生日";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: sign-up.php");

    exit;
}
if ($password != $repassword) {
    $errorMsg = "前後密碼不一致";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: sign-up.php");

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
$password = md5($password); //bb密碼加密後30幾位元

$now = date('Y-m-d H:i:s');
$sql = "INSERT INTO users(name, images_name, account,email, password,phone,location,gender,birthday,created_at, valid) VALUES('$name', '$filename', '$account','$email','$password','$phone','$location','$gender ', '$date','$now',1)";
// echo $sql;


if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;

    $errorMsg = "新資料輸入完成, id 為 $last_id";
    $_SESSION["errorMsg"] =  $errorMsg;
    // echo "新資料輸入完成, id 為 $last_id ";
} else {
    echo "Error:" . $sql . "<br>" . $conn->error;
}

// $row=$result->fetch_assoc();
// unset($_SESSION["errorMsg"]);

$_SESSION["user"] = [
    "id" => $row["id"],
    "account" => $row["account"],
    "name" => $row["name"],
    "email" => $row["email"],
    "password" => $row["password"],
    "birthday" => $row["date"],
    "gender" => $row["gender"],
    "location" => $row["location"],
    "phone" => $row["phone"]

];



$conn->close();
header("location: sign-up.php");
// header("location: users.php");
