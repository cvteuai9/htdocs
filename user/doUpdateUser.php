<?php
// 上傳會員修改功能
require_once("../db_connect.php");
if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}
$id = $_POST["id"];
$sqlImage = "SELECT * FROM users WHERE id=$id";
$resultImage = $conn->query($sqlImage);
$row = $resultImage->fetch_assoc();
if ($_FILES["image"]["size"] == 0) {
    $filename = $row["images_name"];
} else {
    $image = $_FILES["image"];
    // 上傳圖片至目標資料夾
    if ($_FILES["image"]["error"] == 0) {
        // move_uploaded_file({上傳文件在服務器上的臨時文件名稱}, {你希望文件移動到的位置(包含文件名稱)})
        if (move_uploaded_file($_FILES["image"]["tmp_name"], "user_images/" . $_FILES["image"]["name"])) {
            echo "upload success";
        } else {
            echo "upload FAIL";
        }
    }
    // 寫入products_images資料表
    $filename = $_FILES["image"]["name"];
}
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$password = $_POST["password"];
$year = $_POST["birthday-y"];
$month = $_POST["birthday-m"];
$day = $_POST["birthday-d"];
$location = $_POST["location"];

$date = $year . '-' . $month . '-' . $day;

// echo $name;
$password = md5($password);
$sql = "UPDATE users SET name='$name', images_name='$filename', email='$email',password='$password', phone='$phone',gender='$gender',location='$location',birthday='$date'  WHERE id=$id";
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
