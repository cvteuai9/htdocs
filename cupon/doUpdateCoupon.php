<?php
require_once("../db_connect.php");

if(!isset($_POST["name"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_POST["id"];
$name=$_POST["name"];
$code=$_POST["code"];
$category=$_POST["category"];
$discount=$_POST["discount"];
$min_spend_amount = isset($_POST['min_spend_amount']) ? $_POST['min_spend_amount'] : 0;
$stock=$_POST["stock"];
$status=$_POST["status"];
$start_time=$_POST["start_time"];
$end_time=$_POST["end_time"];


$sql="UPDATE coupons SET name='$name', code='$code',category='$category',discount='$discount',min_spend_amount='$min_spend_amount',stock='$stock',status='$status', start_time='$start_time',end_time='$end_time' WHERE id=$id";


if ($conn->query($sql) === TRUE) { 
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}
header("location: coupon.php?id=".$id);

$conn->close();
?>