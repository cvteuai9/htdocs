<?php
require_once("../db_connect.php");

$search = isset($_GET["search"]) ? $_GET["search"] : "";
$whereClause = "WHERE 1=1";
$valid = isset($_GET["valid"]) ? $_GET["valid"] : 1;

$perPage = 6;
$sqlCategory = "SELECT * FROM activity_category";
$sqlAll = "SELECT activity.*, ac.name AS category_name, ai.path FROM activity 
JOIN activity_category ac ON activity.category_id = ac.id
JOIN activity_images ai ON activity.id = ai.id
WHERE activity.valid = $valid";

// 設定篩選條件
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// 根據篩選條件獲取總記錄數
$filter_query = "";
if ($filter === '1') {
    $filter_query = "AND activity.category_id = 1";
} elseif ($filter === '2') {
    $filter_query = "AND activity.category_id = 2";
} elseif ($filter === '3') {
    $filter_query = "AND activity.category_id = 3";
} elseif ($filter === '4') {
    $filter_query = "AND activity.category_id = 4";
} elseif ($filter === '5') {
    $filter_query = "AND activity.category_id = 5";
}
if (isset($_GET["filter"])) {
    $order = $_GET["order"];
    $page = $_GET["page"];
    $firstItem = ($page - 1) * $perPage;

    $sqlChooseCategory = "$sqlAll $filter_query";
    $resultChooseCategory = $conn->query($sqlChooseCategory);
    $categoryCount = $resultChooseCategory->num_rows;
    $pageCount = ceil($categoryCount / $perPage);
    switch ($order) {
        case 1:
            $sql = "$sqlAll $filter_query ORDER BY id ASC LIMIT $firstItem, $perPage";
            break;
        case 2:
            $sql = "$sqlAll $filter_query ORDER BY id DESC LIMIT $firstItem, $perPage";
            break;
    }
} elseif (isset($_GET["search"])) {
    $whereClause = " AND activity.name LIKE '%$search%'";
    $sql = "$sqlAll $whereClause";
    $pageCount = 1;
} else if (isset($_GET["page"]) && isset($_GET["order"]) && isset($_GET["valid"])) {
    $order = $_GET["order"];
    $page = $_GET["page"];
    $valid = $_GET["valid"];
    $firstItem = ($page - 1) * $perPage;

    $resultAll = $conn->query($sqlAll);
    $allCount = $resultAll->num_rows;

    $pageCount = ceil($allCount / $perPage);

    switch ($order) {
        case 1:
            $sql = "$sqlAll ORDER BY id ASC LIMIT $firstItem, $perPage";
            break;
        case 2:
            $sql = "$sqlAll ORDER BY id DESC LIMIT $firstItem, $perPage";
            break;
    }
} else {
    header("location: activity.php?page=1&order=1&filter=$filter");
}

$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

?>


<!doctype html>
<html lang="en">

<head>
    <title>activity</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <style>
        .content_area {
            height: 10vh;
        }
    </style>
</head>

