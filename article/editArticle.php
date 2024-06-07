<?php
require_once("../db_connect.php");

$id = $_GET["id"];



$sql = "SELECT articles_category.id AS category_id,articles_category.name,articles_category.created_at,articles_category.updated_at FROM articles_category  ";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

$sqlOne = "SELECT articles.* FROM articles WHERE articles.id = $id ";
$resultOne = $conn->query($sqlOne);
$rowsOne = $resultOne->fetch_assoc();
// var_dump($rowsOne);






?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php include("../css.php"); ?>
    <?php include("article-css.php"); ?>
    <style>
        form {

            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .lookimg img {
            height: 210px;
        }

        .lookImg {
            width: 200px;
            height: 200px;

            /* background-color: black; */
        }

        .lookImg img {
            max-width: 200px;
            height: 200px;
            object-fit: cover;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="modal fade" id="deleteModal<?= $rowsOne["id"] ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">再次確認</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        確認刪除文章?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="deleteArticle.php?id=<?= $rowsOne["id"] ?>" type="button" class="btn btn-primary">確認</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="Articles.php"><button class="btn btn-success mb-2"><i class="bi bi-arrow-bar-left"></i>返回</button></a>
            <a class="d-inline-block me-1"><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $rowsOne["id"] ?>"><i class="bi bi-trash3-fill"></i></button></a>
        </div>
        <form action="doeditArticle.php" class=" form-control mb-3" method="post" enctype="multipart/form-data">

            <input type="hidden" class="form-control" value="<?= $rowsOne["id"] ?>" name="id">
            <label class="form-label " for="title">文章標題:</label>
            <input type="text" class=" form-control " name="title" id="title" value="<?= $rowsOne["title"] ?>">
            <label for="choose" class="form-label">文章種類</label>
            <select name="choose" id="choose" class="form-select">
                <?php foreach ($rows as $row) : ?>
                    <option value="<?= $row["category_id"] ?>" <?= $row["category_id"] == $rowsOne["category_id"] ? "selected" : "" ?>><?= $row["name"]; ?></option>
                <?php endforeach; ?>
            </select>

            <div class="h4 mt-3 ">
                文章圖片預覽
            </div>
            <div class="lookImg mb-3">
                <img src="../Articles_image/<?= $rowsOne["article_images"] ?>" alt="">
            </div>
            <label for="imgUrl" class="form-label">載入圖檔</label>
            <input type="file" class="form-control" accept="image/*" onchange="previewImage(event)" name="imgUrl" id="imgUrl">
            <label class="form-label " for="content">文章內容:</label>
            <textarea name="content" id="content" class="form-control" rows="8"><?= $rowsOne["content"] ?></textarea>
            <button type="submit" class="btn btn-success">送出</button>

        </form>


    </div>


    <?php include("../js.php"); ?>
    <script>
        function previewImage(event) {
            const lookImg = document.querySelector('.lookImg');
            const file = event.target.files[0];
            const fileInput = document.querySelector('#imgUrl');
            const filename = event.target.files[0].name;

            // console.log(file);
            const reader = new FileReader();
            console.log(reader);

            reader.onload = function(e) {
                const img = document.createElement('img');


                img.src = reader.result;
                lookImg.innerHTML = '';
                lookImg.appendChild(img);
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>