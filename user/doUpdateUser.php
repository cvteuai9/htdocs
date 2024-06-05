<?php
// 上傳會員修改功能
require_once("../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$password = $_POST["password"];
// $date = $_POST["birthday"];
$year = $_POST["birthday-y"];
$month = $_POST["birthday-m"];
$day = $_POST["birthday-d"];
// $location = $_POST["location"];

$date = $year . '-' . $month . '-' . $day;



// echo $name;

$sql = "UPDATE users SET name='$name', email='$email',password='password', phone='$phone',gender='$gender',birthday='$date'  WHERE id=$id";
// ,location='$location'


// echo $sql;
// exit;

if ($conn->query($sql) === TRUE) {
    //執行讀取資料表動作
    echo "更新成功";
} else {
    echo "更新資料錯誤:" . $conn->error;
}
header("location: user-edit.php?id=" . $id);
$conn->close();
