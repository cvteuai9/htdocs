<?php
if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁面";
    exit;
}


$name = $_POST["name"];
// echo $name."<br>";
$password = $_POST["password"];
// echo $password."<br>";
$email = $_POST["email"];
// echo $email."<br>";
$phones = array_filter($_POST["phones"]);
// array_filter過濾空字串
// var_dump($phones);
$phonesList = implode(",", $phones); //09XXXXX,0922222
// 陣列轉換成字串implode
$gender = $_POST["gender"];
$telecom = $_POST["telecom"];

// echo "<br>";
echo "$telecom, $name's email is $email, phone are $phonesList, gender is $gender.";
?>

<!-- JS join陣列轉換成字串 -->