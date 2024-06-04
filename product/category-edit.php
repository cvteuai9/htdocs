<?php
require_once("../db_connect.php");
if (!isset($_GET["id"]) || !isset($_GET["category"])) {
    echo "請循正常管道進入";
}

$id = $_GET["id"];
$category = $_GET["category"];

switch ($category) {
    case 1:
        $sql = "SELECT * FROM tea_category WHERE id=$id";
        break;
    case 2:
        $sql = "SELECT * FROM brand WHERE id=$id";
        break;
    case 3:
        $sql = "SELECT * FROM pack_category WHERE id=$id";
        break;
    case 4:
        $sql = "SELECT * FROM style WHERE id=$id";
        break;
}

$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en">

<head>
    <title>商品分類列表</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <!-- header aside -->
    <?php include("../dashboard-comm.php") ?>
    <div class="main-content">
        <div class="container-fluid text-center pt-3">
            <h1>編輯商品分類</h1>
        </div>
        <hr>
        <div class="container">
            <a class="btn btn-success" href="product-category.php"><i class="fa-solid fa-arrow-left"></i> 回分類列表</a>

            <div class="row justify-content-around text-nowrap align-middle">
                <div class="col-lg-3">
                    <form action="doEditCategory.php" method="post">
                        <input type="hidden" name="category" value="<?= $category ?>">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <th>編號</th>
                                <th>
                                    <?php
                                    switch ($category) {
                                        case 1:
                                            echo "茶種";
                                            break;
                                        case 2:
                                            echo "品牌";
                                            break;
                                        case 3:
                                            echo "包裝方式";
                                            break;
                                        case 4:
                                            echo "類型";
                                            break;
                                        default:
                                            echo "未知分類";
                                            break;
                                    }
                                    ?>
                                </th>
                                <th>狀態</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $row["id"] ?></td>
                                    <td>
                                        <input class="form-control" type="text" value="<?= $row["name"] ?>" name="name">
                                    </td>
                                    <td>
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="valid" id="flexRadioDefault1" <?php if ($row["valid"] == 1) echo "checked" ?> value="1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    上架
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="valid" id="flexRadioDefault2" <?php if ($row["valid"] == 0) echo "checked" ?> value="0">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    下架
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-end">
                            <button class="btn btn-success" type="submit">送出</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include("../js.php") ?>
</body>

</html>