<?php
require_once("../db_connect.php");

$search = isset($_GET["search"]) ? $_GET["search"] : "";
$whereClause = "WHERE 1=1";
$valid = isset($_GET["valid"]) ? $_GET["valid"] : 1;
// $sqlCategory="SELECT * FROM category ORDER BY id ASC";
// $resultCate=$conn->query($sqlCategory);
// $cateRows=$resultCate->fetch_all(MYSQLI_ASSOC);




$sqlAll = "SELECT activity.*, ac.name AS category_name, ai.path FROM activity 
JOIN activity_category ac ON activity.category_id = ac.id
JOIN activity_images ai ON activity.id = ai.id
WHERE activity.valid = $valid";

if (isset($_GET["search"])) {
    $whereClause = " AND activity.name LIKE '%$search%'";
    $sql = "$sqlAll $whereClause";
} else if (isset($_GET["page"]) && isset($_GET["order"])) {
    $order = $_GET["order"];
    $page = $_GET["page"];
    $perPage = 6;
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
    header("location: activity.php?page=1&order=1");
}



$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_BOTH);

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
        .activity-img {
            height: 400px;
            width: 500px;
        }

        .content_area {
            height: 50px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body>
    <!-- header、aside -->
    <?php include("../dashboard-comm.php") ?>
    <main class="main-content p-3">
        <!---------------------------------------------這裡是內容 ------------------------------------->
        <!-- 活動列表 -->
        <div class="container-fluid mb-5">
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
                <?php if (isset($_GET["page"])) : ?>
                    <div>
                        <div class="btn-group ms-1">
                            <a href="?page=<?= $page ?>&order=1" class="btn btn-primary <?php if ($order == 1) echo "active" ?>">
                                <i class="fa-solid fa-arrow-down-short-wide"></i>
                            </a>
                            <a href="?page=<?= $page ?>&order=2" class="btn btn-primary <?php if ($order == 2) echo "active" ?>">
                                <i class="fa-solid fa-arrow-down-wide-short"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
        <div class="mb-3 d-flex justify-content-between">
            <div class="d-flex align-items-center justify-content-center text-nowrap gap-2">
                <select class="form-select" aria-label="Default select example" id="categorySelect">
                    <option selected>課程類別</option>
                    <?php foreach ($rows as $category) : ?>
                        <option value=""><?= $category['category_name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <a class="btn btn-warning bd-highlight" href="activity.php">全部活動</a>
                <a class="btn btn-danger bd-highlight" href="activity.php?page=1&order=1&valid=0">已下架</a>
            </div>
            <div class="align-items-center justify-content-center">
                <a class="btn btn-primary bd-highlight" href="create-activity.php">新增活動</a>
            </div>
        </div>
        <!-- 活動表格 -->
        <?php foreach ($rows as $activity) : ?>
            <div class="card mb-3 border border-dark " style="max-height:auto;">
                <div class="row pe-5">
                    <div class="col-md-4">
                        <img src="../activity_images/<?= $activity["path"] ?>" class="activity-img object-fit-cover" alt="<?= $activity["path"] ?>">
                    </div>
                    <div class="col-md-8 mt-1 fw-bolder">
                        <h2 class="card-title text-decoration-underline"><strong><i class="fa-brands fa-cuttlefish text-warning"></i> <?= $activity["name"] ?></strong></h2>
                        <div class="card-body ps-5">
                            <div class="d-flex gap-5">
                                <p class="card-title"><span class="text-success fs-5">開始日期 :</span> <?= $activity["time_s"] ?></p>
                                <p class="card-title"><span class="text-success fs-5">結束日期 :</span> <?= $activity["time_e"] ?></p>
                            </div>
                            <div class="d-flex justify-content-start gap-5">
                                <p class="card-title"><span class="text-success fs-5">活動分類 :</span> <?= $activity["category_name"] ?></p>
                                <p class="card-title"><span class="text-success fs-5">地點 :</span> <?= $activity["point"] ?></p>
                                <p class="card-title"><span class="text-success fs-5">費用 :</span> <?= $activity["price"] ?></p>
                                <p class="card-title"><span class="text-success fs-5">活動編號 :</span> <?= $activity["id"] ?></p>
                            </div>
                            <!-- 內容 -->
                            <div class="mt-1">
                                <p class="content_area">
                                    <?= $activity["content"] ?>
                                </p>
                            </div>
                            <div class="mt-5">
                                <a class="btn btn-success btn-sm" href="activity-edit.php?id=<?= $activity["id"] ?>"><i class="fa-solid fa-pen-to-square fs-4"></i></a>
                                <a href="activity-delete.php?id=<?= $activity["id"] ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-xmark fs-4"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- 分頁 -->
        <?php if (isset($_GET["page"])) : ?>
            <div class="mt-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                            <li class="page-item
                                <?php if ($i == $page) echo "active" ?>">
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
    </main>
    <?php include("../js.php") ?>

</body>

</html>