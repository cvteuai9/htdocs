<?php
require_once("../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請從正常管道進入此頁面";
    exit;
}
$name = $_POST["name"];
$category = $_POST["category"];
$time_s = $_POST["time_s"];
$time_e = $_POST["time_e"];
$point = $_POST["point"];
$content = $_POST["content"];
$price = $_POST["price"];
$image = $_FILES["img"];

if (empty($name) || empty($time_s) || empty($time_e) || empty($point) || empty($content) || empty($price) || empty($image)) {
    echo "請填入必要欄位";
    exit;
}
// 上傳圖片
if ($_FILES["img"]["error"] == 0) {
    // move_uploaded_file({上傳文件在服務器上的臨時文件名稱}, {你希望文件移動到的位置(包含文件名稱)})
    if (move_uploaded_file($_FILES["img"]["tmp_name"], "../activity_images/" . $_FILES["img"]["name"])) {
        echo "upload success";
    } else {
        echo "upload FAIL";
    }
}
$filename = $_FILES["img"]["name"];

$sql = "INSERT INTO activity(name, category_id, time_s, time_e , point , content, price, valid )
VALUES ('$name','$category', '$time_s', '$time_e','$point','$content','$price','1')";
$sqlImage = "INSERT INTO activity_images (path) VALUES ('$filename')";
if ($conn->query($sql) === TRUE) {
    echo "新資料輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
if ($conn->query($sqlImage) === TRUE) {
    echo "新資料輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
// header("location: activity.php");
