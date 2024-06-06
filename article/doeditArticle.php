<?php
require_once("../db_connect.php");

if(!isset($_POST["title"])){
    echo "請循正常管道進入此頁";
    exit;
}


$id=$_POST["id"];
$title=$_POST["title"];
$choose=$_POST["choose"];
// $optionId=$_POST["optionId"];
$imgUrl=$_POST["imgUrl"];
$content=$_POST["content"];

$now =date('Y-m-d H:i:s');

$sql="UPDATE articles SET category_id='$choose', article_images='$imgUrl', title='$title', content='$content', updated_at='$now' WHERE articles.id ='$id'";

var_dump($choose);

if($conn->query($sql)===TRUE){
    echo "新增成功";

}else{
    echo "新增失敗:" . $conn->error;
}

header("location: Articles.php");

?>

