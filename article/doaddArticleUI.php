<?php
require_once("../db_connect.php");

if (!isset($_POST["title"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$title = $_POST["title"];
$choose = $_POST["choose"];
$content = $_POST["content"];

if (empty($title) || empty($choose) || empty($imgUrl) || empty($content)) {
    echo "請填入必要欄位";
}

$now = date('Y-m-d H:i:s');

$image = $_FILES["imgUrl"];
if ($_FILES["imgUrl"]["error"] == 0) {
    // move_uploaded_file({上傳文件在服務器上的臨時文件名稱}, {你希望文件移動到的位置(包含文件名稱)})
    if (move_uploaded_file($_FILES["imgUrl"]["tmp_name"], "../Articles_image/" . $_FILES["imgUrl"]["name"])) {
        echo "upload success";
    } else {
        echo "upload FAIL";
    }
}
$filename = $_FILES["imgUrl"]["name"];


$sql = "INSERT INTO articles (category_id, title, content, created_at, updated_at, article_images,valid) VALUES('$choose','$title','$content','$now','$now','$filename','1')";
if ($conn->query($sql) === TRUE) {
    // insert_id是確保抓到最新的這筆資料的id
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("location:Articles.php");
