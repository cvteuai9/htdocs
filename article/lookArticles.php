<?php
require_once("../db_connect.php");

$id = $_GET["id"];



$sql = "SELECT articles.*,articles_category.name FROM articles JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.id = $id ";

$result = $conn->query($sql);

$rows = $result->fetch_assoc();




//  var_dump($rows);
// var_dump($rows["article_images"]);
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("../css.php") ?>
    <?php include("article-css.php") ?>
    <style>
        .imgSize {
            display: block;
            margin: 0 auto;
            max-width: 800px;
            object-fit: cover;
            background-size: cover;
        }

        .content {
            margin: 0 auto;
            max-width: 800px;
            line-height: 1.8;
        }
    </style>
</head>

<body>
    <a href="Articles.php"><button class="btn btn-success"><i class="fa-solid fa-arrow-left"></i>返回</button></a>

    <div class="container">
        <div class="row-cols-1">
            <div class="col mb-2 ">
                <h1 class="fw-bold text-center">
                    <?php echo $rows["title"]; ?>
                </h1>

            </div>
            <?php if ($rows["article_images"] == "") : ?>
                <div class="col mb-2">

                </div>
            <?php else : ?>
                <div class="col mb-2 ">
                    <img class="imgSize text-center" src="../Articles_image/<?= $rows["article_images"] ?>" alt="<?= $rows["name"] ?>">
                </div>
            <?php endif; ?>
            <div class="col mb-2">
                <div class="content">
                    <?= $rows["content"]; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include("../js.php") ?>
</body>

</html>