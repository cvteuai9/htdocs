<?php
require_once("../db_connect.php");

if (!isset($_GET["valid"])) {
    echo "請循正常管道進入";
    exit;
}

$id = $_GET["id"];
$valid = $_GET["valid"];
$category = $_GET["category"];
if ($valid == 0) {
    $valid = 1;
} else {
    $valid = 0;
}
switch ($category) {
    case 1:
        $sql = "UPDATE tea_category SET valid='$valid' WHERE id=$id";
        break;
    case 2:
        $sql = "UPDATE brand SET valid='$valid' WHERE id=$id";
        break;
    case 3:
        $sql = "UPDATE pack_category SET valid='$valid' WHERE id=$id";
        break;
    case 4:
        $sql = "UPDATE style SET valid='$valid' WHERE id=$id";
        break;
}
if ($conn->query($sql) == TRUE) {
    echo "修改成功";
}
$conn->close();
header("location: product-category.php");
