<?php
require_once("../db_connect.php");
$sql = "SELECT articles_category.id AS category_id,articles_category.name,articles_category.created_at,articles_category.updated_at FROM articles_category  ";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);







?>

<!doctype html>
<html lang="en">

<head>
    <title>新增文章</title>
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

        input[type="text"] {
            max-width: 50%;


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

        <a href="Articles.php"><button class="btn btn-success"><i class="bi bi-arrow-bar-left"></i>返回</button></a>
        <form action="doaddArticleUI.php" class=" form-control" method="post" enctype="multipart/form-data">
            <label class="form-label " for="title">文章標題:</label>
            <input type="text" class=" form-control " name="title" id="title">
            <label for="choose" class="form-label">文章種類</label>
            <select name="choose" id="choose" class="form-select">
                <?php foreach ($rows as $row) : ?>
                    <option value="<?= $row["category_id"] ?>"><?= $row["name"]; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="h4 mt-3 ">
                文章圖片預覽
            </div>
            <div class="lookImg mb-3">
                <img src="../Articles_image/" alt="">
            </div>
            <label for="imgUrl" class="form-label">載入圖檔</label>
            <input type="file" class="form-control" accept="image/*" onchange="previewImage(event)" name="imgUrl" id="imgUrl">
            <label class="form-label " for="content">文章內容:</label>
            <textarea name="content" id="content" class="form-control" rows="8"></textarea>
            <button type="submit" class="btn btn-success">送出</button>

        </form>

    </div>


    <?php include("../js.php"); ?>
    <script>
        function previewImage(event) {
            const lookImg = document.querySelector('.lookImg');
            const file = event.target.files[0];
            // console.log(file);
            const reader = new FileReader();
            console.log(reader);

            reader.onload = function() {
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