<?php
$servername = "localhost";
$username = "admin";
$password = "12345";
$dbname = "tea";
// $port = 8080;
$dsn = "mysql:host=$servername;port=$port;dbname=$dbname";

try {
  $db_host = new PDO(
    "mysql:host={$servername};
     dbname={$dbname};
     charset=utf8",
    $username,
    $password
  );
  $db_host->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch (PDOException $e) {
  echo "資料庫連線失敗<br>";
  echo "Error: " . $e->getMessage() . "<br>";
  exit;
}
