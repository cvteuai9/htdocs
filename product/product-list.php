<?php
require_once("../db_connect.php");

// 全部資料
$sqlAll = "SELECT p.id, p.name AS product_name, p.price, p.created_at, tc.name AS tea_category_name, b.name AS brand_name, pack.name AS package_name, style.name AS style_name, p_img.path FROM product_category_relation pcr 
JOIN product_images p_img ON pcr.product_id = p_img.id
JOIN products p ON pcr.product_id = p.id 
JOIN brand b ON pcr.brand_id = b.id 
JOIN tea_category tc ON pcr.tea_id = tc.id
JOIN pack_category pack ON pcr.package_id = pack.id
JOIN style ON pcr.style_id = style.id";
$resultAll = $conn->query($sqlAll);
$allCount = $resultAll->num_rows;

// 一頁顯示10筆資料
$perPage = 10;

if (isset($_GET["search"]) && !empty($_GET["search"])) {
    // 有搜尋條件時
    $search = $_GET["search"];
    $sql = "$sqlAll
    WHERE p.id LIKE '%$search%'
    OR p.name LIKE '%$search%'
    OR b.name LIKE '%$search%'
    OR tc.name LIKE '%$search%'
    OR pack.name LIKE '%$search%'
    OR style.name LIKE '%$search%'
    ORDER BY id ASC";
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $productCount = $result->num_rows;
} else if (isset($_GET["page"]) && isset($_GET["order"]) && isset($_GET["category"])) {
    // 點擊分類頁籤時

    $page = $_GET["page"];
    $order = $_GET["order"];
    $category = $_GET["category"];
    $firstItem = ($page - 1) * $perPage;

    // 所有符合該分類頁籤的資料筆數
    $sqlCategory = "$sqlAll
    WHERE tc.id = $category";
    $resultCategory = $conn->query($sqlCategory);
    $categoryCount = $resultCategory->num_rows;

    // 依照order(排序)對應的sql語法
    switch ($order) {
        case 1:
            $sql = "$sqlAll
            WHERE tc.id = $category
            ORDER BY id ASC LIMIT $firstItem, $perPage";
            break;

        case 2:
            $sql = "$sqlAll
            WHERE tc.id = $category
            ORDER BY id DESC LIMIT $firstItem, $perPage";
            break;
    }
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // 符合條件的商品總數productCount = 該分類頁籤下的商品總數categoryCount
    $productCount = $categoryCount;
    $pageCount = ceil($productCount / $perPage);
} else if (isset($_GET["page"]) && isset($_GET["order"])) {
    // 商品列表首頁

    $page = $_GET["page"];
    $order = $_GET["order"];
    $firstItem = ($page - 1) * $perPage;

    switch ($order) {
        case 1:
            $sql = "$sqlAll
            ORDER BY id ASC LIMIT $firstItem, $perPage";
            break;

        case 2:
            $sql = "$sqlAll
            ORDER BY id DESC LIMIT $firstItem, $perPage";
            break;
    }
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $productCount = $allCount;
    $pageCount = ceil($productCount / $perPage);
} else {
    header("location:product-list.php?page=1&order=1");
}



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

        .product-img {
            width: 100px;
            height: 100px;
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
        <div class="container-fluid">
            <h1 class="m-0 pt-3">商品列表</h1>
            <!-- 分類nav -->
            <ul class="nav nav-underline ps-2">
                <li class="nav-item">
                    <a class="nav-link text-success <?php if (!isset($_GET["category"])) echo "active" ?>" href="product-list.php?page=1&order=1">全部</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success <?php if (isset($_GET["category"]) && $_GET["category"] == 1) echo "active" ?>" href="product-list.php?page=1&order=1&category=1">紅茶</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success  <?php if (isset($_GET["category"]) && $_GET["category"] == 2) echo "active" ?>" href="product-list.php?page=1&order=1&category=2">綠茶</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-success  <?php if (isset($_GET["category"]) && $_GET["category"] == 3) echo "active" ?>" href="product-list.php?page=1&order=1&category=3">青茶(烏龍茶)</a>
                </li>
            </ul>
            <hr class="my-3">
            <div class="row g-3 justify-content-between">
                <div class="col-auto">
                    <!-- 搜尋表單 -->
                    <form action="">
                        <div class="d-flex justify-content-start">
                            <?php if (isset($_GET["search"])) : //有搜尋條件時才會出現重置按鈕 
                            ?>
                                <a href="product-list.php?page=1&order=1" class="btn btn-primary"><i class="fa-solid fa-arrow-rotate-left"></i></a>
                            <?php endif; ?>
                            <input type="text" class="form-control" placeholder="Search..." name="search">
                            <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                    <p style="font-size: 12px;" class="mt-2">請輸入商品編號、商品名稱、品牌、茶種、包裝、茶葉類型查詢</p>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <?php if (isset($_GET["category"])) : ?>
                            <a href="?page=<?= $page ?>&order=1&category=<?= $category ?>" class="btn btn-success <?php if ($order == 1) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a href="?page=<?= $page ?>&order=2&category=<?= $category ?>" class="btn btn-success <?php if ($order == 2) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-wide-short"></i></a>
                        <?php else : ?>
                            <a href="?page=<?= $page ?>&order=1" class="btn btn-success <?php if ($order == 1) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a href="?page=<?= $page ?>&order=2" class="btn btn-success <?php if ($order == 2) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-wide-short"></i></a>
                        <?php endif; ?>
                    </div>
                    <a href="" class="btn btn-success"><i class="fa-regular fa-square-plus"></i> 新增商品</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="col-auto py-2 d-flex gap-3">
                    <div>
                        共 <?= $productCount ?> 筆
                    </div>
                    <div>
                        <?php if (isset($_GET["page"])) : ?>
                            第 <?= $_GET["page"] ?> 頁 / 共 <?= $pageCount ?> 頁
                        <?php else : ?>
                            第 1 頁 / 共 1 頁
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-auto">
                    <!-- 如果選擇分類頁籤，每一個分頁按鈕外加固定category的值 -->
                    <?php if (isset($_GET["page"]) && isset($_GET["category"])) : ?>
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                        <li class="page-item <?php if ($i == $page) echo "active" ?>">
                                            <a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>&category=<?= $category ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php elseif (isset($_GET["page"])) : ?>
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                        <li class="page-item <?php if ($i == $page) echo "active" ?>">
                                            <a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        </div>

                    <?php endif; ?>
                </div>
            </div>

        </div>
        <div class="container-fluid">
            <!-- 商品表格 -->
            <?php if ($result->num_rows > 0) : ?>
                <table class="table table-bordered text-center">
                    <thead class="bg-warning-subtle text-nowrap">
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
                            <tr class="text-nowrap">
                                <td><?= $row["id"] ?></td>
                                <td>
                                    <img class="product-img object-fit-cover" src="<?= $row["path"] ?>" alt="">
                                </td>
                                <td><?= $row["product_name"] ?></td>
                                <td><?= $row["brand_name"] ?></td>
                                <td><?= $row["tea_category_name"] ?></td>
                                <td><?= $row["package_name"] ?> / <?= $row["style_name"] ?></td>
                                <td><?= $row["price"] ?></td>
                                <td><?= $row["created_at"] ?></td>
                                <td>
                                    <a href="" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                                    <a href="" class="btn btn-success"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="" class="btn btn-success"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else : ?>
                無符合條件的商品
            <?php endif; ?>
        </div>
    </div>

</body>

</html>