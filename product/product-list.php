<?php
require_once("../db_connect.php");

$sql = "SELECT p.id, p.name AS product_name, p.price, p.created_at, tc.name AS tea_category_name, b.name AS brand_name, pack.name AS package_name, style.name AS style_name FROM product_category_relation pcr
JOIN products p ON pcr.product_id = p.id
JOIN brand b ON pcr.brand_id = b.id
JOIN tea_category tc ON pcr.tea_id = tc.id
JOIN pack_category pack ON pcr.package_id = pack.id
JOIN style ON pcr.style_id = style.id";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <title>商品列表</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        a {
            text-decoration: none;
        }

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
            top: 50px;
            overflow: auto;
        }

        .main-content {
            margin: var(--header-height) 0 0 var(--aside-witch);
        }
    </style>
</head>

<body>
    <header class="main-header bg-dark d-flex fixed-top shadow justify-content-between align-items-center">
        <a href="" class="p-3 bg-black text-white text-decoration-none">
            tea
        </a>

        <div class="text-white me-3">
            Hi,admin
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
    <div class="main-content ">
        <!-- header -->
        <div class="container">
            <h1 class="m-0 pt-3">商品列表</h1>
            <!-- nav -->
            <ul class="nav nav-underline ps-2">
                <li class="nav-item">
                    <a class="nav-link" href="">全部</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">紅茶</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">綠茶</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">青茶(烏龍茶)</a>
                </li>
            </ul>
            <hr class="my-1">
            <div class="row g-3 justify-content-between">
                <div class="col-auto">
                    <form action="">
                        <div class="d-flex justify-content-start">
                            <input type="text" class="form-control">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-primary">Left</button>
                        <button type="button" class="btn btn-primary">Middle</button>
                    </div>
                    <a href="" class="btn btn-primary"><i class="fa-regular fa-square-plus"></i> 新增商品</a>
                </div>
            </div>
        </div>
        <div class="container py-3">
            <div class="py-2 d-flex gap-3">
                <div>
                    共 3 筆
                </div>
                <div>
                    第三頁/共四頁
                </div>
            </div>
        </div>
        <div class="container">
            <table class="table table-bordered text-center">
                <thead class="bg-warning-subtle">
                    <th>編號</th>
                    <th>圖片</th>
                    <th>商品名稱</th>
                    <th>品牌</th>
                    <th>茶種</th>
                    <th>包裝/茶葉類型</th>
                    <th>價格</th>
                    <th>建立時間</th>
                    <th>操作</th>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <td><?= $row["id"] ?></td>
                            <td>1</td>
                            <td><?= $row["product_name"] ?></td>
                            <td><?= $row["brand_name"] ?></td>
                            <td><?= $row["tea_category_name"] ?></td>
                            <td><?= $row["package_name"] ?> / <?= $row["style_name"] ?></td>
                            <td><?= $row["price"] ?></td>
                            <td><?= $row["created_at"] ?></td>
                            <td>
                                <a href="" class="btn btn-primary">檢視</a>
                                <a href="" class="btn btn-primary">修改</a>
                                <a href="" class="btn btn-primary">刪除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>



    </div>

</body>

</html>