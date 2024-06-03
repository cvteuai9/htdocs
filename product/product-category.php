<?php
require_once("../db_connect.php");

$sqlTc = "SELECT * FROM tea_category";
$sqlPc = "SELECT * FROM pack_category";
$sqlStyle = "SELECT * FROM style";
$sqlBrand = "SELECT * FROM brand";

$resultTc = $conn->query($sqlTc);
$resultPc = $conn->query($sqlPc);
$resultStyle = $conn->query($sqlStyle);
$resultBrand = $conn->query($sqlBrand);

$rowTc = $resultTc->fetch_all(MYSQLI_ASSOC);
$rowPc = $resultPc->fetch_all(MYSQLI_ASSOC);
$rowStyle = $resultStyle->fetch_all(MYSQLI_ASSOC);
$rowBrand = $resultBrand->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <title>商品分類列表</title>
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
                    <i class="bi bi-cart4 me-2"></i></i>商品管理
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
    <div class="main-content">
        <div class="container-fluid text-center pt-3">
            <h1>分類列表</h1>
        </div>
        <hr>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    <table class="table table-bordered text-center">
                        <thead>
                            <th>茶種</th>
                        </thead>
                        <tbody>
                            <?php foreach ($rowTc as $row) : ?>
                                <tr>
                                    <td><?= $row["name"] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-2">
                    <table class="table table-bordered text-center">
                        <thead>
                            <th>品牌</th>
                        </thead>
                        <?php foreach ($rowBrand as $row) : ?>
                            <tbody>
                                <tr>
                                    <td><?= $row["name"] ?></td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="col-lg-2">
                    <table class="table table-bordered text-center">
                        <thead>
                            <th>包裝方式</th>
                        </thead>
                        <tbody>
                            <?php foreach ($rowPc as $row) : ?>
                                <tr>
                                    <td><?= $row["name"] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-2">
                    <table class="table table-bordered text-center">
                        <thead>
                            <th>種類</th>
                        </thead>
                        <tbody>
                            <?php foreach ($rowStyle as $row) : ?>
                                <tr>
                                    <td><?= $row["name"] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>