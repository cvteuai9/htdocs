<?php
require_once("../db_connect.php");

if (!isset($_GET["valid"])) {
    echo "請循正常管道進入";
    exit;
}

$id = $_GET["id"];
$valid = $_GET["valid"];
if ($valid == 0) {
    $valid = 1;
} else {
    $valid = 0;
}
$sql = "UPDATE products SET valid = $valid WHERE id = $id";

?>



<!doctype html>
<html lang="en">

<head>
    <title>商品上下架</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container text-center">
        <div>
            <?php if (($conn->query($sql) == TRUE) && $valid == 0) : ?>
                <h1>商品下架成功</h1>
            <?php else : ?>
                <h1>商品上架成功</h1>
            <?php endif; ?>
        </div>
        <div>
            <a class="btn btn-success fs-4 mb-3" href="product-list.php?page=1&order=1">
                <i class="fa-solid fa-arrow-left"></i> 返回商品列表
            </a>
        </div>
    </div>
</body>

</html>