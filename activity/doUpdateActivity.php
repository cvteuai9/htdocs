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

if ($_FILES["img"]["size"] !== 0) {
    // product_images
    // 上傳圖片至目標資料夾
    if ($_FILES["img"]["error"] == 0) {
        // move_uploaded_file({上傳文件在服務器上的臨時文件名稱}, {你希望文件移動到的位置(包含文件名稱)})
        if (move_uploaded_file($_FILES["img"]["tmp_name"], "../activity_images/" . $_FILES["img"]["name"])) {
            echo "upload success";
        } else {
            echo "upload FAIL";
        }
    }
    // 寫入products_images資料表
    $filename = $_FILES["img"]["name"];
    $sqlImages = "UPDATE activity_images SET path = '$filename' WHERE id=$id";
    if ($conn->query($sqlImages)) {
        echo "圖片更新成功!!";
    } else {
        echo "圖片更新失敗!!" . $conn->error;
    }
}
$sql = "UPDATE activity SET name='$name', category_id = '$category', time_s='$time_s',time_e='$time_e' , point='$point', content='$content' , price='$price' WHERE id = $id ";
if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location: activity.php");
$conn->close();
