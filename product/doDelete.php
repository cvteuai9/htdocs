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
if (($conn->query($sql) == TRUE) && $valid == 0) {
    echo "商品下架成功";
} else {
    echo "商品上架成功";
}
$conn->close();
header("location:product-list.php?page=1&order=1");
