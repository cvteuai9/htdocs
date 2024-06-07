<?php
require_once("../db_connect.php");

if (!isset($_POST["title"])) {
    echo "請循正常管道進入此頁";
    exit;
}




$id = $_POST["id"];
$title = $_POST["title"];
$choose = $_POST["choose"];
// $optionId=$_POST["optionId"];
$content = $_POST["content"];

$sqlImage = "SELECT * FROM articles WHERE id=$id";
$resultImage = $conn->query($sqlImage);
$rowImage = $resultImage->fetch_assoc();

$now = date('Y-m-d H:i:s');
if ($_FILES["imgUrl"]["size"] == 0) {
    $filename = $rowImage["article_images"];
} else {
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
}
$sql = "UPDATE articles SET category_id='$choose', article_images='$filename', title='$title', content='$content', updated_at='$now' WHERE articles.id ='$id'";

var_dump($choose);

if ($conn->query($sql) === TRUE) {
    echo "新增成功";
} else {
    echo "新增失敗:" . $conn->error;
}

header("location: Articles.php");
