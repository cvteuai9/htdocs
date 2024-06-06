<?php
require_once("../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$name = $_POST["name"];
$code = $_POST["code"];
$category = $_POST["category"];
$discount = $_POST["discount"];
$min_spend_amount = $_POST["min_spend_amount"];
$stock = $_POST["stock"];

$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];

$starttime = strtotime($_POST["start_time"]);
$endtime = strtotime($_POST["end_time"]);
$now = time(); // 当前时间的时间戳
if ($endtime - $now > 0 && $starttime - $now < 0) {

    $status = "可使用";
} elseif ($starttime - $now > 0) {

    $status = "未開放";
} else {
    $status = "已停用";
}

if (empty($name) || empty($code) || empty($category) || empty($discount) || empty($stock) || empty($start_time) || empty($end_time)) {
    echo "請填入必要欄位";
    exit;
}



$sql = "INSERT INTO coupons (name, code, category, discount, min_spend_amount, stock, status, start_time, end_time) 
VALUES ('$name', '$code', '$category', '$discount','$min_spend_amount', '$stock','$status', '$start_time', '$end_time')";


if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功,id為$last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("location: coupons.php");
