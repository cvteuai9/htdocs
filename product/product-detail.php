<?php
require_once("../db_connect.php");
if (!isset($_GET["id"])) {
    echo "請循正常管道進入此頁";
    exit;
} else {
    $id = $_GET["id"];
}

$sql = "SELECT p.id, p.name AS product_name, p.price, p.created_at, p.description, p.weight, p.valid, tc.name AS tc_name, b.name AS brand_name, pack.name AS package_name, style.name AS style_name, p_img.path FROM product_category_relation pcr 
JOIN product_images p_img ON pcr.product_id = p_img.id
JOIN products p ON pcr.product_id = p.id 
JOIN brand b ON pcr.brand_id = b.id 
JOIN tea_category tc ON pcr.tea_id = tc.id
JOIN pack_category pack ON pcr.package_id = pack.id
JOIN style ON pcr.style_id = style.id
WHERE p.id = $id";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
    <title>商品詳情</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <style>
        .product-img {
            width: 500px;
            height: 500px;
        }
    </style>
</head>

<body>
    <!-- header aside -->
    <?php include("../dashboard-comm.php") ?>
    <main class="main-content p-3">

        <!-- 返回商品列表按鈕 -->
        <div class="container-fluid m-0">
            <div class="text-center">
                <h1>商品資訊</h1>
            </div>
            <div>
                <a class="btn btn-success fs-5 mb-3" href="product-list.php?page=1&order=1">
                    <i class="fa-solid fa-arrow-left"></i> 返回商品列表
                </a>
            </div>
        </div>
        <hr>
        <!-- 商品詳情 -->
        <div class="container">
            <div class="row g-3 justify-content-start">
                <!-- 商品圖 -->
                <div class="col-lg-6">
                    <img class="product-img object-fit-contain" src="../product_images/<?= $row["path"] ?>" alt="">
                </div>

                <!-- 商品詳細資訊 -->
                <div class="col-lg-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center h4 m-0" colspan="2">商品詳情</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle text-center">
                            <tr>
                                <th>商品編號</th>
                                <td><?= $row["id"] ?></td>
                            </tr>
                            <tr>
                                <th>商品名稱</th>
                                <td><?= $row["product_name"] ?></td>
                            </tr>
                            <tr>
                                <th>品牌</th>
                                <td><?= $row["brand_name"] ?></td>
                            </tr>
                            <tr>
                                <th>茶種</th>
                                <td><?= $row["tc_name"] ?></td>
                            </tr>
                            <tr>
                                <th>包材 / 類型</th>
                                <td><?= $row["package_name"] ?> / <?= $row["style_name"] ?></td>
                            </tr>
                            <tr>
                                <th>重量</th>
                                <td><?= $row["weight"] ?></td>
                            </tr>
                            <tr>
                                <th>單價</th>
                                <td><?= $row["price"] ?></td>
                            </tr>
                            <tr>
                                <th>狀態</th>
                                <td>
                                    <?php if ($row["valid"] == 1) : ?>
                                        上架中
                                    <?php else : ?>
                                        下架
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>建立日期</th>
                                <td><?= $row["created_at"] ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 商品編輯頁按鈕 -->
                    <a href="product-edit.php?id=<?= $row["id"] ?>" class="btn btn-success">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </div>

                <!-- 商品描述 -->
                <div class="col-lg-6">
                    <h3>商品描述</h3>
                    <p><?= $row["description"] ?></p>
                </div>
            </div>
        </div>
    </main>
    <?php include_once("../js.php") ?>
    <script>
        const pmList = document.querySelector(".pmList")
        const listWatch = document.querySelector(".listWatch")


        pmList.addEventListener("click", function() {
            listWatch.classList.toggle("deactive");
            listWatch.classList.toggle("list-active");
        })
    </script>
</body>

</html>