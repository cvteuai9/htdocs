<?php
require_once("../db_connect.php");

if (!isset($_POST["id"]) || !isset($_POST["category"])) {
    echo "請循正常管道進入";
}

$id = $_POST["id"];
$category = $_POST["category"];
$name = $_POST["name"];
$valid = $_POST["valid"];
switch ($category) {
    case 1:
        $sql = "UPDATE tea_category SET name = '$name', valid='$valid' WHERE id=$id";
        break;
    case 2:
        $sql = "UPDATE brand SET name = '$name', valid='$valid' WHERE id=$id";
        break;
    case 3:
        $sql = "UPDATE pack_category SET name = '$name', valid='$valid' WHERE id=$id";
        break;
    case 4:
        $sql = "UPDATE style SET name = '$name', valid='$valid' WHERE id=$id";
        break;
}

if ($conn->query($sql) == TRUE) {
    echo "修改成功";
}
$conn->close();
header("location: product-category.php");
