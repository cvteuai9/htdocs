<?php
require_once("../db_connect.php");
if (isset($_GET["valid"])) {
    $sqlTc = "SELECT * FROM tea_category WHERE valid=0";
    $sqlPc = "SELECT * FROM pack_category WHERE valid=0";
    $sqlStyle = "SELECT * FROM style WHERE valid=0";
    $sqlBrand = "SELECT * FROM brand WHERE valid=0";

    $resultTc = $conn->query($sqlTc);
    $resultPc = $conn->query($sqlPc);
    $resultStyle = $conn->query($sqlStyle);
    $resultBrand = $conn->query($sqlBrand);

    $rowTc = $resultTc->fetch_all(MYSQLI_ASSOC);
    $rowPc = $resultPc->fetch_all(MYSQLI_ASSOC);
    $rowStyle = $resultStyle->fetch_all(MYSQLI_ASSOC);
    $rowBrand = $resultBrand->fetch_all(MYSQLI_ASSOC);
} else {
    $sqlTc = "SELECT * FROM tea_category WHERE valid=1";
    $sqlPc = "SELECT * FROM pack_category WHERE valid=1";
    $sqlStyle = "SELECT * FROM style WHERE valid=1";
    $sqlBrand = "SELECT * FROM brand WHERE valid=1";

    $resultTc = $conn->query($sqlTc);
    $resultPc = $conn->query($sqlPc);
    $resultStyle = $conn->query($sqlStyle);
    $resultBrand = $conn->query($sqlBrand);

    $rowTc = $resultTc->fetch_all(MYSQLI_ASSOC);
    $rowPc = $resultPc->fetch_all(MYSQLI_ASSOC);
    $rowStyle = $resultStyle->fetch_all(MYSQLI_ASSOC);
    $rowBrand = $resultBrand->fetch_all(MYSQLI_ASSOC);
}
$tcCount = $resultTc->num_rows;
$pcCount = $resultPc->num_rows;
$styleCount = $resultStyle->num_rows;
$brandCount = $resultBrand->num_rows;
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
        <!-- Title -->
        <div class="container-fluid text-center pt-3">
            <h1>商品分類列表</h1>
        </div>
        <hr>

        <div class="container-fluid">
            <div class="d-flex gap-3">
                <a href="product-category.php" class="btn btn-primary <?php if (!isset($_GET["valid"])) echo "active" ?>">使用中</a>
                <a href="product-category.php?valid=0" class="btn btn-primary <?php if (isset($_GET["valid"])) echo "active" ?>">已下架分類</a>
            </div>
            <hr>
            <div class="d-flex gap-3">
                <a href="category-add.php?category=1" class="btn btn-success mb-1"><i class="fa-solid fa-plus"></i> 新增茶種</a>
                <a href="category-add.php?category=2" class="btn btn-success mb-1"><i class="fa-solid fa-plus"></i> 新增品牌</a>
                <a href="category-add.php?category=3" class="btn btn-success mb-1"><i class="fa-solid fa-plus"></i> 新增包裝方式</a>
                <a href="category-add.php?category=4" class="btn btn-success mb-1"><i class="fa-solid fa-plus"></i> 新增茶葉類型</a>
            </div>
            <hr>
            <?php if ($tcCount || $pcCount || $brandCount || $styleCount) : ?>
                <div class="row justify-content-around text-nowrap">
                    <?php if ($tcCount > 0) : ?>
                        <div class="col-auto">
                            <table class="table table-bordered text-center align-middle">
                                <thead>
                                    <th>編號</th>
                                    <th>茶種</th>
                                    <th>狀態</th>
                                    <th>操作</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($rowTc as $row) : ?>
                                        <tr>
                                            <td><?= $row["id"] ?></td>
                                            <td><?= $row["name"] ?></td>
                                            <td><?php if ($row["valid"] == 1) : ?>
                                                    使用中
                                                <?php else : ?>
                                                    已停用
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-success" href="editCategory.php?id=<?= $row["id"] ?>&category=1"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="doDeleteCategory.php?id=<?= $row["id"] ?>&valid=<?= $row["valid"] ?>&category=1" class="btn btn-danger">
                                                    <?php if (isset($_GET["valid"]) && $row["valid"] == 0) : ?>
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
                        </div>
                    <?php else : ?>
                    <?php endif; ?>

                    <?php if ($brandCount > 0) : ?>
                        <div class="col-auto">
                            <table class="table table-bordered text-center align-middle">
                                <thead>
                                    <th>編號</th>
                                    <th>品牌</th>
                                    <th>狀態</th>
                                    <th>操作</th>
                                </thead>
                                <?php foreach ($rowBrand as $row) : ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $row["id"] ?></td>
                                            <td><?= $row["name"] ?></td>
                                            <td><?php if ($row["valid"] == 1) : ?>
                                                    使用中
                                                <?php else : ?>
                                                    已停用
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-success" href="editCategory.php?id=<?= $row["id"] ?>&category=2"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="doDeleteCategory.php?id=<?= $row["id"] ?>&valid=<?= $row["valid"] ?>&category=2" class="btn btn-danger">
                                                    <?php if (isset($_GET["valid"]) && $row["valid"] == 0) : ?>
                                                        <i class="fa-solid fa-plus"></i>
                                                    <?php else : ?>
                                                        <i class="fa-solid fa-xmark"></i>
                                                    <?php endif; ?>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php else : ?>
                    <?php endif; ?>

                    <?php if ($pcCount > 0) : ?>
                        <div class="col-auto">
                            <table class="table table-bordered text-center align-middle">
                                <thead>
                                    <th>編號</th>
                                    <th>包裝方式</th>
                                    <th>狀態</th>
                                    <th>操作</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($rowPc as $row) : ?>
                                        <tr>
                                            <td><?= $row["id"] ?></td>
                                            <td><?= $row["name"] ?></td>
                                            <td><?php if ($row["valid"] == 1) : ?>
                                                    使用中
                                                <?php else : ?>
                                                    已停用
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-success" href="editCategory.php?id=<?= $row["id"] ?>&category=3"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="doDeleteCategory.php?id=<?= $row["id"] ?>&valid=<?= $row["valid"] ?>&category=3" class="btn btn-danger">
                                                    <?php if (isset($_GET["valid"]) && $row["valid"] == 0) : ?>
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
                        </div>
                    <?php else : ?>
                    <?php endif; ?>

                    <?php if ($styleCount > 0) : ?>
                        <div class="col-auto">
                            <table class="table table-bordered text-center align-middle">
                                <thead>
                                    <th>編號</th>
                                    <th>茶葉類型</th>
                                    <th>狀態</th>
                                    <th>操作</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($rowStyle as $row) : ?>
                                        <tr>
                                            <td><?= $row["id"] ?></td>
                                            <td><?= $row["name"] ?></td>
                                            <td><?php if ($row["valid"] == 1) : ?>
                                                    使用中
                                                <?php else : ?>
                                                    已停用
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-success" href="editCategory.php?id=<?= $row["id"] ?>&category=4"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="doDeleteCategory.php?id=<?= $row["id"] ?>&valid=<?= $row["valid"] ?>&category=4" class="btn btn-danger">
                                                    <?php if (isset($_GET["valid"]) && $row["valid"] == 0) : ?>
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
                        </div>
                    <?php else : ?>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="text-center mt-5">
                    <h1>無下架分類</h1>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include("../js.php") ?>
</body>

</html>