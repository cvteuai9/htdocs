<?php
// 連接project資料庫

$servername = "localhost";
$username = "admin";
$password = "12345";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
} else {
    // echo "連線成功";
}
// 將db_connect.php放置跟目錄，方便以後操作
// 重要連結API時，若寫在外面的註解，會影響JSON讀取，產生錯誤
