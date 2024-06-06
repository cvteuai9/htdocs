<?php
require_once("../db_connect.php");

$id = $_GET["id"];
//var_dump($id);
$sql = "SELECT activity.*, ac.name AS category_name, ai.path FROM activity 
JOIN activity_category ac ON activity.category_id = ac.id
JOIN activity_images ai ON activity.id = ai.id
WHERE activity.valid=1 AND activity.id = $id ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

//這邊設定valid=1 可以方便去後台設定為0變成一種軟刪除。不用直接刪除
//echo $sql;
//用於測試的狀態
// 這是類別
$sqlAc = "SELECT * FROM activity_category";
$resultAc = $conn->query($sqlAc);
$rowAc = $resultAc->fetch_all(MYSQLI_ASSOC);


//var_dump($row);

if ($result->num_rows > 0) {
    $userExit = true;
    //這邊用於確定有沒有id 有的話就會跑true 沒有的話就會跑false
} else {
    $userExit = false;
    $title = "使用者不存在";
}


// $image = $_FILES["img"];
// // 上傳圖片至目標資料夾
// if ($_FILES["img"]["error"] == 0) {
//     // move_uploaded_file({上傳文件在服務器上的臨時文件名稱}, {你希望文件移動到的位置(包含文件名稱)})
//     if (move_uploaded_file($_FILES["img"]["activity_images"], "../test/activity_imgages" . $_FILES["img"]["activity_images"])) {
//         echo "upload success";
//     } else {
//         echo "upload FAIL";
//     }
// }

// //寫入products_images資料表
// $filename = $_FILES["img"]["name"];



?>


<!doctype html>
<html lang="en">

<head>
    <title>活動編輯頁</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <style>
        .test {
            height: 60px;
        }

        #preview {
            width: 400px;
            height: 400px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #preview img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <!-- header、aside -->
    <?php include("../dashboard-comm.php") ?>
    <main class="main-content p-3">
        <!---------------------------------------------這裡是內容 ------------------------------------->
        <!-- 修改活動 -------------------------------------->
        <div class="container-fluid mt-3" style="max-width:72vw;">
            <a class="btn btn-primary " href="activity.php"><i class="fa-solid fa-arrow-left"></i> 回活動列表</a>
            <h1 class="mb-4 mt-4">修改活動</h1>
            <div class="card">
                <div class="card-body">
                    <?php if ($userExit) : ?>
                        <form action="doUpdateActivity.php" method="post" id="editEventForm" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <div class="mb-3">
                                <label for="editEventName" class="form-label">活動名稱</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $row["name"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="eventName" class="form-label">類別</label>
                                <select class="form-select" aria-label="Default select example" name="category">
                                    <?php foreach ($rowAc as $rows) : ?>
                                        <option value="<?= $rows["id"] ?>" <?php if ($rows["id"] == $row["category_id"]) echo "selected" ?>><?= $rows["name"] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editEventDate" class="form-label">開始日期</label>
                                <input type="date" class="form-control" id="time_s" name="time_s" value="<?= $row["time_s"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="editEventDate" class="form-label">結束日期</label>
                                <input type="date" class="form-control" id="time_e" name="time_e" value="<?= $row["time_e"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="editEventLocation" class="form-label">地點</label>
                                <input type="text" class="form-control" id="point" name="point" value="<?= $row["point"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="editEventContent" class="form-label">內容</label>
                                <textarea class="form-control" id="content" name="content"><?= $row["content"] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editEventLocation" class="form-label">價格</label>
                                <input type="text" class="form-control" id="price" name="price" value="<?= $row["price"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="editEventPhoto" class="form-label">照片</label>
                                <input type="file" class="form-control" id="img" name="img" onchange="previewImage(event)">

                                <div id="preview" class="mt-2">
                                    <img id="editEventPhotoPreview" src="../activity_images/<?= $row["path"] ?>" alt="活動照片" class="mt-3">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">保存修改</button>
                        </form>
                        <a href="index.html" class="btn btn-secondary">返回</a>
                    <?php else : ?>
                        <h1>使用者不存在</h1>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <?php include("../js.php") ?>
    <script>
        // 圖片預覽函式
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const img = document.createElement('img');
                img.src = reader.result;
                preview.innerHTML = '';
                preview.appendChild(img);
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>