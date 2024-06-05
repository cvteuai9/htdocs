<?php
require_once("../db_connect.php");

if (!isset($_GET["valid"])) {
    $valid = 1;
} else {
    $valid = 0;
}
// 全部資料
$sqlAll = "SELECT p.id, p.name AS product_name, p.price, p.created_at, p.valid, tc.name AS tea_category_name, b.name AS brand_name, pack.name AS package_name, style.name AS style_name, p_img.path FROM product_category_relation pcr 
JOIN product_images p_img ON pcr.product_id = p_img.id
JOIN products p ON pcr.product_id = p.id 
JOIN brand b ON pcr.brand_id = b.id 
JOIN tea_category tc ON pcr.tea_id = tc.id
JOIN pack_category pack ON pcr.package_id = pack.id
JOIN style ON pcr.style_id = style.id
WHERE p.valid = $valid";


// 一頁顯示10筆資料
$perPage = 10;

if (isset($_GET["max"]) && isset($_GET["min"])) {
    // 價格篩選
    $max = $_GET["max"];
    $min = $_GET["min"];
    $page = $_GET["page"];
    $order = $_GET["order"];
    $firstItem = ($page - 1) * $perPage;

    $sqlPrice = "$sqlAll AND p.price >= $min AND p.price <= $max";
    $resultPrice = $conn->query($sqlPrice);
    $priceCount = $resultPrice->num_rows;

    // 依照order(排序)對應的sql語法
    switch ($order) {
        case 1:
            $sql = "$sqlAll
            AND p.price >= $min AND p.price <= $max 
            ORDER BY id ASC LIMIT $firstItem, $perPage";
            break;

        case 2:
            $sql = "$sqlAll
            AND p.price >= $min AND p.price <= $max 
            ORDER BY id DESC LIMIT $firstItem, $perPage";
            break;
    }
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $productCount = $priceCount;
    $pageCount = ceil($priceCount / $perPage);
} else if (isset($_GET["search"]) && !empty($_GET["search"])) {
    // 有搜尋條件時
    $search = $_GET["search"];
    $page = $_GET["page"];
    $order = $_GET["order"];
    $firstItem = ($page - 1) * $perPage;

    $sqlSearch = "$sqlAll
    AND (p.id LIKE '%$search%'
    OR p.name LIKE '%$search%'
    OR b.name LIKE '%$search%'
    OR tc.name LIKE '%$search%'
    OR pack.name LIKE '%$search%'
    OR style.name LIKE '%$search%')";
    $resultSearch = $conn->query($sqlSearch);
    $searchCount = $resultSearch->num_rows;

    // 依照order(排序)對應的sql語法
    switch ($order) {
        case 1:
            $sql = "$sqlSearch
            ORDER BY id ASC LIMIT $firstItem, $perPage";
            break;

        case 2:
            $sql = "$sqlSearch
            ORDER BY id DESC LIMIT $firstItem, $perPage";
            break;
    }
    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $productCount = $searchCount;
    $pageCount = ceil($productCount / $perPage);
} else if (isset($_GET["valid"])) {
    // 已下架商品
    $page = $_GET["page"];
    $order = $_GET["order"];
    $valid = $_GET["valid"];
    $firstItem = ($page - 1) * $perPage;

    // 所有符合該分類頁籤的資料筆數
    $resultValid = $conn->query($sqlAll);
    $validCount = $resultValid->num_rows;

    // 依照order(排序)對應的sql語法
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

    // 符合條件的商品總數productCount = 該分類頁籤下的商品總數categoryCount
    $productCount = $validCount;
    $pageCount = ceil($validCount / $perPage);
} else if (isset($_GET["page"]) && isset($_GET["order"]) && isset($_GET["category"])) {
    // 點擊分類頁籤時
    $page = $_GET["page"];
    $order = $_GET["order"];
    $category = $_GET["category"];
    $firstItem = ($page - 1) * $perPage;

    // 所有符合該分類頁籤的資料筆數
    $sqlCategory = "$sqlAll
    AND tc.id = $category";
    $resultCategory = $conn->query($sqlCategory);
    $categoryCount = $resultCategory->num_rows;

    // 依照order(排序)對應的sql語法
    switch ($order) {
        case 1:
            $sql = "$sqlAll
            AND tc.id = $category
            ORDER BY id ASC LIMIT $firstItem, $perPage";
            break;

        case 2:
            $sql = "$sqlAll
            AND tc.id = $category
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
    $resultAll = $conn->query($sqlAll);
    $allCount = $resultAll->num_rows;
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
    <style>
        .product-img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>
    <!-- header aside -->
    <?php include("../dashboard-comm.php") ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="text-center mt-3 pt-3">
                <h1>商品列表</h1>
            </div>
            <!-- 分類nav -->
            <ul class="nav nav-underline ps-2 fs-5">
                <li class="nav-item">
                    <a class="nav-link text-success <?php if (!isset($_GET["category"]) && !isset($_GET["valid"])) echo "active" ?>" href="product-list.php?page=1&order=1">全部</a>
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
                <li class="nav-item">
                    <a class="nav-link text-success  <?php if (isset($_GET["valid"]) && $_GET["valid"] == 0) echo "active" ?>" href="product-list.php?page=1&order=1&valid=0">已下架商品</a>
                </li>
            </ul>

            <hr class="my-3">

            <div class="row g-3 justify-content-between">
                <!-- 搜尋表單 -->
                <div class="col-auto">
                    <form id="search-form" action="">
                        <div class="d-flex justify-content-start">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="order" value="1">
                            <?php if (isset($_GET["search"])) : //有搜尋條件時才會出現重置按鈕 
                            ?>
                                <a href="product-list.php?page=1&order=1" class="btn btn-primary"><i class="fa-solid fa-arrow-rotate-left"></i></a>
                            <?php endif; ?>
                            <input id="search-input" type="text" class="form-control" placeholder="Search..." name="search">
                            <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                    <p style="font-size: 12px;" class="mt-2">請輸入商品編號、商品名稱、品牌、茶種、包裝、茶葉類型查詢</p>
                </div>
                <!-- 排序 -->
                <div class="col-auto">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <!-- 搜尋後排序 -->
                        <?php if (isset($_GET["search"])) : ?>
                            <a href="?page=<?= $page ?>&order=1&search=<?= $search ?>" class="btn btn-success <?php if ($order == 1) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a href="?page=<?= $page ?>&order=2&search=<?= $search ?>" class="btn btn-success <?php if ($order == 2) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-wide-short"></i></a>
                            <!-- 價格篩選排序 -->
                        <?php elseif (isset($_GET["max"]) && isset($_GET["min"])) : ?>
                            <a href="?page=<?= $page ?>&order=1&min=<?= $min ?>&max=<?= $max ?>" class="btn btn-success <?php if ($order == 1) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a href="?page=<?= $page ?>&order=2&min=<?= $min ?>&max=<?= $max ?>" class="btn btn-success <?php if ($order == 2) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-wide-short"></i></a>
                            <!-- 下架商品排序 -->
                        <?php elseif (isset($_GET["valid"])) : ?>
                            <a href="?page=<?= $page ?>&order=1&valid=<?= $valid ?>" class="btn btn-success <?php if ($order == 1) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a href="?page=<?= $page ?>&order=2&valid=<?= $valid ?>" class="btn btn-success <?php if ($order == 2) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-wide-short"></i></a>
                            <!-- 分類排序 -->
                        <?php elseif (isset($_GET["category"])) : ?>
                            <a href="?page=<?= $page ?>&order=1&category=<?= $category ?>" class="btn btn-success <?php if ($order == 1) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a href="?page=<?= $page ?>&order=2&category=<?= $category ?>" class="btn btn-success <?php if ($order == 2) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-wide-short"></i></a>
                            <!-- 一般排序 -->
                        <?php else : ?>
                            <a href="?page=<?= $page ?>&order=1" class="btn btn-success <?php if ($order == 1) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a href="?page=<?= $page ?>&order=2" class="btn btn-success <?php if ($order == 2) echo "active"; ?>">id <i class="fa-solid fa-arrow-down-wide-short"></i></a>
                        <?php endif; ?>
                    </div>
                    <!-- 新增商品頁按鈕 -->
                    <a href="product-add.php" class="btn btn-success"><i class="fa-regular fa-square-plus"></i> 新增商品</a>
                </div>
            </div>
        </div>

        <!-- 價格篩選 -->
        <div class="ms-3 mb-3">
            <form action="">
                <div class="row g-3 align-items-center">
                    <input type="hidden" name="page" value="1">
                    <input type="hidden" name="order" value="1">
                    <?php if (isset($_GET["min"])) : ?>
                        <div class="col-auto">
                            <a class="btn btn-success" href="product-list.php"><i class="fa-solid fa-arrow-rotate-left"></i></a>
                        </div>
                    <?php endif; ?>
                    <?php
                    $minValue = 0;
                    $maxValue = 9999;
                    if (isset($_GET["min"])) $minValue = $_GET["min"];
                    if (isset($_GET["max"])) $maxValue = $_GET["max"];
                    ?>
                    <div class="col-auto">
                        <input type="number" class="form-control text-end" value="<?= $minValue ?>" name="min" min="0">
                    </div>
                    <div class="col-auto">
                        ~
                    </div>
                    <div class="col-auto">
                        <input type="number" class="form-control text-end" value="<?= $maxValue ?>" name="max" min="0">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-filter"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-between">
                <!-- 顯示符合條件的資料筆數 -->
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
                    <!-- 如果分頁大於1，則顯示分頁nav -->
                    <?php if ($pageCount > 1) : ?>
                        <!-- 搜尋後分頁 -->
                        <?php if (isset($_GET["search"])) : ?>
                            <div class="d-flex justify-content-center">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                            <li class="page-item <?php if ($i == $page) echo "active" ?>">
                                                <a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>&search=<?= $search ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            </div>
                            <!-- 價格篩選分頁 -->
                        <?php elseif (isset($_GET["max"]) && isset($_GET["min"])) : ?>
                            <div class="d-flex justify-content-center">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                            <li class="page-item <?php if ($i == $page) echo "active" ?>">
                                                <a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>&min=<?= $min ?>&max=<?= $max ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            </div>
                            <!-- 「已下架」分類頁籤的分頁 -->
                        <?php elseif (isset($_GET["valid"])) : ?>
                            <div class="d-flex justify-content-center">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                            <li class="page-item <?php if ($i == $page) echo "active" ?>">
                                                <a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?>&valid=<?= $valid ?>">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            </div>
                            <!-- 如果選擇分類頁籤，每一個分頁按鈕外加固定category的值 -->
                        <?php elseif (isset($_GET["page"]) && isset($_GET["category"])) : ?>
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
                            <!-- 無篩選條件時的分頁 -->
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
                    <?php else : ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- 商品表格 -->
        <div class="container-fluid">
            <!-- 如果符合條件的商品>0，則顯示表格 -->
            <?php if ($result->num_rows > 0) : ?>
                <table class="table table-bordered text-center table-warning">
                    <thead class="text-nowrap">
                        <th>編號</th>
                        <th>圖片</th>
                        <th>商品名稱</th>
                        <th>品牌</th>
                        <th>茶種</th>
                        <th>包裝/茶葉類型</th>
                        <th>價格</th>
                        <th>建立時間</th>
                        <th>狀態</th>
                        <th>操作</th>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row) : ?>
                            <tr class="text-nowrap align-middle">
                                <td><?= $row["id"] ?></td>
                                <td>
                                    <img class="product-img object-fit-cover" src="../product_images/<?= $row["path"] ?>" alt="">
                                </td>
                                <td><?= $row["product_name"] ?></td>
                                <td><?= $row["brand_name"] ?></td>
                                <td><?= $row["tea_category_name"] ?></td>
                                <td><?= $row["package_name"] ?> / <?= $row["style_name"] ?></td>
                                <td><?= $row["price"] ?></td>
                                <td><?= $row["created_at"] ?></td>
                                <td><?php if ($row["valid"] == 1) : ?>
                                        上架中
                                    <?php else : ?>
                                        下架
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- 檢視商品 -->
                                    <a href="product-detail.php?id=<?= $row["id"] ?>" class="btn btn-success">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <!-- 商品編輯頁按鈕 -->
                                    <a href="product-edit.php?id=<?= $row["id"] ?>" class="btn btn-success">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    <!-- 刪除商品按鈕 -->
                                    <a href="doDelete.php?id=<?= $row["id"] ?>&valid=<?= $valid ?>" class="btn btn-danger">
                                        <?php if (isset($_GET["valid"]) && $valid == 0) : ?>
                                            <i class="fa-solid fa-plus"></i>
                                        <?php else : ?>
                                            <i class="fa-solid fa-xmark"></i>
                                        <?php endif; ?>
                                    </a>
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
    <?php include_once("../js.php") ?>
    <script>
        const searchForm = document.querySelector("#search-form")
        const searchInput = document.querySelector("search-input")

        searchForm.addEventListener("submit", function(e) {
            var input = searchInput.value.trim();
            if (input === "") {
                alert("請輸入有效的搜尋條件");
                e.preventDefault();
            }
        });
    </script>
</body>

</html>