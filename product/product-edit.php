<?php
require_once("../db_connect.php");

if (!isset($_GET["id"])) {
    echo "無此商品，或您未遵循正常管道進入此頁面";
    exit;
} else {
    $id = $_GET["id"];
}

$sqlTc = "SELECT id, name AS tc_name FROM tea_category";
$sqlBrand = "SELECT id, name AS brand_name FROM brand";
$sqlPack = "SELECT id, name AS pack_name FROM pack_category";
$sqlStyle = "SELECT id, name AS style_name FROM style";

$resultTc = $conn->query($sqlTc);
$resultBrand = $conn->query($sqlBrand);
$resultPack = $conn->query($sqlPack);
$resultStyle = $conn->query($sqlStyle);

$rowsTc = $resultTc->fetch_all(MYSQLI_ASSOC);
$rowsBrand = $resultBrand->fetch_all(MYSQLI_ASSOC);
$rowsPack = $resultPack->fetch_all(MYSQLI_ASSOC);
$rowsStyle = $resultStyle->fetch_all(MYSQLI_ASSOC);


$sql = "SELECT p.id, p.name AS product_name, p.price, p.created_at, p.description, p.weight, p_img.path, p.stock, p.valid, tc.name AS tc_name, b.name AS brand_name, pack.name AS pack_name, style.name AS style_name FROM product_category_relation pcr 
JOIN product_images p_img ON pcr.product_id = p_img.id
JOIN products p ON pcr.product_id = p.id 
JOIN brand b ON pcr.brand_id = b.id 
JOIN tea_category tc ON pcr.tea_id = tc.id
JOIN pack_category pack ON pcr.package_id = pack.id
JOIN style ON pcr.style_id = style.id
WHERE p.id = $id";
$result = $conn->query($sql);
$rowId = $result->fetch_assoc();

?>

<!doctype html>
<html lang="en">

