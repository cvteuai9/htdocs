<?php
require_once("../db_connect.php");
if (!isset($_GET["id"])) {
    echo "請循正常管道進入此頁";
    exit;
} else {
    $id = $_GET["id"];
}

$sql = "SELECT p.id, p.name AS product_name, p.price, p.created_at, p.description, p.weight, tc.name AS tea_category_name, b.name AS brand_name, pack.name AS package_name, style.name AS style_name, p_img.path FROM product_category_relation pcr 
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --aside-witch: 200px;
            --header-height: 50px;
        }

        .logo {
            width: var(--aside-witch);
        }

        .aside-left {
            padding-top: var(--header-height);
            width: var(--aside-witch);
            top: 20px;
            overflow: auto;
        }

        .main-content {
            margin: var(--header-height) 0 0 var(--aside-witch);
        }

        .product-img {
            width: 500px;
            height: 500px;
        }
    </style>
</head>

<body>
    <header class="main-header bg-dark d-flex fixed-top shadow justify-content-between align-items-center">
        <a href="" class="p-3 bg-black text-white text-decoration-none">
            tea
        </a>

        <div class="text-white me-3">
            Hi,adain
            <a href="" class="btn btn-dark">登入</a>
            <a href="" class="btn btn-dark">登出</a>
        </div>
    </header>
    <aside class="aside-left position-fixed bg-white border-end vh-100 ">
        <ul class="list-unstyled">
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-house-fill me-2"></i>首頁
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-cart4 me-2"></i></i>商品
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-cash me-2"></i>優惠券
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-flag me-2"></i>課程
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-clipboard2-data me-2"></i> 訂單
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-book me-2"></i> 文章管理
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-paypal me-2"></i> 付款方式
                </a>
            </li>

        </ul>
    </aside>
    <main class="main-content p-3">

        <!-- 返回商品列表按鈕 -->
        <div class="container-fluid mb-5">
            <a class="btn btn-success fs-4 mb-3" href="product-list.php?page=1&order=1">
                <i class="fa-solid fa-arrow-left"></i> 返回商品列表
            </a>
        </div>

        <!-- 商品詳情 -->
        <div class="container">
            <div class="row g-3 justify-content-between">
                <!-- 商品圖 -->
                <div class="col-lg-6">
                    <img class="product-img object-fit-contain" src="../product_images/<?= $row["path"] ?>" alt="">
                </div>

                <!-- 商品詳細資訊 -->
                <div class="col-lg-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center h4 m-0" colspan="2">商品詳情</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center">商品編號</th>
                                <td class="text-end"><?= $row["id"] ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">商品名稱</th>
                                <td><?= $row["product_name"] ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">品牌</th>
                                <td><?= $row["brand_name"] ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">茶種</th>
                                <td><?= $row["tea_category_name"] ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">包材 / 類型</th>
                                <td><?= $row["package_name"] ?> / <?= $row["style_name"] ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">重量</th>
                                <td class="text-end"><?= $row["weight"] ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">單價</th>
                                <td class="text-end"><?= $row["price"] ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">建立日期</th>
                                <td class="text-end"><?= $row["created_at"] ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 商品編輯頁按鈕 -->
                    <a href="product-edit.php?id=<?= $row["id"] ?>" class="btn btn-success">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>

                    <!-- 移除商品按鈕 -->
                    <a href="" class="btn btn-success">
                        <i class="fa-regular fa-trash-can"></i>
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
</body>

</html>