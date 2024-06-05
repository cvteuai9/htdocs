<?php
// 使用者列表
require_once("../db_connect.php"); //登入資料庫
$sqlAll = "SELECT* FROM users WHERE valid = 1";
$resultAll = $conn->query($sqlAll);
$allUserCount = $resultAll->num_rows;

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM users WHERE account LIKE '%$search%' AND valid = 1";
    //連結在WHERE後面的條件，可用AND增加
    $pageTitle = "$search 的搜尋結果";
} else if (isset($_GET["page"]) && isset($_GET["order"])) {
    // 搭配LIMIT
    $page = $_GET["page"];
    $perPage = 10;
    $firstItem = ($page - 1) * $perPage;
    $pageCount = ceil($allUserCount / $perPage);
    $order = $_GET["order"];

    switch ($order) {
        case 1:   //id ASC
            $orderClause = "ORDER BY id ASC";
            break;
        case 2:  //id DESC
            $orderClause = "ORDER BY id DESC";
            break;
        case 3:  //name ASC
            $orderClause = "ORDER BY name ASC";
            break;
        case 4:  //name DESC
            $orderClause = "ORDER BY name DESC";
            break;
    }

    $sql = "SELECT * FROM users WHERE valid=1 $orderClause LIMIT $firstItem, $perPage";

    // 選擇排序功能

} else {
    $sql = "SELECT id, name, email, phone FROM users WHERE valid = 1";
    $pageTitle = "使用者列表";
    header("location: users.php?page=1&order=1");
}




$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC); //將資料轉出來
$userCount = $result->num_rows; //讀取資料庫資料
if (isset($_GET["page"])) {
    $userCount = $allUserCount;
    $page = $page;
}
?>
<!---------------------------------------------這裡是內容 ------------------------------------->
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <!-- header、aside -->
    <?php include("../dashboard-comm.php") ?>
    <main class="main-content p-3">
        <div class="d-flex justify-content-between">
            <h1>會員管理</h1>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>
        </div>
        <hr>
        <!---------------------------------------------這裡是內容 ------------------------------------->
        <div class="container">

            <div class="py-2 mb-3">
                <!-- mb-3跟下方空間間距 -->

                <div>
                    <?php
                    if (isset($_GET["search"])) : ?>
                        <a class="btn btn-dark" href="users.php">
                            <i class="fa-solid fa-backward-step"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="d-flex ">
                    <form action="" class="me-3 flex-grow-1">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." name="search">
                            <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>

                        </div>
                    </form>

                    <a class="btn btn-dark" href="create-user.php">
                        <i class="fa-solid fa-user-plus"></i>
                    </a>

                </div>


            </div>




            <!-- 顯示搜尋結果人數 -->
            <div class="pb-2 d-flex justify-content-between">
                <div>
                    會員人數：共<?= $userCount ?>人

                </div>
                <?php if (isset($_GET["page"])) : ?>
                    <div>
                        排序：<div class="btn-group">
                            <a href="?page=<?= $page ?>&order=1
" class="btn btn-dark <?php
                        if ($order == 1) echo "active";  ?>">ID<i class="fa-solid fa-arrow-down-short-wide"></i></a>

                            <a href="?page=<?= $page ?>&order=2" class="btn btn-dark <?php
                                                                                        if ($order == 2) echo "active";  ?>">ID<i class="fa-solid fa-arrow-down-wide-short "></i></a>

                            <a href="?page=<?= $page ?>&order=3" class="btn btn-dark <?php
                                                                                        if ($order == 3) echo "active";  ?>">Name<i class="fa-solid fa-arrow-down-wide-short "></i></a>

                            <a href="?page=<?= $page ?>&order=4" class="btn btn-dark <?php
                                                                                        if ($order == 4) echo "active";  ?>">Name<i class="fa-solid fa-arrow-down-wide-short "></i></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!-- =====使用者體驗=== -->
            <?php if ($result->num_rows > 0) : ?>
                <!-- ================== -->
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>電話</th>
                            <th>Email</th>
                            <th>性別</th>
                            <th>城市</th>
                            <th>資料建立日期</th>
                            <th>帳戶狀態</th>
                            <th>資訊</th>
                        </tr>
                        <!-- <th>id</th>
                            <th>name</th>
                            <th>phone</th>
                            <th>email</th>
                            <th>gender</th>
                            <th>location</th>
                            <th>created_at</th>
                            <th>valid</th> -->
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $user) : ?>
                            <!-- 跑資料庫迴圈 -->
                            <tr class="align-middle">
                                <td class="text-center"><?= $user["id"] ?></td>
                                <td class=""><?= $user["name"] ?></td>
                                <td><?= $user["phone"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td class="text-center"><?= $user["gender"] ?></td>
                                <td class="text-center"><?= $user["location"] ?></td>
                                <td class="text-center"><?= $user["created_at"] ?></td>

                                <td class="text-center"><?php if ($user["valid"] == 1) {
                                                            echo "有效";
                                                        } else echo "停權" ?></td>
                                <td class="text-center">
                                    <a class="btn btn-dark" href="user.php?id=<?= $user["id"] ?>">詳細</a>
                                    <!-- 快速到商品內文 -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (isset($_GET["page"])) : ?>
                    <!-- 判斷分頁 -->
                    <nav aria-label="...">
                        <ul class="pagination pagination-sm ">
                            <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                <li class="page-item 
                 <?php if ($i == $page) echo "active" ?>"><a class="page-link " href="?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
                <!-- =====使用者體驗=== -->
            <?php else : ?>
                沒有使用者
            <?php endif; ?>
            <!-- ================== -->
        </div>












    </main>
    <?php include("../js.php") ?>
</body>

</html>