<head>
    <title>編輯商品</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
    <style>
        #preview {
            width: 400px;
            height: 400px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #preview img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <header class="main-header bg-success-subtle d-flex fixed-top shadow justify-content-between align-items-center">
        <a href="dashboard.php" class="google-font fs-5 p-3 text-success bg-success-subtle">
            雅茗
        </a>

        <div class="d-flex align-middle me-3 gap-3">
            <p class="google-font fs-5 m-0 pt-1">Hi,admin</p>
            <a href="" class="btn btn-dark">登入</a>
            <a href="" class="btn btn-dark">登出</a>
        </div>
    </header>

    <aside class="aside-left position-fixed border-end border-3 vh-100 google-font fs-4">

        <ul class="list-unstyled">
            <li>
                <a class="d-block p-2 px-3" href="dashboard.php">
                    <i class="bi bi-house-fill me-2"></i>首頁
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 pmList">
                    <i class="bi bi-cart4 me-2"></i></i>商品管理
                </a>
                <ul class="listWatch deactive list-unstyled ps-5 fs-5 position-relative">
                    <li>
                        <a href="product-list.php"><i class="fa-solid fa-play fs-6"></i> 商品列表</a>
                    </li>
                    <li>
                        <a href="product-add.php"><i class="fa-solid fa-play fs-6"></i> 新增商品</a>
                    </li>
                    <li>
                        <a href="product-category.php"><i class="fa-solid fa-play fs-6"></i> 商品分類管理</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="d-block p-2 px-3" href="">
                    <i class="bi bi-cash me-2"></i>優惠券管理
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3" href="">
                    <i class="bi bi-flag me-2"></i>課程管理
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3" href="">
                    <i class="bi bi-clipboard2-data me-2"></i>訂單管理
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3" href="">
                    <i class="bi bi-book me-2"></i>文章管理
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3" href="">
                    <i class="bi bi-paypal me-2"></i>付款方式
                </a>
            </li>

        </ul>
    </aside>
    <main class="main-content p-3">
        <!-- 返回商品列表按鈕 -->
        <div class="container-fluid mb-2">
            <div class="text-center m-0">
                <h1>商品編輯頁</h1>
            </div>
            <div>
                <a class="btn btn-success fs-5 mb-3" href="product-list.php?page=1&order=1">
                    <i class="fa-solid fa-arrow-left"></i> 返回商品列表
                </a>
            </div>
            <div>
                <a class="btn btn-success fs-5 mb-3" href="product-detail.php?id=<?= $rowId["id"] ?>">
                    <i class="fa-solid fa-arrow-left"></i> 返回商品詳情
                </a>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row justify-content-start">

                <!-- 商品圖片預覽區 -->
                <div class="col-lg-4 d-flex flex-column align-items-center">
                    <div id="preview">
                        <img src="../product_images/<?= $rowId["path"] ?>" alt="">
                    </div>
                    <div class="h4 mt-1">圖片預覽</div>
                </div>

                <div class="col-lg-6">
                    <!-- 編輯商品表單 -->
                    <form action="doProductUpdate.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $rowId["id"] ?>">
                        <table class="table table-bordered align-middle text-center">
                            <!-- 商品圖片 -->
                            <tr>
                                <th>商品圖片</th>
                                <td>
                                    <!-- accept 限制檔案類型，image/* 所有image的類型都可上傳 -->
                                    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)" required>
                                </td>
                            </tr>

                            <!-- 商品名稱 -->
                            <tr>
                                <th>商品名稱</th>
                                <td>
                                    <div class="text-end">
                                        <p class="ps-2 m-1 ">(原) : <span class="text-success text-decoration-underline"><?= $rowId["product_name"] ?></span></p>
                                    </div>
                                    <input class="form-control" type="text" name="product_name" placeholder="請輸入商品名稱..." value="<?= $rowId["product_name"] ?>">
                                </td>
                            </tr>

                            <!-- 品牌 -->
                            <tr>
                                <th>品牌</th>
                                <td>
                                    <div class="text-end">
                                        <p class="ps-2 m-1">(原) : <span class="text-success text-decoration-underline"><?= $rowId["brand_name"] ?></span></p>
                                    </div>
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="brand_id">
                                            <?php foreach ($rowsBrand as $row) : ?>
                                                <option value="<?= $row["id"] ?>" <?php if ($rowId["brand_name"] == $row["brand_name"]) echo "selected" ?>><?= $row["brand_name"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="floatingSelect">更改品牌</label>
                                    </div>
                                </td>
                            </tr>

                            <!-- 茶種 -->
                            <tr>
                                <th>茶種</th>
                                <td>
                                    <div class="text-end">
                                        <p class="ps-2 m-1">(原) : <span class="text-success text-decoration-underline"><?= $rowId["tc_name"] ?></span></p>
                                    </div>
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="tea_id">
                                            <?php foreach ($rowsTc as $row) : ?>
                                                <option value="<?= $row["id"] ?>" <?php if ($rowId["tc_name"] == $row["tc_name"]) echo "selected" ?>><?= $row["tc_name"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="floatingSelect">更改茶種</label>
                                    </div>
                                </td>
                            </tr>

                            <!-- 包裝方式 -->
                            <tr>
                                <th>包裝方式</th>
                                <td>
                                    <div class="text-end">
                                        <p class="ps-2 m-1">(原) : <span class="text-success text-decoration-underline"><?= $rowId["pack_name"] ?></span></p>
                                    </div>
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="pack_id">
                                            <?php foreach ($rowsPack as $row) : ?>
                                                <option value="<?= $row["id"] ?>" <?php if ($rowId["pack_name"] == $row["pack_name"]) echo "selected" ?>><?= $row["pack_name"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="floatingSelect">更改包裝方式</label>
                                    </div>
                                </td>
                            </tr>

                            <!-- 茶葉類型 -->
                            <tr>
                                <th>類型</th>
                                <td>
                                    <div class="text-end">
                                        <p class="ps-2 m-1">(原) : <span class="text-success text-decoration-underline"><?= $rowId["style_name"] ?></span></p>
                                    </div>
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="style_id">
                                            <?php foreach ($rowsStyle as $row) : ?>
                                                <option value="<?= $row["id"] ?>"><?= $row["style_name"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="floatingSelect">更改茶葉類型</label>
                                    </div>
                                </td>
                            </tr>

                            <!-- 商品描述 -->
                            <tr>
                                <th>商品描述</th>
                                <td>
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px" name="description"><?= $rowId["description"] ?></textarea>
                                    </div>

                                </td>
                            </tr>

                            <!-- 重量 -->
                            <tr>
                                <th>重量</th>
                                <td>
                                    <div class="text-end">
                                        <p class="ps-2 m-1">(原) : <span class="text-success text-decoration-underline"><?= $rowId["weight"] ?></span></p>
                                    </div>
                                    <input class="form-control" type="text" name="weight" placeholder="請輸入重量..." value="<?= $rowId["weight"] ?>">
                                </td>
                            </tr>

                            <!-- 單價 -->
                            <tr>
                                <th>單價</th>
                                <td>
                                    <div class="text-end">
                                        <p class="ps-2 m-1">(原) : <span class="text-success text-decoration-underline"><?= $rowId["price"] ?></span></p>
                                    </div>
                                    <input class="form-control" type="number" name="price" placeholder="請輸入單價金額..." value="<?= $rowId["price"] ?>">
                                </td>
                            </tr>

                            <!-- 庫存 -->
                            <tr>
                                <th>庫存</th>
                                <td>
                                    <div class="text-end">
                                        <p class="ps-2 m-1">(原) : <span class="text-success text-decoration-underline"><?= $rowId["stock"] ?></span></p>
                                    </div>
                                    <input class="form-control" type="number" name="stock" placeholder="請輸入庫存數量..." value="<?= $rowId["stock"] ?>">
                                </td>
                            </tr>
                            <!-- 狀態 -->
                            <tr>
                                <th>狀態</th>
                                <td>
                                    <div class="text-end">
                                        <p class="ps-2 m-1">(原) :
                                            <span class="text-success text-decoration-underline">
                                                <?php if ($rowId["valid"] == 1) : ?>
                                                    上架
                                                <?php else : ?>
                                                    下架
                                                <?php endif; ?>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="valid" id="flexRadioDefault1" <?php if ($rowId["valid"] == 1) echo "checked" ?> value="1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                上架
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="valid" id="flexRadioDefault2" <?php if ($rowId["valid"] == 0) echo "checked" ?> value="0">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                下架
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="text-end">
                            <button class="btn btn-success" type="submit">送出</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Javascript -->
    <?php include("../js.php") ?>
    <script>
        const pmList = document.querySelector(".pmList")
        const listWatch = document.querySelector(".listWatch")


        pmList.addEventListener("click", function() {
            listWatch.classList.toggle("deactive");
            listWatch.classList.toggle("list-active");
        })
        // 圖片預覽函式
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const img = document.createElement('img');
                img.src = reader.result;
                preview.innerHTML = '';
                preview.appendChild(img);
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>