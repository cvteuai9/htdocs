<?php
require_once("../db_connect.php");

if (!isset($_POST["id"]) && !isset($_POST["category"])) {
    echo "請從正常管道進入";
    exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
//echo $activity;
$category = $_POST["category"];
$time_s = $_POST["time_s"];
$time_e = $_POST["time_e"];
$point = $_POST["point"];
$content = $_POST["content"];
$price = $_POST["price"];
$img = $_POST["img"];

$sql = "UPDATE activity SET name='$name', time_s='$time_s',time_e='$time_e' , point='$point', content='$content' , price='$price' , img='$img' WHERE id = $id ";
$sqlAcr = "UPDATE activity_category_relation SET category_id = '$category' WHERE activity_id = $id";
if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}
if ($conn->query($sqlAcr) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}
header("location: activity.php");
$conn->close();
