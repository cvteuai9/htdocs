<?php
// 會員照片上傳POST
require_once("../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";

    exit;
}
$year = $_POST["birthday-y"];
$month = $_POST["birthday-m"];
$day = $_POST["birthday-d"];

$date = $year . '-' . $month . '-' . $day;



// $photo_name
$pic_name = $_POST["name"];
// echo $name;
// var_dump($_FILES["file"]);
//跟著file-upload.php中上傳系統的name



if ($_FILES["file"]["error"] == 0) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/" . $_FILES["file"]["name"])) {
        echo "upload success"; //檔案上傳成功
    } else {
        echo "upload failed"; //檔案上傳失敗
    }
}


$pic_name = $_FILES["file"]["name"];
$sql = "INSERT INTO images (pic_name)
	VALUES ('$pic_name')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
header("location: file-upload.php");