<body>
    <!-- header、aside -->
    <?php include("../dashboard-comm.php") ?>
    <main class="main-content p-3">
        <!---------------------------------------------這裡是內容 ------------------------------------->
        <!-- 活動列表 -->
        <div class="container-fluid mb-5 " style="max-width:72vw; ">
            <div class="d-flex bd-highlight align-items-center ">
                <h1 class="me-auto p-2 bd-highlight">活動管理</h1>
                <form action="">
                    <div class="input-group">
                        <?php if (isset($_GET["search"])) : ?>
                            <div class="me-3">
                                <a class="btn btn-success" href="activity.php"><i class="fa-solid fa-arrow-left"></i></a>
                            </div>
                        <?php endif; ?>
                        <input type="text" class="form-control" placeholder="搜尋..." name="search" value="<?= $search ?>">
                        <button class="btn btn-success" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
                <div>
                    <?php if (isset($_GET["filter"])) : ?>
                        <?php $textPage = "&filter=$filter" ?>
                    <?php else : ?>
                        <?php $textPage = "" ?>
                    <?php endif; ?>
                    <div class="btn-group ms-1">
                        <a href="?page=<?= $page ?>&order=1<?= $textPage ?>" class="btn btn-primary <?php if ($order == 1) echo "active" ?>">
                            <i class="fa-solid fa-arrow-down-short-wide"></i>
                        </a>
                        <a href="?page=<?= $page ?>&order=2<?= $textPage ?>" class="btn btn-primary <?php if ($order == 2) echo "active" ?>">
                            <i class="fa-solid fa-arrow-down-wide-short"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-between">
                <div class="d-flex align-items-center justify-content-center text-nowrap gap-2">
                    <select class="form-select" aria-label="Default select example" id="categorySelect" onchange="location=this.value">
                        <option value="?page=1&order=1&filter=all" <?php if (!isset($_GET["filter"])) echo "selected" ?>>
                            所有進行中的活動
                        </option>
                        <?php foreach ($rowsCategory as $category) : ?>
                            <option <?php if (isset($_GET["filter"]) && $_GET["filter"] == $category["id"]) echo "selected" ?> value="?page=1&order=1&filter=<?= $category["id"] ?>">
                                <?= $category["name"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="align-items-center justify-content-center">
                    <a class="btn btn-primary bd-highlight" href="create-activity.php">新增活動</a>
                    <a class="btn btn-danger bd-highlight" href="activity.php?page=1&order=1&valid=0">已下架</a>
                </div>
            </div>
            <!-- 活動表格 -->
            <div class="mt-2">
                <?php foreach ($rows as $activity) : ?>
                    <div class="card mb-3 border border-dark " style="max-height:auto;">
                        <div class="row pe-5">
                            <div class="col-md-4">
                                <img src="../activity_images/<?= $activity["path"] ?>" class="img-fluid" alt="<?= $activity["path"] ?>">
                            </div>
                            <div class="col-md-8 mt-3">
                                <h3 class="card-title "><?= $activity["name"] ?></h3>
                                <div class="d-flex gap-5">
                                    <p class="card-title"><span class="text-success">開始日期 :</span> <?= $activity["time_s"] ?></p>
                                    <p class="card-title"><span class="text-success">結束日期 :</span> <?= $activity["time_e"] ?></p>
                                </div>
                                <div class="d-flex justify-content-start gap-5">
                                    <p class="card-title"><span class="text-success ">活動分類 :</span> <?= $activity["category_name"] ?></p>
                                    <p class="card-title"><span class="text-success ">地點 :</span> <?= $activity["point"] ?></p>
                                    <p class="card-title"><span class="text-success ">費用 :</span> <?= $activity["price"] ?></p>
                                    <p class="card-title"><span class="text-success ">活動編號 :</span> <?= $activity["id"] ?></p>
                                </div>
                                <!-- 內容 -->
                                <div class="mt-1">
                                    <p class="card-text overflow-hidden
                                 content_area">
                                        <?= $activity["content"] ?>
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <a class="btn btn-success btn-sm me-1" href="activity-edit.php?id=<?= $activity["id"] ?>">編輯</a>
                                    <?php if (isset($_GET["valid"])) : ?>
                                        <a href="activity-delete.php?id=<?= $activity["id"] ?>&valid=1" class="btn btn-danger btn-sm">回復上架</a>
                                    <?php else : ?>
                                        <a href="activity-delete.php?id=<?= $activity["id"] ?>&valid=0" class="btn btn-danger btn-sm">確認下架</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- 分頁 -->
            <?php if ($pageCount > 1) : ?>
                <div class="mt-5">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php if (isset($_GET["valid"])) : ?>
                                <?php $textPagination = "&valid=$valid" ?>
                            <?php elseif (isset($_GET["filter"])) : ?>
                                <?php $textPagination = "&filter=$filter" ?>
                            <?php elseif (isset($_GET["page"])) : ?>
                                <?php $textPagination = "" ?>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                <li class="page-item
                                <?php if ($i == $page) echo "active" ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&order=<?= $order ?><?= $textPagination ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            <?php else : ?>
            <?php endif; ?>
    </main>
    <?php include("../js.php") ?>
    </div>
</body>

</html>