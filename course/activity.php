<?php
require_once("../db_connect.php");

$search = isset($_GET["search"]) ? $_GET["search"] : "";
$whereClause = "WHERE 1=1";



$sql = "SELECT activity.*, ac.name AS category_name, ac.id AS category_id FROM activity_category_relation acr 
JOIN activity_category ac ON acr.category_id = ac.id
JOIN activity ON acr.activity_id = activity.id
WHERE activity.valid=1";

if (isset($_GET["search"])) {
    $whereClause = " AND  activity.name LIKE '%$search%'";
    $sql .= $whereClause;
} else if ($_GET["page"]) {
    $page = $_GET["page"];
    $perPage = 6;
    $firstItem = ($page - 1) * $perPage;
    $sql .= " ORDER BY id ASC LIMIT $firstItem, $perPage";
} else {
    header("location: activity.php?page=1");
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
</head>

<body>
    <!-- header、aside -->
    <?php include("../dashboard-comm.php") ?>
    <main class="main-content p-3">
        <!---------------------------------------------這裡是內容 ------------------------------------->
        <!-- 活動列表 -->
        <div class="container mb-5" style="max-width:72vw;">
            <div class="d-flex bd-highlight align-items-center">
                <h1 class="me-auto p-2 bd-highlight">活動管理</h1>
                <form action="" method="GET" class="me-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="搜尋..." name="search" value="<?= $search ?>">
                        <button class="btn" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="mb-3 d-flex justify-content-end">
                <form action="" mx-3>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>課程類別</option>
                        <?php foreach ($rows as $category) : ?>
                            <option value=""></option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <div class="align-items-center justify-content-center">
                    <button class="btn" type="submit">送出</button>
                    <a class="btn btn-primary  bd-highlight mx-3" href="create-actity.php">新增活動</a>
                    <a class="btn btn-secondary  bd-highlight" href="create-actity.php">已下架</a>
                </div>
            </div>
            <?php foreach ($rows as $activity) : ?>
                <div class="card mb-3 border border-dark">
                    <div class="row pe-5">
                        <div class="col-md-4">
                            <img src="" class="img-fluid rounded-start" alt="...">
                            <?= $activity["img"] ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title"><?= $activity["name"] ?></h3>
                                <div class="d-flex">
                                    <h5 class="card-title me-5">開始日期:<?= $activity["time_s"] ?></h5>
                                    <h5 class="card-title">結束日期:<?= $activity["time_e"] ?></h5>
                                </div>
                                <div class="d-flex justify-content-start ">
                                    <p class="card-title me-5">活動分類:<?= $activity["category_name"] ?></p>
                                    <p class="card-title me-5">地點:<?= $activity["point"] ?></p>
                                    <p class="card-title me-5">費用:<?= $activity["price"] ?></p>
                                    <p class="card-title me-5">活動編號:<?= $activity["id"] ?></p>
                                </div>
                                <!-- 內容 -->
                                <p class="card-text overflow-hidden test">
                                    <?= $activity["content"] ?>
                                </p>
                                <a class="btn btn-primary btn-sm" href="activity-edit.php?id=<?= $activity["id"] ?>">編輯</a>
                                <a href="activity-delete.php?id=<?= $activity["id"] ?>" class="btn btn-danger btn-sm">確認下架</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="mt-5">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                        <li class="page-item"><a class="page-link" href="?page=2">2</a></li>
                        <li class="page-item"><a class="page-link" href="?page=3">3</a></li>
                        <li class="page-item"><a class="page-link" href="?page=4">4</a></li>
                        <li class="page-item"><a class="page-link" href="?page=5">5</a></li>
                        <li class="page-item"><a class="page-link" href="?page=6">6</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </main>
    <?php include("../js.php") ?>
</body>

</html>