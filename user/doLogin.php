<?php
require_once("../db_connect.php");

session_start();

if (!isset($_POST["account"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$account = $_POST["account"];
$password = $_POST["password"];

if (empty($account)) {
    $errorMsg = "請輸入帳號";
    $_SESSION["errorMsg"] = $errorMsg;
    // echo   $errorMsg;
    header("location: sign-in.php");
    exit;
}
if (empty($password)) {
    $errorMsg = "請輸入密碼";
    $_SESSION["errorMsg"] = $errorMsg;
    // echo   $errorMsg;
    header("location: sign-in.php");
    exit;
}

// $password = md5($password);
// echo "$account, $password";

$sql = "SELECT * FROM users WHERE account= '$account' AND password = '$password' AND valid=1";
$result = $conn->query($sql);
$userCount = $result->num_rows;

if ($userCount == 0) {
    $errorMsg = "帳號或密碼錯誤";
    if (!isset($_SESSION["errorTimes"])) {
        $_SESSION["errorTimes"] = 1;
    } else {
        $_SESSION["errorTimes"]++;
    }

    $_SESSION["errorMsg"] = $errorMsg;
    header(("location: sign-in.php"));
    exit;
}

$row = $result->fetch_assoc();
unset($_SESSION["errorMsg"]);
unset($_SESSION["errorTimes"]);
// var_dump(($row));


$_SESSION["user"] = [
    "id" => $row["id"],
    "account" => $row["account"],
    "name" => $row["name"],
    "email" => $row["email"],
    "phone" => $row["phone"]

];


header("location: user.php?id=" . $row["id"]);
