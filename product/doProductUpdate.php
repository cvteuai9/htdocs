<?php
require_once("../db_connect.php");

if (!isset($_POST["id"])) {
    echo "請循正常管道進入";
    exit;
}
$id = $_POST["id"];
// products
$product_name = $_POST["product_name"];
$description = $_POST["description"];
$weight = $_POST["weight"];
$price = $_POST["price"];
$stock = $_POST["stock"];
$valid = $_POST["valid"];
$now = date('Y-m-d H:i:s');
// product_category_relation
$brand_id = $_POST["brand_id"];
$tea_id = $_POST["tea_id"];
$pack_id = $_POST["pack_id"];
$style_id = $_POST["style_id"];

if ($_FILES["image"]["size"] !== 0) {
    // product_images
    $image = $_FILES["image"];
    // 上傳圖片至目標資料夾
    if ($_FILES["image"]["error"] == 0) {
        // move_uploaded_file({上傳文件在服務器上的臨時文件名稱}, {你希望文件移動到的位置(包含文件名稱)})
        if (move_uploaded_file($_FILES["image"]["tmp_name"], "../product_images/" . $_FILES["image"]["name"])) {
            echo "upload success";
        } else {
            echo "upload FAIL";
        }
    }
    // 寫入products_images資料表
    $filename = $_FILES["image"]["name"];
    $sqlImages = "UPDATE product_images SET path = '$filename' WHERE id=$id";
    if ($conn->query($sqlImages)) {
        echo "圖片更新成功!!";
    } else {
        echo "圖片更新失敗!!" . $conn->error;
    }
}

$sqlProducts = "UPDATE products SET name='$product_name', description='$description', weight='$weight', price='$price', stock='$stock', created_at='$now', valid = '$valid' WHERE id=$id";

$sqlPcr = "UPDATE product_category_relation SET brand_id = '$brand_id', tea_id = '$tea_id', package_id = '$pack_id', style_id = '$style_id' WHERE product_id=$id";

if ($conn->query($sqlProducts)) {
    echo "商品更新成功!!";
} else {
    echo "商品更新失敗!!" . $conn->error;
}
if ($conn->query($sqlPcr)) {
    echo "關聯表更新成功!!";
} else {
    echo "關聯表更新失敗!!" . $conn->error;
}
$conn->close();
header("location: product-detail.php?id=$id");
