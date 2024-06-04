<?php
require_once("../db_connect.php");

if (!isset($_POST["category"])) {
    echo "請循正常管道進入此頁";
}

$category = $_POST["category"];
$name = $_POST["name"];
$valid = $_POST["valid"];

switch ($category) {
    case 1:
        $sql = "INSERT INTO tea_category (name, valid) VALUES ('$name', '$valid')";
        break;
    case 2:
        $sql = "INSERT INTO brand (name, valid) VALUES ('$name', '$valid')";
        break;
    case 3:
        $sql = "INSERT INTO pack_category (name, valid) VALUES ('$name', '$valid')";
        break;
    case 4:
        $sql = "INSERT INTO style (name, valid) VALUES ('$name', '$valid')";
        break;
}

if ($conn->query($sql)) {
    echo "成功新增分類";
} else {
    echo "新增分類失敗";
}
$conn->close();
header("location: product-category.php");
