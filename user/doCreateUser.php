<?php
require_once("../db_connect.php");
// 接收create-user的資料


if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}


$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$phone = $_POST["phone"];
// $location = $_POST["location"];
$location = $_POST['location']; // 同样假设 'location' 是 POST 数据中的正确字段名


$gender = $_POST["gender"];
// $date = $_POST["birthday"];
$year = $_POST["birthday-y"];
$month = $_POST["birthday-m"];
$day = $_POST["birthday-d"];

$date = $year . '-' . $month . '-' . $day;

if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($gender) || empty($date) || empty($location)) {
    echo "請填入必要欄位";
    exit;
}

// echo "$name, $email, $phone";
$now = date('Y-m-d H:i:s');
$sql = "INSERT INTO users (name, email, password,phone,location,gender,birthday, created_at)
	VALUES ('$name', '$email','$password','$phone','$location','$gender ','$date','$now')"; //資料丟不進資料庫??
// echo $sql;
// exit;

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入完成, id 為 $last_id ";
} else {
    echo "Error" . $sql . "<br>" . $conn->error;
}

$conn->close();
header("location: users.php");
// header("location: create-user.php");
//送出資料後維持再送出的畫面
