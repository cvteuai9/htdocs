<?php
require_once("../db_connect.php");
$id = $_GET["id"];
$sql="UPDATE articles SET valid = 1 WHERE articles.id ='$id'";
$result = $conn->query($sql);





header("location: Articles.php");
?>