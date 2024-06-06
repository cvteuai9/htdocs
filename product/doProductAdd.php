<?php
require_once("../db_connect.php");
session_start();
if (!isset($_POST["product_name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

// product_images
$image = $_FILES["image"];

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
if (empty($product_name)) {
    $errorMsg = "請輸入產品名稱";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: product-add.php");
    exit;
}
if (empty($brand_id)) {
    $errorMsg = "請選擇品牌名稱";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: product-add.php");
    exit;
}
if (empty($tea_id)) {
    $errorMsg = "請選擇茶種";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: product-add.php");
    exit;
}
if (empty($pack_id)) {
    $errorMsg = "請選擇包裝方式";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: product-add.php");
    exit;
}
if (empty($style_id)) {
    $errorMsg = "請選擇茶葉類型";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: product-add.php");
    exit;
}
if (empty($description)) {
    $errorMsg = "請輸入產品描述";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: product-add.php");
    exit;
}
if (empty($weight)) {
    $errorMsg = "請輸入產品重量";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: product-add.php");
    exit;
}
if (empty($price)) {
    $errorMsg = "請輸入價格";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: product-add.php");
    exit;
}
if (empty($stock)) {
    $errorMsg = "請輸入產品庫存量";
    $_SESSION["errorMsg"] = $errorMsg;
    header("location: product-add.php");
    exit;
}

// var_dump($image, $product_name, $brand_id, $tea_id, $package_id, $style_id, $description, $weight, $price, $stock);

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
$sqlImages = "INSERT INTO product_images (path) VALUES ('$filename')";

// 新增資料至products table
$sqlProducts = "INSERT INTO products (name, description, weight, price, stock, created_at, valid) VALUES ('$product_name', '$description', '$weight', '$price', '$stock', '$now', '$valid')";

// 新增資料至product_category_relation
$sqlPcr = "INSERT INTO product_category_relation (brand_id, tea_id, package_id, style_id) VALUES ('$brand_id', '$tea_id', '$pack_id', '$style_id')";

if ($conn->query($sqlImages) == TRUE) {
    echo "product_images table 成功新增資料";
} else {
    echo "新增商品圖失敗" . $conn->error;
}

if ($conn->query($sqlProducts) == TRUE) {
    echo "products table 成功新增資料";
} else {
    echo "新增商品失敗" . $conn->error;
}
if ($conn->query($sqlPcr) == TRUE) {
    echo "product_category_relation table 成功新增資料";
} else {
    echo "新增商品關係圖" . $conn->error;
}
$conn->close();
header("location: product-list.php");
