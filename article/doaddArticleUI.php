<?php
require_once("../db_connect.php");

if(!isset($_POST["title"])){
    echo "請循正常管道進入此頁";
    exit;
}

$title = $_POST["title"];
$choose = $_POST["choose"];
$imgUrl = $_POST["imgUrl"];
$content = $_POST["content"];

if(empty($title) || empty($choose) || empty($imgUrl) || empty($content)){
    echo "請填入必要欄位";
}

$now = date('Y-m-d H:i:s');


$sql = "INSERT INTO articles (category_id, title, content, created_at, updated_at, article_images,valid) VALUES('$choose','$title','$content','$now','$now','$imgUrl','1')";
if ($conn->query($sql) === TRUE) {
    // insert_id是確保抓到最新的這筆資料的id
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("location:Articles.php")
?>

