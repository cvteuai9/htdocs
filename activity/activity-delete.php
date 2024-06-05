<?php
require_once("../db_connect.php");

if (!isset($_GET["id"])) {
    echo "正常管道進入此頁面";
    exit;
}

$id = $_GET["id"];
echo $id;
$sql = "UPDATE activity SET valid=0 WHERE id=$id";
//軟刪除 不會真的直接刪掉。

if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

header("location:activity.php");
