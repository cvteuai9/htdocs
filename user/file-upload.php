<!-- 檔案上傳 -->

<?php
require_once("../db_connect.php");
$sql = "SELECT *FROM images ORDER BY id DESC";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

?>


<!doctype html>
<html lang="en">

<head>
    <title>file-upload</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <!-- ===左側上傳區=== -->
            <div class="col-lg-6">
                <form action="doUpload.php" method="post" enctype="multipart/form-data">
                    <!-- 若要上傳檔案enctype="multipart/form-data必選 -->

                    <div class="mb-2">
                        <label for="" class="form-label">名稱</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="mb-2">
                        <label for="" class="form-label">選擇檔案</label>
                        <input type="file" class="form-control display-none" name="file">

                    </div>
                    <input type="file" accept=".jpg,.png,.gif" hidden="">
                    <button class="btn btn-primary" type="submit">送出</button>

                </form>
            </div>
            <!-- ===右側圖片區=== -->
            <div class="col-lg-6">
                <div class="row g-3">
                    <?php foreach ($rows as $image) : ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="ratio ratio-1x1">
                                <img class="object-fit-cover" src="/upload/<?= $image["pic_name"] ?>">
                            </div>
                            <h4 class=""><?= $image["pic_name"] ?></h4>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>