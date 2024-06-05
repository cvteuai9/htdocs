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
$img = $_POST["img"];

if (empty($name) || empty($time_s) || empty($time_e) || empty($point) || empty($content) || empty($price) || empty($img)) {
    echo "請填入必要欄位";
    exit;
}

//echo "$activity, $category, $time, $point, $containt, $price, $img";



$sql = "INSERT INTO activity(name, time_s, time_e , point , content, price, img, valid )
VALUES ('$name', '$time_s', '$time_e','$point','$content','$price','$img','1')";
$sqlAc = "INSERT INTO activity_category_relation (category_id) VALUES ($category)";
//echo $sql;

if ($conn->query($sql) === TRUE) {
    echo "新資料輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
if ($conn->query($sqlAc) === TRUE) {
    echo "新資料輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
header("location: activity.php");
