<?php
require_once("../db_connect.php");

if (!isset($_POST["id"])) {
    echo "請循正常管道進入";
    exit;
}

$id = $_POST["id"];
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

// var_dump($image, $product_name, $brand_id, $tea_id, $pack_id, $style_id, $description, $weight, $price, $stock);
$sqlProducts = "UPDATE products SET name='$product_name', description='$description', weight='$weight', price='$price', stock='$stock', created_at='$now', valid = '$valid' WHERE id=$id";

$sqlImages = "UPDATE product_images SET path = '$filename' WHERE id=$id";

$sqlPcr = "UPDATE product_category_relation SET brand_id = '$brand_id', tea_id = '$tea_id', package_id = '$pack_id', style_id = '$style_id' WHERE product_id=$id";

// if ($conn->query($sqlImages) == TRUE) {
//     echo "product_images table 成功修改資料<br>";
// } else {
//     echo "修改商品圖失敗" . $conn->error;
// }

// if ($conn->query($sqlProducts) == TRUE) {
//     echo "products table 成功修改資料<br>";
// } else {
//     echo "修改商品失敗" . $conn->error;
// }
// if ($conn->query($sqlPcr) == TRUE) {
//     echo "product_category_relation table 成功修改資料<br>";
// } else {
//     echo "修改商品關係圖" . $conn->error;
// }
?>
<!doctype html>
<html lang="en">

<head>
    <title>修改商品資訊結果</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container text center">
        <a class="btn btn-success fs-4 mb-3" href="product-detail.php?id=<?= $id ?>">
            <i class="fa-solid fa-arrow-left"></i> 返回商品詳情
        </a>
        <?php if (($conn->query($sqlImages) == TRUE) && ($conn->query($sqlProducts) == TRUE) && ($conn->query($sqlPcr) == TRUE)) : ?>
            <h1>商品資訊修改成功</h1>
        <?php else : ?>
            <h1>商品資訊修改失敗</h1>
            <?php echo $conn->error ?>
        <?php endif; ?>
    </div>

</body>

</html>