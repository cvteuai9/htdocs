<?php
// 刪除使用者
require_once("../db_connect.php");

if(!isset($_GET["id"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_GET["id"];

$sql = "UPDATE users SET valid=0 WHERE id=$id";
// 相較於delete更建議設定valid=0之軟刪除方式
if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

header("location: users.php")
//刪除完畢後，跳回主畫面

?>